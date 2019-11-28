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
 * The Moments Model
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class MomentsModel extends BaseModel
{
    // set main table
    public function __construct()
    {
        parent::__construct('moments');
    }
    
    // if the 'moment' info is valid
    public function isValid($momentInfo, $imgUrls)
    {
        if (!is_array($imgUrls)) {
            return 'INVALID_IMG_ATTRS';
        }
        foreach ($imgUrls as $img) {
            if (!is_string($img)) {
                return 'INVALID_IMG_ATTRS';
            }
        }

        $rules = [
            'pictureNumber' => count($imgUrls) <= intval(R::M('Option')->get('striverboard.photoLimit')),
            'description' => !empty($momentInfo->description),
            'field' => R::M('Field')->fieldExists($momentInfo->field)
        ];
        foreach ($rules as $field => $rule) {
            if (!$rule) {
                return 'INVALID_' . $field;
            }
        }
        
        return true;
    }

    // post a moment
    public function postMoment($momentInfo, $imgUrls)
    {
        $data = [
            'uid' => $momentInfo->uid,
            'description' => $momentInfo->description,
            'location_lng' => floatval($momentInfo->locationLng ? $momentInfo->locationLng : 360),
            'location_lat' => floatval($momentInfo->locationLat ? $momentInfo->locationLat : 360),
            'time' => time(),
            'visibility' => ($momentInfo->visibility == 'public') ? 'public' : 'private',
            'achieved' => $momentInfo->achieved ? 1 : 0,
            'significant' => 0,
            'fid' => $momentInfo->field
        ];
        $insertMoment = $this->insert($data)->execute();
        if (!$insertMoment) {
            return 'ERROR_INSERT_MOMENT';
        }
        
        $id = $this->lastInsertId();
        foreach ($imgUrls as $imgUrl) {
            $data = [
                'mid' => $id,
                'url' => $imgUrl
            ];
            if (!$this->insert($data, 'moments_photos')->execute()) {
                return 'ERROR_INSERT_MOMENT_PHOTO';
            }
        }

        $words = WordProcessAdapter::getKeywords($momentInfo->description);
        foreach ($words as $word => [, $idf]) {
            if (!$word || V::countCharNum($word) >= 12) {
                continue;
            }
            $times = $this->select('times', 'moments_words')->condition(['word' => $word])->limit(1)->fetchColumn();
            $updateWords = $times
                ? $this->modify(['times' => intval($times) + 1], 'moments_words')
                        ->condition(['word' => $word])
                        ->limit(1)->execute()
                : $this->insert(['times' => 1, 'word' => $word, 'idf' => $idf], 'moments_words')->execute();
            if (!$updateWords) {
                return 'ERROR_UPDATE_WORDS';
            }
        }

        return intval($id);
    }

    // (un)mark a moment as significant
    public function markSignificant($mid, $significant)
    {
        $significant = (bool) $significant;
        $mid = intval($mid);
        return $this
                ->modify(['significant' => $significant], 'moments_photos')
                ->condition(['mid' => $mid])
                ->limit(1);
    }

    // get the owner of a moment
    public function getOwner($mid)
    {
        return $this->translate(intval($mid), 'mid', 'uid');
    }

    // delete a moment
    public function deleteMoment($mid)
    {
        $mid = intval($mid);
        $deleteMoment = $this->delete()->condition(['mid' => $mid])->limit(1);
        if (!$deleteMoment) {
            return 'ERROR_DELETE_MOMENT';
        }

        $deletePhoto = $this->delete('moments_photos')->condition(['mid' => $mid])->limit(1);
        if (!$deletePhoto) {
            return 'ERROR_DELETE_MOMENT_PHOTO';
        }

        return true;
    }

    // modify a moment
    public function modifyMoment($momentInfo)
    {
        return $this->modify([
            'description' => intval($momentInfo->description),
            'visibility' => $momentInfo->visibility == 'public' ? 'public' : 'private',
            'achieved' => (bool) $momentInfo->achieved
        ])->condition(['mid' => $momentInfo->mid])->limit(1)->execute();
    }

    // get the visibility of a moment (if $uid can visit the moment $mid)
    public function visible($uid, $mid)
    {
        $conditions = ['mid' => $mid];
        if (!R::M('User')->isAdmin($uid)) {
            $conditions['visibility'] = 'public';
        }
        return $this->exists($conditions);
    }

    // is the time range valid
    public function isTimeRangeValid($from, $to)
    {
        $leastTime = time() - 365 * 24 * 3600;
        return V::number($from, $leastTime, $to) && V::number($to);
    }

    // calc the distance
    private function _distance($p1, $p2)
    {
        [$lat1, $lng1] = [deg2rad($p1[0]), deg2rad($p1[1])];
        [$lat2, $lng2] = [deg2rad($p2[0]), deg2rad($p2[1])];
        [$d1, $d2] = [$lat1 - $lat2, $lng1 - $lng2];
        return 2 * 6378.137 * asin(sqrt(pow(sin($d1 / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($d2 / 2), 2)));
    }

    // generate time range condition
    public function generateTimeRangeCondition($fromTime, $toTime)
    {
        return [
            'time >' => intval($fromTime),
            'time <' => intval($toTime)
        ];
    }

    // get all nearby moments (in 1 month)
    public function getNearestMoments($userLocation)
    {
        $conditions['ABS(location_lng-360) >'] = 1e-5;
        $conditions['ABS(location_lat-360) >'] = 1e-5;
        $conditions['time >='] = time() - 30 * 24 * 3600;
        $conditions['visibility'] = 'public';

        $data = $this->select(['mid', 'location_lng', 'location_lat'])->condition($conditions)->fetchAll();

        $userLng = floatval($userLocation->lng);
        $userLat = floatval($userLocation->lat);

        $results = [];
        $distances = [];
        $pos = [];

        foreach ($data as $row) {
            [$mid, $lng, $lat] = [$row['mid'], $row['location_lng'], $row['location_lat']];
            $result = new stdClass;
            $result->mid = intval($mid);
            $result->lng = floatval($lng);
            $result->lat = floatval($lat);
            $result->distance = $this->_distance([$userLng, $userLat], [$lng, $lat]);
            $results[] = $result;
            $distances[$result->mid] = $result->distance;
        }
        
        usort($results, function ($x, $y) {
            return $x->distance <=> $y->distance;
        });

        $total = count($results);
        for ($i = 0; $i < $total; $i++) {
            $pos[$results[$i]->mid] = $i;
        }
        
        $results = array_slice($results, 0, 10);
        
        $mids = array_column($results, 'mid');
        $fields = [
            'mid',
            'description',
            'time',
            'uid',
            'achieved',
            'significant',
            'fid'
        ];
        $moments = $this->select($fields)->condition(['mid IN' => $mids])->fetchAll();

        $results = [];
        foreach ($moments as $moment) {
            $result = new stdClass;
            $result->mid = intval($moment['mid']);
            $result->description = $moment['description'];
            $result->time = intval($moment['time']);
            $result->uid = intval($moment['uid']);
            $result->achieved = (bool) $moment['achieved'];
            $result->significant = (bool) $moment['significant'];
            $result->distance = $distances[$result->mid];
            $result->realName = R::M('User')->getRealName($result->uid);
            $result->imgs = array_column($this->getPhotos($result->mid), 'url');
            $result->fid = intval($moment['fid']);
            $result->field = R::M('Field')->getNameById($result->fid);
            $results[$pos[$result->mid]] = $result;
        }

        $sorted = [];
        $total = count($results);
        for ($i = 0; $i < $total; $i++) {
            $sorted[] = $results[$i];
        }

        return $sorted;
    }

    // get all locations for statistics data (in 1 year)
    public function getLocations()
    {
        $conditions['time >='] = time() - 365 * 24 * 3600;
        $conditions['ABS(location_lng-360) >'] = 1e-5;
        $conditions['ABS(location_lat-360) >'] = 1e-5;
        $location = $this->select(['location_lng', 'location_lat'])->condition($conditions)->result();
        
        $map = [];
        while ($result = $location->fetch()) {
            [$lng, $lat] = [sprintf('%.3f', $result['location_lng']), sprintf('%.3f', $result['location_lat'])];
            $hash = md5($lng . '_' . $lat);
            if (!isset($map[$hash])) {
                $map[$hash] = new stdClass;
                $map[$hash]->times = 1;
            }
            $map[$hash]->lng = $lng;
            $map[$hash]->lat = $lat;
            $map[$hash]->times++;
        }
        
        // trick: reset the index, from MD5 to 0~n
        usort($map, function ($a, $b) {
            return $a->times <=> $b->times;
        });

        return $map;
    }

    // get the moment count, group by field
    public function getMomentCountGroupByField()
    {
        $count = $this->select(['count(*) AS cnt', 'fid'])->groupBy('fid')->fetchAll();
        $results = [];
        foreach ($count as $value) {
            $result = new stdClass;
            $result->cnt = intval($value['cnt']);
            $result->fid = intval($value['fid']);
            $result->name = $this->translate($value['fid'], 'fid', 'name', 'fields');
            $results[] = $result;
        }
        return $results;
    }

    // get photos of a moment
    public function getPhotos($mid)
    {
        $mid = intval($mid);
        $pictures = $this
                    ->select(['url', 'pid'], 'moments_photos')
                    ->condition(['mid' => $mid])
                    ->fetchAll();
        $results = [];
        foreach ($pictures as $picture) {
            $result = new stdClass;
            $result->url = $picture['url'];
            $result->pid = $picture['pid'];
            $results[] = $result;
        }
        return $results;
    }

    // get top 8 moments words, using TF-IDF
    public function hotMomentsWords()
    {
        $words = $this->select(['word', 'times', 'idf'], 'moments_words')->fetchAll();
        $sum = 0;
        foreach ($words as $word) {
            $sum += intval($word['times']);
        }
        $tfIdf = [];
        foreach ($words as $word) {
            $tfIdf[$word['word']] = intval($word['times']) / $sum * $word['idf'];
        }
        arsort($tfIdf);
        return array_slice($tfIdf, 0, 8, true);
    }

    // get all moments
    public function getMoments($uid, $showAttributes)
    {
        $uid = intval($uid);
        
        $me = $this;
        $getPhotosList = function ($mid) use ($me) {
            $results = [];
            $details = $me->getPhotos($mid);
            foreach ($details as $detail) {
                $results[] = $detail->url;
            }
            return $results;
        };

        $fields = [
            'mid',
            'description',
            'time',
            'uid',
            'visibility',
            'achieved',
            'significant'
        ];

        $conditions = [];
        if ($showAttributes->uid) {
            $conditions['uid'] = $showAttributes->uid;
        }
        if ($showAttributes->onlySignificant) {
            $conditions['significant'] = true;
        }
        if ($showAttributes->timeRange) {
            $conditions['time >'] = $showAttributes->timeRange->from;
            $conditions['time <'] = $showAttributes->timeRange->to;
        }
        if ($uid) {
            if (!R::M('User')->isAdmin($uid)) {
                $conditions['OR'] = [
                'visibility' => 'public',
                'uid' => $uid
            ];
            }
        } else {
            $conditions['visibility'] = 'public';
        }
        if ($showAttributes->achieved !== null) {
            $conditions['achieved'] = (bool) ($showAttributes->achieved);
        }
        if ($showAttributes->fid) {
            $conditions['fid'] = intval($showAttributes->fid);
        }

        $page = intval($showAttributes->page);
        $pageSize = intval($showAttributes->pageSize);
        $offset = ($page - 1) * $pageSize;

        $details = $this
                    ->select($fields)
                    ->condition($conditions)
                    ->order(['time DESC', 'uid ASC', 'mid DESC'])
                    ->limit(abs($offset), abs($pageSize))
                    ->fetchAll();

        $results = [];
        foreach ($details as $detail) {
            $result = new stdClass;
            $result->description = $detail['description'];
            $result->time = intval($detail['time']);
            $result->uid = intval($detail['uid']);
            $result->visibility = $detail['visibility'] == 'public' ? 'public' : 'private';
            $result->significant = (bool) $detail['significant'];
            $result->imgs = $getPhotosList($detail['mid']);
            $result->mid = intval($detail['mid']);
            $result->realName = R::M('User')->getRealName($result->uid);
            $result->achieved = (bool) $detail['achieved'];
            $results[] = $result;
        }
                   
        return $results;
    }

    // get a moment
    public function getMoment($mid)
    {
        $mid = intval($mid);

        $fields = [
            'description',
            'time',
            'uid',
            'visibility',
            'significant',
            'mid',
            'achieved'
        ];

        $moment = $this->select($fields)->condition(['mid' => $mid])->limit(1)->fetch();
        if (!$moment) {
            return false;
        }

        $result = new stdClass;
        $result->description = $moment['description'];
        $result->time = intval($moment['time']);
        $result->uid = intval($moment['uid']);
        $result->realName = R::M('User')->getRealName($result->uid);
        $result->visibility = $moment['visibility'] == 'public' ? 'public' : 'private';
        $result->significant = (bool) $moment['significant'];
        $result->imgs = array_column($this->getPhotos($mid), 'url');
        $result->mid = $mid;
        $result->achieved = (bool) $moment['achieved'];

        return $result;
    }
}
