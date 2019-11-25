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
 * The FileIO adapter
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('adapter/interface/IFileIO');
class FileIOAdapter implements IFileIOAdapter
{
    // File exists?
    public static function fileExists($file)
    {
        return is_file(BASE_PATH . $file);
    }

    // Dir exists?
    public static function dirExists($dir)
    {
        return is_dir(BASE_PATH . $dir);
    }

    // Get file contents
    public static function get($file)
    {
        $content = file_get_contents(BASE_PATH . $file);
        if ($content === false) {
            throw new FileIOException('File Not Found.', FILEIO_ERROR_FILE_NOT_FOUND, BASE_PATH . $file);
        }
        return $content;
    }

    // Add file contents
    public static function write($file, $content)
    {
        if (file_put_contents(BASE_PATH . $file, $content) === false) {
            throw new FileIOException('Failed to write contents.', FILEIO_ERROR_FILE_WRITE_FAIL, BASE_PATH . $file);
        }
    }

    // Append something to a specified file
    public static function append($file, $content)
    {
        if (file_put_contents(BASE_PATH . $file, $content, FILE_APPEND) === false) {
            throw new FileIOException('Failed to write contents (append).', FILEIO_ERROR_FILE_WRITE_FAIL, BASE_PATH . $file);
        }
    }

    // Delete a specified file
    public static function remove($file)
    {
        if (!unlink(BASE_PATH . $file)) {
            throw new FileIOException('Failed to delete the file.', FILEIO_ERROR_FILE_DELETE_FAIL, BASE_PATH . $file);
        }
    }

    // Scan a dir
    public static function scan($dir)
    {
        if (!($r = scandir(BASE_PATH . $dir))) {
            throw new FileIOException('Failed to open the directory.', FILEIO_ERROR_DIR_OPEN_FAIL, BASE_PATH . $dir);
        }
        // Remove the first '.' and the second '..'
        array_shift($r);
        array_shift($r);
        return $r;
    }

    // Make a dir
    public static function newDir($dir)
    {
        if (!mkdir(BASE_PATH . $dir)) {
            throw new FileIOException('Failed to create the directory.', FILEIO_ERROR_DIR_CREATE_FAIL, BASE_PATH . $dir);
        }
    }

    // Delete a specified dir
    public static function removeDir($dir)
    {
        if (!rmdir(BASE_PATH . $dir)) {
            throw new FileIOException('Failed to delete the directory.', FILEIO_ERROR_DIR_DELETE_FAIL, BASE_PATH . $dir);
        }
    }
}
