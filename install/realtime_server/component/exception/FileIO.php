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
 * The exception of FileIO component
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

// Error codes
define('FILEIO_ERROR_FILE_NOT_FOUND', 500);
define('FILEIO_ERROR_FILE_WRITE_FAIL', 501);
define('FILEIO_ERROR_FILE_DELETE_FAIL', 502);
define('FILEIO_ERROR_DIR_OPEN_FAIL', 503);
define('FILEIO_ERROR_DIR_CREATE_FAIL', 504);
define('FILEIO_ERROR_DIR_DELETE_FAIL', 505);

class FileIOException extends Exception
{
    // file path
    private $_path;

    // construct
    public function __construct($message, $code, $path)
    {
        parent::__construct($message, $code);
        $this->_path = $path;
    }

    // get the file path
    public function getPath()
    {
        return $this->_path;
    }

    // getExtra
    public function getExtra()
    {
        return $this->_path;
    }
}
