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
 * The uploader
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('adapter/interface/IUploader');
class UploaderAdapter implements IUploaderAdapter
{
    // the maximum size of the file
    private $_maxSize = 3145728;

    // the file dir
    private $_saveFileDir = 'data/uploads';

    // save file name (without extension)
    private $_saveFileName = '';

    // the array about file params
    private $_arrayFileInfo;

    // allowed file types
    private $_allowFileType = array();

    // construction
    public function __construct($arrayFileInfo)
    {
        $this->_arrayFileInfo = $arrayFileInfo;
    }

    // setters & getters
    public function setMaxSize($maxSize)
    {
        $this->_maxSize = $maxSize;
    }

    public function getMaxSize()
    {
        return $this->_maxSize;
    }

    public function setSaveFileName($saveFileName)
    {
        $this->_saveFileName = $saveFileName;
    }

    public function setSaveFileDir($saveFileDir)
    {
        $path = R::config('uploader')->prefix . $saveFileDir;
        if (!is_dir($path)) {
            mkdir($path);
        }
        $this->_saveFileDir = $saveFileDir;
    }

    public function setAllowFileType($allowFileType)
    {
        $this->_allowFileType = $allowFileType;
    }

    public function getFileName()
    {
        return $this->_arrayFileInfo['name'];
    }

    public function getFileSize()
    {
        return $this->_arrayFileInfo['size'];
    }

    public function getFileType()
    {
        return pathinfo($this->_arrayFileInfo['name'], PATHINFO_EXTENSION);
    }

    // upload file
    public function upload()
    {
        $fileName = $this->_arrayFileInfo['name'];
        $fileType = $this->_arrayFileInfo['type'];
        $fileSize = $this->_arrayFileInfo['size'];
        $tmpFileName = $this->_arrayFileInfo['tmp_name'];
        $errorCode = $this->_arrayFileInfo['error'];
        if ($errorCode > 0) {
            throw new UploaderException('Some error occurred when the file was being uploading.', UPLOADER_ERROR_UPLOADING, $this->_arrayFileInfo);
        }
        if ($fileSize > $this->_maxSize) {
            throw new UploaderException('The file uploaded is too big.', UPLOADER_ERROR_SIZE, $this->_arrayFileInfo);
        }
        $location = $this->_saveFileDir . '/' . $this->_saveFileName . '.' . ($ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)));
        if (!in_array($ext, $this->_allowFileType)) {
            throw new UploaderException('The file uploaded is in invalid type.', UPLOADER_ERROR_TYPE, $this->_arrayFileInfo);
        }
        if (!move_uploaded_file($tmpFileName, R::config('uploader')->prefix . $location)) {
            throw new UploaderException('Some error occurred when the file was being uploading.', UPLOADER_ERROR_UPLOADING, $this->_arrayFileInfo);
        }
        return $location;
    }

    // generate the path
    public function generatePath($path)
    {
        $path = R::config('uploader')->prefix . $path;
        return file_exists($path) ? $path : false;
    }

    // remove
    public function remove($path)
    {
        if (!unlink(R::config('uploader')->prefix . $path)) {
            throw new UploaderException('Failed to remove the uploaded file.', UPLOADER_ERROR_REMOVE, $this->_arrayFileInfo);
        }
    }
}
