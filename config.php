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
 * The configuration file
 * @author JunRu Shen
 */
if (!defined('BASE_PATH')) {
    die('Access Denied.');
}

/* !!!!!!!!!!!!!!!
 * [PLEASE NOTICE]
 * (1) If changing PHP configuration (including setting time limit)
 *     is denied by the server, please delete the code between
 *     "//------------" in "index.php" and change the settings
 *     by editing configuration file.
 * (2) Turn off the "IN_DEBUG" mode (index.php) after debugging is finished
 * (3) You can change the maximum error log file size (default: 32MB) in index.php
 */

// DON'T EDIT
$database = new StdClass;
$adapter = new StdClass;
$router = new StdClass;
$session = new StdClass;
$uploader = new StdClass;
$sms = new StdClass;

// START EDIT NOW!
// Database connection configuration
$database->host = 'localhost';
$database->port = '3306';
$database->user = 'root';
$database->password = 'iatb.zio#jr.15';
$database->name = 'striverboard';
$database->tablePrefix = 'striverboard_';

// Choose the type of the adapter
$adapter->path = 'default';

// Choose the default type of the router
$router->defaultType = 'default';
$router->defaultController = 'Index';
$router->defaultAction = 'Index';

// Set the session prefix
$session->prefix = 'striverboard_';

// Upload file to your server
$uploader->maxSize = 10485760;
$uploader->prefix = BASE_PATH;

// Sms configuration
$sms->maxMessageCountPerMinute = 1;
$sms->verifyCodeExpireMinute = 60;

// Now, please save file and close it.

// DON'T EDIT

// Mount configuration file to registry
R::config('database', $database);
R::config('adapter', $adapter);
R::config('router', $router);
R::config('session', $session);
R::config('uploader', $uploader);
R::config('sms', $sms);
