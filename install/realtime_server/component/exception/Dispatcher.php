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
 * The exception of Dispatcher component
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

// Error codes
define('DISPATCHER_ERROR_OBJECT', 500);
define('DISPATCHER_ERROR_FILE', 501);

class DispatcherException extends Exception
{
    // where does the error happened
    private $_router;
    private $_controller;
    private $_action;

    // construction
    public function __construct($message, $code, $router, $controller, $action)
    {
        parent::__construct($message, $code);
        $this->_router = $router;
        $this->_controller = $controller;
        $this->_action = $action;
    }

    // getter
    public function getRouter()
    {
        return $this->_router;
    }
    public function getController()
    {
        return $this->_controller;
    }
    public function getAction()
    {
        return $this->_action;
    }

    // getExtra
    public function getExtra()
    {
        return $this->_router . '/' . $this->_controller . '/' . $this->_action;
    }
}
