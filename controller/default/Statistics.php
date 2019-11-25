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

class StatisticsController extends CommonController
{
    // get moments locations
    public function onAjaxMomentsLocations()
    {
        $this->needAjax();
        $locations = R::M('Moments')->getLocations();
        $result = [];
        foreach ($locations as $location) {
            $info['lng'] = $location->lng;
            $info['lat'] = $location->lat;
            $info['count'] = $location->times;
            $result[] = $info;
        }
        $this->json($result);
    }

}
