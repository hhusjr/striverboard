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
 * The Hook Adapter
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('adapter/default/config/HookApi');

import('adapter/interface/IHook');
class HookAdapter implements IHookAdapter
{
    // add new hook
    public static function hook($hook)
    {
        if (!HookApiConfig::$enabled) {
            return false;
        }
        return SocketAdapter::ws(HookApiConfig::$host, HookApiConfig::$port, [
            'accessSecret' => HookApiConfig::$accessSecret,
            'hook' => $hook
        ]);
    }
}
