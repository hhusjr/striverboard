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
 * The entrance
 * @author JunRu Shen
 */

//Let's make preparations
define('BASE_PATH', dirname(__FILE__) . '/');
date_default_timezone_set('Asia/Shanghai');

//------------
set_time_limit(14400); //4 hours
//ini_set('memory_limit', '1024M'); //1GB
//------------

//!!!!!!!!!!!!!!!
define('IN_DEBUG', true); //whether the platform has been debugging or not
define('MAX_LOG_SIZE', 1024 * 1024 * 32); //the maximum error log file size (default: 32MB)
//!!!!!!!!!!!!!!!

//require a file in BASE_PATH directory with checking exists
function import($path, $attachVars = null, $extension = '.php')
{
    $path = BASE_PATH . $path . $extension;
    if (!is_file($path)) {
        echo 'An error occurred when importing a library.';
        if (IN_DEBUG) {
            echo ' [' . $path . ']';
        }
        die;
    }
    require $path;
}

//Error controller
error_reporting(IN_DEBUG ? E_ALL : 0);
import('component/Error');
$error = new ErrorComponent;
$error->register();

//Import something important
import('component/Registry');
import('component/AutoLoader');
import('config');

//Auto loader
$autoLoader = new AutoLoaderComponent;
$autoLoader->addSuffix('Component', BASE_PATH . 'component');
$autoLoader->addSuffix('Model', BASE_PATH . 'model');
$autoLoader->addSuffix('Adapter', BASE_PATH . 'adapter/' . R::config('adapter')->path);
$autoLoader->addAlias('FrontComponent', 'F');
$autoLoader->addAlias('ValidationComponent', 'V');
$autoLoader->register();
R::component('AutoLoader', $autoLoader);

//Dispatch!
$serverConfig = R::config('server');
$server = new Swoole\WebSocket\Server($serverConfig->host, $serverConfig->port);
$server->on('open', function($server, $req) {
    if (IN_DEBUG) {
        echo 'Connected to server. fd: ' . $req->fd . PHP_EOL;
    }
    R::component('Error')->log('Connected to server. fd: ' . $req->fd);
});
$server->on('message', function($server, $frame) {
    F::setServer($server, $frame->fd);
    F::decode($frame->data);
    $router = new RouterAdapter;
    R::adapter('Router', $router);
    $router->dispatch();
});
$server->on('close', function($server, $fd) {
    if (IN_DEBUG) {
        echo 'Closed connection to server. fd: ' . $fd . PHP_EOL;
    }
    R::component('Error')->log('Closed connection to server. fd: ' . $fd);
});
$server->start();
