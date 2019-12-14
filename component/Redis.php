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
 * RedisComponent
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class RedisComponent
{
    private static $_connection = null;
    private static $_password = 'qwertyuiop';

    public static function getConnection()
    {
        if (self::$_connection === null || !self::$_connection->ping()) {
            self::$_connection = new Redis();
            self::$_connection->pconnect('127.0.0.1', 6379);
            self::$_connection->auth(self::$_password);
        }
        return self::$_connection;
    }

    public static function exists($k)
    {
        return self::getConnection()->exists($k);
    }

    public static function set($k, $v)
    {
        self::getConnection()->set($k, $v);
    }

    public static function get($k)
    {
        return self::getConnection()->get($k);
    }

    public static function del($k)
    {
        self::getConnection()->del($k);
    }
}

