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
 * The Message Verify Model
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class FieldModel extends BaseModel
{
    // set the table name
    public function __construct()
    {
        parent::__construct('fields');
    }

    // check if the field exists
    public function fieldExists($fid)
    {
        return $this->exists(['fid' => $fid]);
    }

    // get field name by id
    public function getNameById($fid)
    {
        return $this->translate($fid, 'fid', 'name');
    }

    // get fields
    public function getFields()
    {
        $fields = $this->select(['fid', 'name'])->order('name ASC')->fetchAll();
        $result = [];
        foreach ($fields as $field) {
            $record = new stdClass;
            $record->fid = $field['fid'];
            $record->name = $field['name'];
            $result[] = $record;
        }
        return $result;
    }
}
