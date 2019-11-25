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
            'msgVerifyCode' => IN_DEBUG ? true : R::M('MessageVerify')->check($userInfo->phone, $inputMsgVerifyCode, 'userRegister')
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

        $words = WordProcessAdapter::getKeywords($userInfo->mission);
        foreach ($words as $word => [$tf, $idf]) {
            if (!$word || V::countCharNum($word) >= 12) {
                continue;
            }
            $times = $this->select('times', 'mission_words')->condition(['word' => $word])->limit(1)->fetchColumn();
            $updateWords = $times
                ? $this->modify(['times' => intval($times) + 1], 'mission_words')
                        ->condition(['word' => $word])
                        ->limit(1)->execute()
                : $this->insert(['times' => 1, 'word' => $word, 'idf' => $idf], 'mission_words')->execute();
            if (!$updateWords) {
                return 'ERROR_UPDATE_WORDS';
            }
            $insertWords = $this->insert([
                'uid' => $uid,
                'word' => $word,
                'tf_idf' => $tf * $idf
            ], 'mission_words_index')->execute();
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
            'password' => passwordEncrypt($userInfo->password, $uid),
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
        $statement = $this->select('word', 'mission_words_index')->condition(['uid' => $uid])->result();
        $words = [];
        while ($word = $statement->fetchColumn()) {
            $words[] = $word;
        }
        return $words;
    }

    // compare the mission similarity between two users
    public function getMissionSimilarity($uid1, $uid2)
    {
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
        foreach ($words2 as $word) {
            $words2[$word['word']] = $words['tf_idf'];
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

        if (!$d1 || !$d2) {
            return INF;
        }
        return $dot / sqrt($d1) / sqrt($d2);
    }

    // get recommended users for a user
    public function getRecommendedUsers($uid)
    {
        $info = $this->select(['fid', 'institution'])->condition(['uid' => $uid])->fetch();
        if (!$info) {
            return false;
        }
        [$fid, $institution] = [$info['fid'], $info['institution']];
        
        $sameFieldUsersData = $this->select('uid')->condition(['fid' => $fid])->result();
        $sameInstitutionUsersData = $this->select('uid')->condition(['institution' => $institution])->result();

        $sameFieldUsers = [];
        for (; $uid1 = $sameFieldUsersData->fetchColumn();) {
            $sameFieldUser = new stdClass;
            $sameFieldUser->uid = $uid1;
            $sameFieldUser->similarity = $this->getMissionSimilarity($uid, $uid1);
            $sameFieldUsers[] = $sameFieldUser;
        }
        usort($sameFieldUsers, function ($a, $b) {
            return $a->similarity <=> $b->similarity;
        });

        $sameInstitutionUsers = [];
        for (; $uid1 = $sameInstitutionUsersData->fetchColumn();) {
            $sameInstitutionUser = new stdClass;
            $sameInstitutionUser->uid = $uid1;
            $sameInstitutionUser->similarity = $this->getMissionSimilarity($uid, $uid1);
            $sameInstitutionUsers[] = $sameInstitutionUser;
        }
        usort($sameInstitutionUsers, function ($a, $b) {
            return $a->similarity <=> $b->similarity;
        });

        return [$sameFieldUsers, $sameInstitutionUsers];
    }
}