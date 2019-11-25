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
 * Image processing (like resize)
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('component/exception/Image');
class ImageComponent
{
    private $_type;
    private $_src;
    private $_info;
    
    //load the image (type: jpeg/gif/png)
    public function __construct($path)
    {
        if (!(file_exists($path))) {
            throw new ImageException('File not found.', IMAGE_ERROR_NOT_FOUND, $path);
        }
        list($this->_info['w'], $this->_info['h'], $type) = getimagesize($path);
        switch ($type) {
            case 1: $this->_type = 'gif'; break;
            case 2: $this->_type = 'jpeg'; break;
            case 3: $this->_type = 'png'; break;
            default: throw new ImageException('Some error occurred when loading image.', IMAGE_ERROR_TYPE_ERROR, $path);
        }
        $func = 'imagecreatefrom' . $this->_type;
        $this->_src = $func($path);
    }
    
    //resize the image
    public function resize($maxw, $maxh)
    {
        $ratio1 = ($maxw / $this->_info['w']);
        $ratio2 = ($maxh / $this->_info['h']);
        $ratio = min($ratio1, $ratio2);
        if ($ratio > 1) {
            $w = $this->_info['w'];
            $h = $this->_info['h'];
        } else {
            $w = $this->_info['w'] * $ratio;
            $h = $this->_info['h'] * $ratio;
        }
        $t = imagecreatetruecolor($w, $h);
        imagecopyresampled($t, $this->_src, 0, 0, 0, 0, $w, $h, $this->_info['w'], $this->_info['h']);
        imagedestroy($this->_src);
        $this->_src = $t;
    }
    
    //output
    public function output($path)
    {
        header('content-type: image/' . $this->_type);
        $func = 'image' . $this->_type;
        $func($this->_src, $path);
        imagedestroy($this->_src);
    }
}
