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
 * The dispatcher component
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('component/exception/Dispatcher');
abstract class DispatcherComponent
{
    //router
    private $_router = '';

    //controller
    private $_controller = '';

    //action
    private $_action = '';

    //error
    private $_errorController = '';
    private $_errorAction = '';

    //template theme file path
    private $_theme = '';

    //set options
    public function set($router, $controller, $action, $error)
    {
        $this->_router = $router;
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_errorController = $error[0];
        $this->_errorAction = $error[1];
    }

    //set template theme
    public function setTheme($theme)
    {
        if (preg_match('/^[a-zA-Z]+$/', $theme)) {
            $this->_theme = $theme;
        }
    }

    //get router
    public function getRouter()
    {
        return $this->_router;
    }

    //get controller
    public function getController()
    {
        return $this->_controller;
    }

    //get action
    public function getAction()
    {
        return $this->_action;
    }

    //invoke the error page
    public function invokeError()
    {
        $this->_controller = $this->_errorController;
        $this->_action = $this->_errorAction;
        $controllerClass = $this->_controller . 'Controller';
        //force
        try {
            $reflection = new ReflectionClass($controllerClass);
            $action = $reflection->getMethod('on' . $this->_action);
            $action->invoke($reflection->newInstance());
        } catch (AutoLoaderException $e) {
            throw new DispatcherException('Error controller itself went wrong. Message: ' . $e->getMessage(), DISPATCHER_ERROR_OBJECT, $this->_router, $this->_controller, $this->_action);
        } catch (ReflectionException $e) {
            throw new DispatcherException('Error action itself went wrong. Message: ' . $e->getMessage(), DISPATCHER_ERROR_OBJECT, $this->_router, $this->_controller, $this->_action);
        }
        die;
    }

    //load view
    public function view($name, $assigns = null)
    {
        //load template
        $tplPath = BASE_PATH . 'view/' . $this->_theme . '/' . $name . '.php';
        if (!file_exists($tplPath)) {
            throw new DispatcherException('The view ' . $this->_theme . '/' . $name . ' can not be found.', DISPATCHER_ERROR_FILE, $this->_router, $this->_controller, $this->_action);
        }

        //rename variable
        $a = $assigns;
        require $tplPath;
    }

    //dispatch
    public function dispatch()
    {
        $ptn = '/^[a-zA-Z]+$/';
        //check if the router is valid
        if (!preg_match($ptn, $this->_router)) {
            die('Invalid router ' . $this->_router);
        }
        $path = 'controller/' . $this->_router;
        try {
            R::component('AutoLoader')->addSuffix('Controller', $path);
        } catch (AutoLoaderException $e) {
            die('Invalid router ' . $this->_router);
        }
        //check if the controller and action is vaild, otherwise we will call the error controller
        if (!preg_match($ptn, $this->_controller) || !preg_match($ptn, $this->_action)) {
            $this->invokeError();
        }
        $controllerClass = $this->_controller . 'Controller';
        //try to load the class
        try {
            $reflection = new ReflectionClass($controllerClass);
        } catch (AutoLoaderException $e) {
            $this->invokeError();
        }
        //try to call the action
        try {
            $action = $reflection->getMethod('on' . $this->_action);
            $action->invoke($reflection->newInstance());
        } catch (ReflectionException $e) {
            $this->invokeError();
        }
    }
}
