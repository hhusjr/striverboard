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
 * The Greats controller
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class GreatsController extends CommonController
{
    // Index action (default action)
    public function onIndex()
    {
        $page = max(1, intval(F::get('page')));
        $pageSize = 8;
        $pageCount = ceil(R::M('Greats')->countGreats() / $pageSize);
        $greats = R::M('Greats')->getAll($page, $pageSize);
        
        $results = [];
        foreach ($greats as $great) {
            $result = new stdClass;
            $result->thumbnail = $this->siteUri($great->thumbnail);
            $result->videoUrl = $great->videoUrl;
            $result->name = $great->name;
            $result->description = $great->description;
            $results[] = $result;
        }

        $assigns = new stdClass;
        $assigns->greats = $results;
        $assigns->pageCount = $pageCount;
        $assigns->page = $page;
        $this->show('greats', $assigns);
    }
}
