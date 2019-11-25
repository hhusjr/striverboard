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

        $status = R::M('Moments')->postMoment($data, $imgs);
        if ($status === true) {
            $this->json(['success' => true]);
        } else {
            $this->json(['success' => false, 'message' => $status]);
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
        $attrs->sortByDistance = false;
        $attrs->location = null;
        $attrs->page = F::post('page');
        $attrs->pageSize = 20;
        $attrs->fid = $fid;

        $userModel = R::M('User');

        $moments = R::M('Moments')->getMoments($uid, $attrs);
        $results = [];

        foreach ($moments as $moment) {
            $result = [];
            $result['description'] = $moment->description;
            $result['time'] = $moment->time;
            $result['realName'] = $userModel->getRealName($moment->uid);
            $result['visibility'] = ($moment->visibility == 'public' ? 'public' : 'private');
            $result['significant'] = $moment->significant;
            $result['uid'] = $moment->uid;
            $result['imgs'] = $moment->imgs;
            $result['mid'] = $moment->mid;
            $result['achieved'] = $moment->achieved;
            $results[] = $result;
        }

        $this->json($results);
    }
}
