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
 * For loading libraries automatically
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('component/exception/AutoLoader');
class AutoLoaderComponent
{
    // suffixes
    private $_suffixes = array();

    // Those special classes who do not have a specified suffix
    private $_specialClasses = array();

    // aliases
    private $_aliases = array();

    // add a relationship between a new suffix and directory
    public function addSuffix($suffix, $dir)
    {
        if (!file_exists($dir)) {
            throw new AutoLoaderException('The file went wrong when adding suffix to AutoLoader', AUTOLOADER_ERROR_FILE_NOT_FOUND, $suffix, $dir);
        }
        $this->_suffixes[$suffix] = $dir;
    }

    // add a relationship between a special class and directory
    public function addSpecialClass($class, $file)
    {
        if (!file_exists($file)) {
            throw new AutoLoaderException('The file went wrong when adding special class to AutoLoader', AUTOLOADER_ERROR_FILE_NOT_FOUND, $class, $file);
        }
        $this->_specialClasses[$class] = $file;
    }

    // add a new alias
    public function addAlias($name, $alias)
    {
        $this->_aliases[$alias] = $name;
    }

    // autoload processor
    private function _load($class)
    {
        $found = false;
        $path = '';

        if (isset($this->_specialClasses[$class])) {
            $found = true;
            $path .= $this->_specialClasses[$class];
        } else {
            if (isset($this->_aliases[$class])) {
                $class = $this->_aliases[$class];
            }
            foreach ($this->_suffixes as $suffix => $dir) {
                $length = strlen($suffix);
                if (substr($class, -$length) == $suffix) {
                    $found = true;
                    $fileName = substr($class, 0, strlen($class) - $length);
                    $path .= $dir . '/' . $fileName . '.php';
                    break;
                }
            }
        }

        // return if not found
        if (!$found) {
            return;
        }

        if (!is_file($path)) {
            throw new AutoLoaderException('The file path of the specified class is invaild.', AUTOLOADER_ERROR_FILE_NOT_FOUND, $class, $path);
        }

        require $path;

        // return true if loaded
        return true;
    }

    // do spl register
    public function register()
    {
        spl_autoload_register(array($this, '_load'));
    }
}
