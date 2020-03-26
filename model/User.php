<?php
/*
 * Product by HelloWorld team
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * Licensed under the Apache License, Version 2.0 (the "License");         * *
 * * you may not use this file except in compliance with the License.        * *
 * * You may obtain a copy of the License at                                 * *
 * *   http://www.apache.org/licenses/LICENSE-2.0                            * *
 * * Unless required by applicable law or agreed to in writing, software     * *
 * * distributed under the License is distributed on an "AS IS" BASIS,       * *
 * * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.* *
 * * See the License for the specific language governing permissions and     * *
 * * limitations under the License.                                          * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * The User Model
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class UserModel extends BaseModel
{
    // set main table
    public function __construct()
    {
        parent::__construct('users');
    }

    // password encrypt
    public function passwordEncrypt($password, $uid)
    {
        return md5($password . '___' . $uid);
    }

    // is the phone exists
    public function phoneExists($phone)
    {
        $phone = intval($phone);
        return $this->exists(['phone' => $phone]);
    }

    // is the uid exists
    public function uidExists($uid)
    {
        $uid = intval($uid);
        return $this->exists(['uid' => $uid]);
    }

    // is user's registration/updating information valid
    public function isValid($inputMsgVerifyCode, $userInfo)
    {
        $rules = [
            'realName' => V::chinese($userInfo->realName, 2, 12),
            'password' => isset($userInfo->password) ? V::all($userInfo->password, 5) : true,
            'phone' => V::number($userInfo->phone, 10000000000, 99999999999) && !$this->phoneExists($userInfo->phone),
            'mission' => V::all($userInfo->mission, 2, 200),
            'fid' => R::M('Field')->exists($userInfo->fid),
            'institution' => V::chinese($userInfo->institution, 2, 22),
            'msgVerifyCode' => R::config('site')->demoMode ? true : R::M('MessageVerify')->check($userInfo->phone, $inputMsgVerifyCode, 'userRegister')
        ];

        foreach ($rules as $field => $valid) {
            if (!$valid) {
                return 'INVALID_' . $field;
            }
        }

        return true;
    }

    // log in
    public function login($inputPhone, $inputPassword, $inputMsgVerifyCode)
    {
        $args = $this->select(['uid', 'password', 'phone'])->condition(['phone' => $inputPhone])->limit(1)->fetch();
        if (!$args) {
            return false;
        }
        if ($inputPassword) {
            return $this->passwordEncrypt($inputPassword, $args['uid']) == $args['password'] ? intval($args['uid']) : false;
        }
        if ($inputMsgVerifyCode) {
            return R::M('MessageVerify')->check($args['phone'], $inputMsgVerifyCode, 'userLogin') ? intval($args['uid']) : false;
        }
        return false;
    }

    // send registration message verify code
    public function sendRegistrationMsgVerifyCode($phone)
    {
        return R::M('MessageVerify')->sendVerifyCode($phone, 'userRegister');
    }

    // send login verify code to a user
    public function sendLoginMsgVerifyCode($phone)
    {
        $phone = $this->select('phone')->condition(['phone' => $phone])->limit(1)->fetchColumn();
        if (!$phone) {
            return false;
        }
        return R::M('MessageVerify')->sendVerifyCode($phone, 'userLogin');
    }

    // send update verify code to a user
    public function sendUpdateMsgVerifyCode($uid)
    {
        $phone = $this->select('phone')->condition(['uid' => $uid])->limit(1)->fetchColumn();
        if (!$phone) {
            return false;
        }
        return R::M('MessageVerify')->sendVerifyCode($phone, 'userUpdate');
    }

    // if a user is an admin
    public function isAdmin($uid)
    {
        return $this->exists(['uid' => $uid, 'admin' => 1]);
    }

    // get user info
    public function getUserInfo($uid)
    {
        $info = $this
                ->select(['uid', 'real_name', 'mission', 'description', 'moments_visibility', 'institution', 'fid', 'admin'])
                ->condition(['uid' => $uid])
                ->fetch();
        $result = new stdClass;
        $result->uid = intval($info['uid']);
        $result->realName = $info['real_name'];
        $result->mission = $info['mission'];
        $result->institution = $info['institution'];
        $result->fid = intval($info['fid']);
        $result->field = R::M('Field')->getNameById($info['fid']);
        $result->description = $info['description'];
        $result->admin = (bool) $info['admin'];
        $result->momentsVisibility = $info['moments_visibility'];
        return $result;
    }

    // get the real name of a user
    public function getRealName($uid)
    {
        return $this->translate($uid, 'uid', 'real_name');
    }

    // register
    public function register($userInfo)
    {
        $insert = $this->insert([
            'real_name' => $userInfo->realName,
            'password' => $this->passwordEncrypt(uniqid(), 0),
            'phone' => intval($userInfo->phone),
            'mission' => $userInfo->mission,
            'fid' => intval($userInfo->fid),
            'institution' => $userInfo->institution,
            'description' => ''
        ])->execute();
        if (!$insert) {
            return 'ERROR_INSERT_USER';
        }
        $uid = $this->lastInsertId();

        $updatePassword = $this
                            ->modify(['password' => $this->passwordEncrypt($userInfo->password, $uid)])
                            ->condition(['uid' => $uid])
                            ->limit(1)
                            ->execute();
        if (!$updatePassword) {
            return 'ERROR_UPDATING_PASSWORD';
        }

        $words = WordProcessAdapter::getKeywords($userInfo->mission, 48, false);
        foreach ($words as $word => [$tf, $idf]) {
            if (!$word || V::countCharNum($word) >= 12) {
                continue;
            }
            $insertWords = $this->insertIgnore([
                'uid' => $uid,
                'word' => $word,
                'tf_idf' => $tf * $idf
            ], 'mission_words_index')->execute();
            if (!$insertWords) {
                return 'ERROR_INSERT_WORDS';
            }
        }

        $keywords = WordProcessAdapter::getKeywords($userInfo->mission, 20, true);
        foreach ($keywords as $word => [$tf, $idf]) {
            if (!$word || V::countCharNum($word) >= 12) {
                continue;
            }
            $updateWords = $this
                            ->insert(['times' => 1, 'word' => $word, 'idf' => $idf], 'mission_words')
                            ->onDuplicateKey('times = times + 1')
                            ->execute();
            if (!$updateWords) {
                return 'ERROR_UPDATE_WORDS';
            }
            $insertWords = $this->insertIgnore([
                'uid' => $uid,
                'word' => $word,
                'tf_idf' => $tf * $idf
            ], 'mission_keywords')->execute();
            if (!$insertWords) {
                return 'ERROR_INSERT_WORDS';
            }
        }

        return true;
    }

    // update user information
    public function update($uid, $userInfo)
    {
        $update = $this->modify([
            'real_name' => $userInfo->realName,
            'password' => $this->passwordEncrypt($userInfo->password, $uid),
            'phone' => intval($userInfo->phone),
            'fid' => intval($userInfo->fid),
            'institution' => $userInfo->institution,
            'description' => $userInfo->description,
            'moments_visibility' => $userInfo->momentsVisibility ? 1 : 0
        ])->condition(['uid' => $uid])->limit(1)->execute() !== false;
        return $update;
    }

    // get top 15 mission words, using TF-IDF
    public function hotMissionWords()
    {
        $words = $this->select(['word', 'times', 'idf'], 'mission_words')->fetchAll();
        $sum = 0;
        foreach ($words as $word) {
            $sum += intval($word['times']);
        }
        $tfIdf = [];
        foreach ($words as $word) {
            $tfIdf[$word['word']] = intval($word['times']) / $sum * $word['idf'];
        }
        arsort($tfIdf);
        return array_slice($tfIdf, 0, 15, true);
    }

    // get the mission words of a user
    public function getMissionWords($uid)
    {
        $statement = $this->select('word', 'mission_keywords')->condition(['uid' => $uid])->limit(20)->result();
        $words = [];
        while ($word = $statement->fetchColumn()) {
            $words[] = $word;
        }
        return $words;
    }

    // compare the mission similarity between two users
    public function getMissionSimilarity($uid1, $uid2)
    {
        $uid1 = intval($uid1);
        $uid2 = intval($uid2);

        // get from redis
        $rkey = 'mission_similarity_' . $uid1 . '_' . $uid2;
        if (RedisComponent::exists($rkey)) {
            return floatval(RedisComponent::get($rkey));
        }

        // get from database cache
        $similarity = $this->select('similarity', 'user_similarity_cache')->condition(['uid1' => $uid1, 'uid2' => $uid2])->fetchColumn();
        if ($similarity !== false) {
            $res = floatval($similarity);
            RedisComponent::set($rkey, $res);
            return $res;
        }

        // if cache not exists, do calculate

        if (!$this->uidExists($uid1) || !$this->uidExists($uid2)) {
            return false;
        }
        
        $wordsUnion = [];

        $words = $this
                    ->select(['word', 'tf_idf'], 'mission_words_index')
                    ->condition(['uid' => $uid1])
                    ->fetchAll();
        $words1 = [];
        foreach ($words as $word) {
            $words1[$word['word']] = $word['tf_idf'];
            $wordsUnion[] = $word['word'];
        }

        $words = $this
                    ->select(['word', 'tf_idf'], 'mission_words_index')
                    ->condition(['uid' => $uid2])
                    ->fetchAll();
        $words2 = [];
        foreach ($words as $word) {
            $words2[$word['word']] = $word['tf_idf'];
            $wordsUnion[] = $word['word'];
        }

        $wordsUnion = array_unique($wordsUnion);
        $dot = 0;
        $d1 = $d2 = 0;
        foreach ($wordsUnion as $word) {
            $words1[$word] = isset($words1[$word]) ? $words1[$word] : 0;
            $words2[$word] = isset($words2[$word]) ? $words2[$word] : 0;
            $dot += $words1[$word] * $words2[$word];
            $d1 += $words1[$word] * $words1[$word];
            $d2 += $words2[$word] * $words2[$word];
        }

        $similarity = ($d1 && $d2) ? ($dot / sqrt($d1) / sqrt($d2)) : 0;

        // write back the cache
        RedisComponent::set($rkey, $similarity);
        $this->insertIgnore([
            'uid1' => $uid1,
            'uid2' => $uid2,
            'similarity' => $similarity
        ], 'user_similarity_cache')->execute();
        $this->insertIgnore([
            'uid1' => $uid2,
            'uid2' => $uid1,
            'similarity' => $similarity
        ], 'user_similarity_cache')->execute();

        return $similarity;
    }

    // search users
    public function searchUsers($uid, $keyword = null)
    {
        $conditions = ['uid' => $uid];
        $keyword = trim($keyword);

        $info = $this->select(['fid', 'institution'])->condition($conditions)->fetch();
        if (!$info) {
            return false;
        }

        if (!$keyword) {
            [$fid, $institution] = [$info['fid'], $info['institution']];
                
            $users = $this->select('uid')->condition([
            'OR' => [
                'fid' => $fid,
                'institution' => $institution
            ],
            'uid <>' => $uid
        ])->result();
        } else {
            $users = $this->select('uid')->condition([
                    'phone' => $keyword,
                    'real_name LIKE' => '%' . $keyword . '%'
            ], 'OR')->result();
        }
        
        $results = [];

        for (; $uid1 = $users->fetchColumn();) {
            $user = new stdClass;
            $user->uid = $uid1;
            $user->similarity = $this->getMissionSimilarity($uid, $uid1);
            $results[] = $user;
        }

        usort($results, function ($a, $b) {
            return -($a->similarity <=> $b->similarity);
        });
        
        $results = array_slice($results, 0, 12);
        
        foreach ($results as $key => $result) {
            $results[$key]->info = $this->getUserInfo($result->uid);
        }

        return $results;
    }

    // get new users
    public function getNewUsers($number = 3)
    {
        $result = $this->select('uid')->order('uid DESC')->limit($number)->result();
        $users = [];
        while ($uid = $result->fetchColumn()) {
            $users[] = $this->getUserInfo($uid);
        }
        return $users;
    }

    // build user graph G=(V,E)
    // If the similiarity between two users > 0.4, we can say they're connected (formed an graph)
    public function buildUserGraph($lowerbound = 0.4)
    {
        $result = $this->select('uid')->order('uid DESC')->limit(300)->result();

        $uids = [];
        while ($uid = $result->fetchColumn()) {
            $uids[] = intval($uid);
        }

        $unionSet = new UnionSetComponent($uids);

        $edges = [];
        $total = count($uids);
        for ($i = 0; $i < $total; $i++) {
            for ($j = $i + 1; $j < $total; $j++) {
                $uid1 = $uids[$i];
                $uid2 = $uids[$j];

                if ($unionSet->query($uid1, $uid2)) {
                    continue;
                }

                $similarity = $this->getMissionSimilarity($uid1, $uid2);
                if ($similarity > $lowerbound) {
                    $edge = new stdClass;
                    $edge->from = 'N' . ((string) $uid1);
                    $edge->to = 'N' . ((string) $uid2);
                    $edge->weight = $similarity;
                    $edges[] = $edge;
                    
                    $unionSet->merge($uid1, $uid2);
                }
            }
        }

        $vertexes = [];
        foreach ($uids as $uid) {
            $vertex = new stdClass;
            $vertex->node = 'N' . ((string) $uid);
            $vertex->attributes = $this->getUserInfo($uid);
            $vertexes[] = $vertex;
        }

        return [$vertexes, $edges];
    }
}
