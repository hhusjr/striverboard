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
 * The Option Model
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class OptionModel extends BaseModel
{
    // set table
    public function __construct()
    {
        parent::__construct('options');
    }

    // get the option value
    public function get($name)
    {
        return $this->translate($name, 'name', 'value');
    }

    // set the option value
    public function set($name, $value)
    {
        if (!$value || !$this->get($name)) {
            return false;
        }
        $result = $this->modify(array('value' => $value))->condition(['name' => $name])->limit(1)->execute();
        return $result !== false;
    }
}
