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
    // Run the dispatch service
    public function dispatch()
    {
        $accessSecret = F::get('accessSecret');
        if ($accessSecret != R::config('server')->accessSecret) {
            F::send(['error' => 'Access Denied.'], false);
        }
        $router = F::get('__router');
        $controller = F::get('c');
        $action = F::get('a');
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