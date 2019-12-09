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
 * Params processing
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class FrontComponent
{
    public static $_params = [];
    public static $_server = null;
    public static $_fd = 0;

    // set server
    public static function setServer($server, $fd)
    {
        self::$_server = $server;
        self::$_fd = $fd;
    }

    // set params
    public static function set($key, $value)
    {
        self::$_params[$key] = $value;
    }

    // get params
    public static function get($key = null)
    {
        if ($key === null) {
            return self::$_params;
        }
        if (!isset(self::$_params[$key])) {
            return false;
        }
        return self::$_params[$key];
    }

    // decode params
    public static function decode($data)
    {
        $params = json_decode($data, true);
        if (!$params) {
            return false;
        }
        foreach ($params as $key => $param) {
            FrontComponent::set($key, $param);
        }
    }

    // send response and terminate the single request
    public static function send($params, $success = null)
    {
        $server = self::$_server;
        $fd = self::$_fd;
        if ($success !== null) {
            $params['success'] = (bool) $success;
        }
        $server->push($fd, json_encode($params));
    }
}

class F extends FrontComponent
{
}
