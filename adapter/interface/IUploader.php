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
 * The interface of file uploader adapter
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

//Exception
import('adapter/exception/Uploader');
interface IUploaderAdapter
{
    // getters & setters
    public function setMaxSize($maxSize);
    public function getMaxSize();
    public function setSaveFileName($saveFileName);
    public function setSaveFileDir($saveFileDir);
    public function setAllowFileType($allowFileType);
    public function getFileName();
    public function getFileSize();
    public function getFileType();
    public function generatePath($path);
    public function remove($path);

    // upload file
    public function upload();
}
