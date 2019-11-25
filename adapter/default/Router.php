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
 * The URL Router adapter
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('adapter/interface/IRouter');
class RouterAdapter extends DispatcherComponent implements IRouterAdapter
{
    // Build uri
    public function buildUri($controller, $action, $rawParams = null)
    {
        if (!is_array($rawParams)) {
            $rawParams = [];
        }
        $params = [];
        foreach ($rawParams as $key => $param) {
            if ($param) {
                $params[$key] = $param;
            }
        }
        $controller = urlencode($this->_toCamelUndo($controller));
        $action = urlencode($this->_toCamelUndo($action));
        $prefix = $controller . '/' . $action;
        $paramString = $params ? ('?' . http_build_query($params)) : '';
        return $prefix . $paramString;
    }

    // To camel-case format
    private function _toCamel($string)
    {
        if (! $string) {
            return '';
        }
        $length = strlen($string);
        $result = strtoupper($string[0]);
        for ($i = 1; $i < $length; $i++) {
            $result .= ($string[$i] == '_' && $i + 1 < $length)
            ? strtoupper($string[++$i])
            : $string[$i];
        }
        return $result;
    }

    // Undo the toCamel work
    private function _toCamelUndo($string)
    {
        if (! $string) {
            return '';
        }
        $length = strlen($string);
        $result = strtolower($string[0]);
        for ($i = 1; $i < $length; $i++) {
            $result .= ($string[$i] >= 'A' && $string[$i] <= 'Z')
            ? ('_' . strtolower($string[$i]))
            : $string[$i];
        }
        return $result;
    }

    // Run the dispatch service
    public function dispatch()
    {
        $router = F::get('__router');
        $controller = $this->_toCamel(F::requestPath(0));
        $action = $this->_toCamel(F::requestPath(1));
        $routerConfig = R::config('router');
        parent::set(
            $router ? $router : $routerConfig->defaultType,
            $controller ? $controller : $routerConfig->defaultController,
            $action ? $action : $routerConfig->defaultAction,
            array('Error', 'Index')
        );
        parent::dispatch();
    }
}
