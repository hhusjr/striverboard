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
 * The registry, which can save some instances
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('component/exception/Registry');
class RegistryComponent
{
    //registered
    private static $_registered;

    //add
    public static function add($name, $object)
    {
        if (!is_object($object)) {
            throw new RegistryException('The object does not have a valid type.', REGISTRY_ERROR_TYPE_ERROR, $object);
        }
        return self::$_registered[$name] = $object;
    }

    //get
    public static function get($name, $object = null)
    {
        //only get the specific object
        if ($object === null) {
            if (!isset(self::$_registered[$name])) {
                return self::add($name, new $name());
            }
            return self::$_registered[$name];
        }
        //set and get
        return self::add($name, $object);
    }

    //some specific names
    public static function component($name, $object = null)
    {
        return self::get($name . 'Component', $object);
    }

    public static function config($name, $object = null)
    {
        return self::get($name . 'Config', $object);
    }

    public static function adapter($name, $object = null)
    {
        return self::get($name . 'Adapter', $object);
    }

    public static function M($name, $object = null)
    {
        return self::get($name . 'Model', $object);
    }

    public static function C($name, $object = null)
    {
        return self::get($name . 'Controller', $object);
    }
}

//alias
class R extends RegistryComponent
{
};
