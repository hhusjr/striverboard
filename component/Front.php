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
 * GET/POST Processing
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class FrontComponent
{
    //whether the page was requested with AJAX or not
    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    //whether the page was requested with post method or not
    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    //whether the get param is set
    public static function validGet($x)
    {
        return isset($_GET[$x]);
    }

    //whether the post param is set
    public static function validPost($x)
    {
        return isset($_POST[$x]);
    }

    //get
    public static function get($x = null)
    {
        if ($x === null) {
            return $_GET;
        }
        if (!isset($_GET[$x])) {
            return false;
        }
        return $_GET[$x];
    }

    //post
    public static function post($x = null)
    {
        if ($x === null) {
            return $_POST;
        }
        if (!isset($_POST[$x])) {
            return false;
        }
        return $_POST[$x];
    }

    /*
     * Get request params
     * For example, URI: http://xx.com/a/b/c?d=1
     * request(0) will be a, request(b) will be b
     */
    public static function requestPath($number)
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($requestUri, PHP_URL_PATH);
        $splitResult = explode('/', $uri);
        $args = [];
        foreach ($splitResult as $arg) {
            if ($arg) {
                $args[] = $arg;
            }
        }
        if ($number === null) {
            return $args;
        }
        if (!isset($args[$number])) {
            return false;
        }
        return $args[$number];
    }

    //file
    public static function file($x = null)
    {
        if ($x === null) {
            return $_FILES;
        }
        if (!isset($_FILES[$x])) {
            return false;
        }
        
        return $_FILES[$x];
    }
    
    //the uri of the current page
    public static function current()
    {
        return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    }

    //redirect
    public static function redirect($uri)
    {
        header('location: ' . $uri);
        die;
    }
    
    //returnJSON
    public static function json($data)
    {
        header('content-type: text/json');
        echo json_encode($data);
        die;
    }
    
    //set the content type
    public static function contentType($mime)
    {
        header('content-type: ' . $mime);
    }
    
    //download something
    public static function download($type, $file, $size)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('content-disposition: attachment; filename="' . $file . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $size);
    }
    
    //get the client ip
    public static function ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = 'UNKNOWN';
        }
        return $ip;
    }
}

class F extends FrontComponent
{
}
