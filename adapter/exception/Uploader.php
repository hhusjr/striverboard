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
 * The uploader adapter exception
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

// Error codes
define('UPLOADER_ERROR_UPLOADING', 500);
define('UPLOADER_ERROR_SIZE', 501);
define('UPLOADER_ERROR_TYPE', 502);
define('UPLOADER_ERROR_REMOVE', 503);

class UploaderException extends Exception
{
    // file info
    private $_fileInfo;

    // construct
    public function __construct($message, $code, $fileInfo)
    {
        parent::__construct($message, $code);
        $this->_fileInfo = $fileInfo;
    }

    // get the file info
    public function getFileInfo()
    {
        return $this->_fileInfo;
    }

    // getExtra
    public function getExtra()
    {
        $extra = '';
        foreach ($this->_fileInfo as $key => $value) {
            $extra .= ' #[' . $key . '] ' . $value . '# ';
        }
        return $extra;
    }
}
