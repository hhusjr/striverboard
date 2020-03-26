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
 * Socket adapter
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

import('adapter/default/unirest/src/Unirest');
import('adapter/default/websocket/vendor/autoload');

import('adapter/interface/ISocket');
class SocketAdapter implements ISocketAdapter
{
    // send HTTP get request, and get JSON response
    public static function http($host, $port, $params, $timeout = 10, $method = 'post')
    {
        if (!in_array($method, ['post', 'get'])) {
            return false;
        }
        Unirest\Request::timeout($timeout);
        $url = $host . ':' . $port;
        $res = call_user_func(['Unirest\Request', $method], $url, array('Accept' => 'application/json'), $params);
        $data = json_decode($res->raw_body, true);
        if (!$data || !isset($data['success']) || !$data['success']) {
            return false;
        }
        return $data;
    }

    // send WebSocket request, and get JSON response
    public static function ws($host, $port, $params, $timeout = 10)
    {
        $cli = new WebSocket\Client($host . ':' . $port);
        $cli->setTimeout($timeout);
        $cli->send(json_encode($params));
        $data = $cli->receive();
        $data = json_decode($data, true);
        if (!$data || !isset($data['success']) || !$data['success']) {
            return false;
        }
        return $data;
    }
}
