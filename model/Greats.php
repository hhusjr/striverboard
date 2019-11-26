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
 * The Greates Model
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class GreatsModel extends BaseModel
{
    // set main table
    public function __construct()
    {
        parent::__construct('greats');
    }
    
    // get all greats
    public function getAll()
    {
        $greats =  $this->select(['name', 'intro', 'video_url', 'thumbnail'])->limit(18)->fetchAll();
        $results = [];
        foreach ($greats as $great) {
            $result = new stdClass;
            $result->name = $great['name'];
            $result->intro = $great['intro'];
            $result->videoUrl = $great['video_url'];
            $result->thumbnail = $great['thumbnail'];
            $results[] = $result;
        }
        return $results;
    }
}
