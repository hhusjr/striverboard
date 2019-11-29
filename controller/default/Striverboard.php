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
 * The Striverboard controller
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class StriverboardController extends CommonController
{
    // Index action (default action)
    public function onIndex()
    {
        $loginUserId = $this->loginUserId();
        if ($loginUserId) {
            $missionWords = R::M('User')->getMissionWords($loginUserId);
        }
        $timelineView = F::get('timeline');

        $assigns = new stdClass;
        $assigns->missionWords = (isset($missionWords) ? $missionWords : []);
        $assigns->fields = R::M('Field')->getFields();
        $assigns->timelineView = (bool) $timelineView;
        $assigns->uid = F::get('uid');
        $assigns->significant = F::get('significant');
        $assigns->achieved = F::get('achieved');
        $assigns->field = F::get('fid');
        $this->show('striverboard', $assigns);
    }

    // add moment action
    public function onAjaxPostMoment()
    {
        $this->needAjax();
        $this->needPost();

        $uid = $this->needLogin();
        $visibility = F::post('visibility');
        $achieved = F::post('achieved');
        $locationLng = F::post('lng');
        $field = F::post('field');
        // some users won't give access to open GPS
        if (!$locationLng) {
            $locationLng = null;
        }
        $locationLat = F::post('lat');
        if (!$locationLat) {
            $locationLat = null;
        }
        $imgs = F::post('imgs');
        if (!$imgs) {
            $imgs = [];
        }
        if (!is_array($imgs)) {
            $this->json(['success' => false]);
        }
        foreach ($imgs as $img) {
            if (!$img) {
                $this->json(['success' => false]);
            }
        }
        $description = F::post('description');
        $data = new stdClass;
        $data->uid = $uid;
        $data->description = $description;
        $data->visibility = $visibility;
        $data->achieved = $achieved;
        $data->locationLng = $locationLng;
        $data->locationLat = $locationLat;
        $data->field = $field;
        
        $momentsModel = R::M('Moments');
        $validation = $momentsModel->isValid($data, $imgs);
        if ($validation !== true) {
            $errors = [
                'INVALID_pictureNumber' => 'pictureNumber',
                'INVALID_description' => 'description'
            ];
            $this->json(['success' => false, 'message' => (isset($errors[$validation]) ? $errors[$validation] : $validation)]);
        }

        $newMid = R::M('Moments')->postMoment($data, $imgs);
        if (is_int($newMid)) {
            $this->json(['success' => true, 'mid' => $newMid]);
        } else {
            $this->json(['success' => false, 'message' => $newMid]);
        }
    }

    // get moments
    public function onAjaxMoments()
    {
        $this->needAjax();
        $this->needPost();
        
        $showUid = F::post('uid');
        $onlySignificant = F::post('significant');
        $achieved = F::post('achieved');
        $fid = F::post('fid');

        $uid = $this->loginUserId();
        $attrs = new stdClass;
        $attrs->uid = $showUid;
        $attrs->onlySignificant = $onlySignificant;
        $attrs->timeRange = null;
        $attrs->achieved = $achieved == -1 ? null : $achieved;
        $attrs->page = F::post('page');
        $attrs->pageSize = 16;
        $attrs->fid = $fid;

        $userModel = R::M('User');
        $likesModel = R::M('Likes');

        $moments = R::M('Moments')->getMoments($uid, $attrs);
        $results = [];

        foreach ($moments as $moment) {
            $result = [];
            $result['description'] = $moment->description;
            $result['time'] = $moment->time;
            $result['realName'] = $moment->realName;
            $result['visibility'] = ($moment->visibility == 'public' ? 'public' : 'private');
            $result['significant'] = $moment->significant;
            $result['uid'] = $moment->uid;
            $result['imgs'] = $moment->imgs;
            $result['mid'] = $moment->mid;
            $result['achieved'] = $moment->achieved;
            $result['likes'] = $likesModel->countLikes($moment->mid);
            $result['likable'] = $likesModel->likable($moment->mid, $uid);
            $result['liked'] = $likesModel->liked($moment->mid, $uid);
            $results[] = $result;
        }

        $this->json($results);
    }

    // on ajax search users
    public function onSearchUsers()
    {
        $this->needAjax();
        $this->needPost();
        $uid = $this->needLogin();

        $keyword = F::post('keyword');
        $userModel = R::M('User');

        // if the keyword is empty, show recommended users
        $recommendedUsers = $userModel->searchUsers($uid, $keyword);
        $displayRecUsers = [];
        foreach ($recommendedUsers as $user) {
            $info = $user->info;
            $result = [];
            $result['uid'] = $info->uid;
            $result['similarity'] = $user->similarity;
            $result['fid'] = $info->fid;
            $result['field'] = $info->field;
            $result['realName'] = $info->realName;
            $result['mission'] = $info->mission;
            $result['institution'] = $info->institution;
            $displayRecUsers[] = $result;
        }
        $this->json($displayRecUsers);
    }

    // space
    public function onSpace()
    {
        $uid = $this->needLogin();

        $assigns = new stdClass;
        $assigns->uid = $uid;
        
        $this->show('space', $assigns);
    }

    // get nearest moments
    public function onAjaxGetNearestMoments()
    {
        $this->needAjax();
        $this->needPost();
        $this->needLogin();

        $userLocation = new stdClass;
        $userLocation->lng = F::post('lng');
        $userLocation->lat = F::post('lat');

        $momentsModel = R::M('Moments');
        $nearestMoments = $momentsModel->getNearestMoments($userLocation);
        
        $results = [];
        foreach ($nearestMoments as $moment) {
            $result['mid'] = $moment->mid;
            $result['description'] = $moment->description;
            $result['uid'] = $moment->uid;
            $result['time'] = $moment->time;
            $result['achieved'] = $moment->achieved;
            $result['significant'] = $moment->significant;
            $result['distance'] = $moment->distance;
            $result['realName'] = $moment->realName;
            $result['imgs'] = $moment->imgs;
            $result['field'] = $moment->field;
            $results[] = $result;
        }

        $this->json($results);
    }

    // set like
    public function onAjaxLike()
    {
        $this->needAjax();
        $this->needPost();
        
        $uid = $this->needLogin();
        $mid = F::post('mid');

        $likesModel = R::M('Likes');
        if (!$likesModel->likable($mid, $uid)) {
            $this->json(['success' => false]);
        }
        $this->json(['success' => (bool) $likesModel->like($mid, $uid)]);
    }

    // show moment detail
    public function onMomentDetail()
    {
        $uid = $this->needLogin();
        $mid = F::get('mid');

        $momentsModel = R::M('Moments');
        $likesModel = R::M('Likes');

        if (!$momentsModel->visible($mid, $uid)) {
            $this->showError();
        }
        $moment = $momentsModel->getMoment($mid);

        $assigns = new stdClass;
        $assigns->description = $moment->description;
        $assigns->uid = $moment->uid;
        $assigns->realName = $moment->realName;
        $assigns->time = $moment->time;
        $assigns->achieved = $moment->achieved;
        $assigns->significant = $moment->significant;
        $assigns->imgs = $moment->imgs;
        $assigns->field = $moment->field;
        $assigns->mid = $moment->mid;
        $assigns->likes = $likesModel->countLikes($moment->mid);
        $assigns->likable = $likesModel->likable($moment->mid, $uid);
        $assigns->liked = $likesModel->liked($moment->mid, $uid);

        $this->show('moment_detail', $assigns);
    }
}
