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
 * The error component
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

class ErrorComponent
{
    //the path to save log
    private $_path;

    //set the default paths
    public function __construct()
    {
        $this->_path = BASE_PATH . 'data/log/log_' . date('Y_m') . '.log.php';
    }
    
    //write something to the log file
    public function log($info)
    {
        //create file
        if (!file_exists($this->_path)) {
            file_put_contents($this->_path, "<?php die; ?>\n[Error handler]\n");
        } elseif (filesize($this->_path) > MAX_LOG_SIZE) {
            return;
        }

        //append
        file_put_contents($this->_path, '[Log @' . date('Y/m/d H:i:s') . '] ' . $info . " \n ****************************** \n", FILE_APPEND);
    }
    
    //The exception handler
    public function handleException($e)
    {
        if (method_exists($e, 'getExtra')) {
            $extra = $e->getExtra();
        } else {
            $extra = 'NULL';
        }
        $extra = is_array($extra) ? serialize($extra) : $extra;
        $e = '[Exception code: ' . $e->getCode() . '] ' . $e->getMessage() . ' # ' . $extra . ' @ ' . $e->getFile();
        $this->log($e);
        if (IN_DEBUG) {
            echo $e . PHP_EOL;
        }
    }

    //The exception handler
    public function handleError($errId, $errMessage, $errFile, $errLine)
    {
        $e = '[PHPError #' . $errId . '] ' . $errMessage . ' @ ' . $errFile . ' at line ' . $errLine;
        $this->log($e);
        if (IN_DEBUG) {
            echo $e . PHP_EOL;
        }
    }

    //register
    public function register()
    {
        set_exception_handler(array($this, 'handleException'));
        set_error_handler(array($this, 'handleError'));
    }
}
