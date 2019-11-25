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
 * The interface of FileIO Adapter
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

// Exception
import('adapter/exception/FileIO');
interface IFileIOAdapter
{
    // File exists?
    public static function fileExists($file);

    // Dir exists?
    public static function dirExists($dir);

    // Get file contents
    public static function get($file);

    // Add file contents
    public static function write($file, $content);

    // Append something to a specified file
    public static function append($file, $content);

    // Scan a dir
    public static function scan($dir);

    // Make a dir
    public static function newDir($dir);

    // Delete a specified file
    public static function remove($file);
}
