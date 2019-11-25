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
 * The data validation component
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class ValidationComponent
{
    //patterns
    private static $_pattern = array(
        'number' => '/^[0-9]+$/u', //0-9
        'chinese' => '/^[\x{FF08}-\x{FF09}a-zA-Z0-9_\-\x{4e00}-\x{9fa5}]+$/u', //A-Z a-z - 0-9 _ 中文（）
        'english' => '/^[a-zA-Z0-9_\-]+$/u', //A-Z a-z _ - 0-9
        'email' => '/^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+[\.a-zA-Z]+$/',
        'phone' => '/^1[34578]\d{9}$/'
    );
    
    //count char number
    public static function countCharNum($str)
    {
        return mb_strlen($str, 'UTF-8');
    }
    
    //check the number and its range
    public static function number($x, $from = null, $to = null)
    {
        if (!preg_match(self::$_pattern['number'], $x)) {
            return false;
        }
        if (($from !== null) && ($x < $from)) {
            return false;
        }
        if (($to !== null) && ($x > $to)) {
            return false;
        }
        return true;
    }
    
    //check the chinese words and its range
    public static function chinese($x, $from = null, $to = null)
    {
        if (!preg_match(self::$_pattern['chinese'], $x)) {
            return false;
        }
        $cnt = self::countCharNum($x);
        if (($from !== null) && ($cnt < $from)) {
            return false;
        }
        if (($to !== null) && ($cnt > $to)) {
            return false;
        }
        return true;
    }

    //only check range
    public static function all($x, $from = null, $to = null)
    {
        $cnt = self::countCharNum($x);
        if (($from !== null) && ($cnt < $from)) {
            return false;
        }
        if (($to !== null) && ($cnt > $to)) {
            return false;
        }
        return true;
    }
    
    //check the english words and its range
    public static function english($x, $from = null, $to = null)
    {
        if (!preg_match(self::$_pattern['english'], $x)) {
            return false;
        }
        $cnt = strlen($x);
        if (($from !== null) && ($cnt < $from)) {
            return false;
        }
        if (($to !== null) && ($cnt > $to)) {
            return false;
        }
        return true;
    }
    
    //check the email words and its range
    public static function email($x, $from = null, $to = null)
    {
        if (!preg_match(self::$_pattern['email'], $x)) {
            return false;
        }
        $cnt = self::countCharNum($x);
        if (($from !== null) && ($cnt < $from)) {
            return false;
        }
        if (($to !== null) && ($cnt > $to)) {
            return false;
        }
        return true;
    }

    // check the phone number
    public static function phone($x)
    {
        return preg_match(self::$_pattern['phone'], $x);
    }
}

class V extends ValidationComponent
{
}
