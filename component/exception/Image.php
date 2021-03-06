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
 * The exception of Image component
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

// Error codes
define('IMAGE_ERROR_NOT_FOUND', 500);
define('IMAGE_ERROR_TYPE_ERROR', 501);

class ImageException extends Exception
{
    // image path
    private $_image;

    // construct
    public function __construct($message, $code, $path)
    {
        parent::__construct($message, $code);
        $this->_image = $path;
    }

    // get the image path
    public function getImagePath()
    {
        return $this->_image;
    }

    // getExtra
    public function getExtra()
    {
        return $this->_image;
    }
}
