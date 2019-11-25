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
 * The exception of AutoLoader component
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

// Error codes
define('AUTOLOADER_ERROR_FILE_NOT_FOUND', 500);

class AutoLoaderException extends Exception
{
    // object name
    private $_objName;

    // path
    private $_path;

    // construct
    public function __construct($message, $code, $objName, $path)
    {
        parent::__construct($message, $code);
        $this->_objName = $objName;
        $this->_path = $path;
    }

    // get the object
    public function getObjName()
    {
        return $this->_objName;
    }

    // get the path
    public function getPath()
    {
        return $this->_path;
    }

    // get extra
    public function getExtra()
    {
        return '[path: ' . $this->_path . '] [calling: ' . $this->_objName . ']';
    }
}
