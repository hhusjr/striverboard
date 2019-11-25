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
 * The session adapter
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('adapter/interface/ISession');
class SessionAdapter implements ISessionAdapter
{
    // Get real name (the real name is added a prefix)
    private static function _realName($name)
    {
        return R::config('session')->prefix . $name;
    }

    // Read the content of a session variable
    public static function read($name)
    {
        $realName = self::_realName($name);
        if (!isset($_SESSION[$realName])) {
            throw new SessionException('Session not found.', SESSION_ERROR_NOT_FOUND, $name);
        }
        return $_SESSION[$realName];
    }

    // Write something to a session variable
    public static function write($name, $value)
    {
        return $_SESSION[self::_realName($name)] = $value;
    }

    // If the session variable exists
    public static function exists($name)
    {
        return isset($_SESSION[self::_realName($name)]);
    }

    // Destroy a session variable
    public static function destroy($name)
    {
        unset($_SESSION[self::_realName($name)]);
    }
}
