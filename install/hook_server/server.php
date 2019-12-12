<?php
/*
 * Hook Server for Real-time Presentation
 * Striverboard
 * @author JunRu Shen
 */

define('IN_DEBUG', true);
define('BASE_PATH', dirname(__FILE__) . '/');
define('SERVER_HOST', 'localhost');
define('SERVER_PORT', 9502);
define('SERVER_ACCESS_SECRET', 'Qks9@#kd.x.a0f9939kdfmmaa..al@##L');
define('MAX_LOG_SIZE', 1024 * 1024 * 32); //the maximum error log file size (default: 32MB)

//ini_set('memory_limit', '1024M'); //memory limit 1GB

//write something to the log file
function addLog($info)
{
    $path = BASE_PATH . '/logs/log_' . date('Y_m') . '.log.php';
    //create file
    if (!file_exists($path)) {
        file_put_contents($path, "<?php die; ?>\n[Hook Server handler]\n");
    } elseif (filesize($path) > MAX_LOG_SIZE) {
        return;
    }
    //append
    file_put_contents($path, '[Log @' . date('Y/m/d H:i:s') . '] ' . $info . " \n ****************************** \n", FILE_APPEND);
}

// require a file in BASE_PATH directory with checking exists
function import($path, $attachVars = null, $extension = '.php')
{
    $path = BASE_PATH . $path . $extension;
    if (!is_file($path)) {
        echo 'An error occurred when importing a library.';
        if (IN_DEBUG) {
            echo ' [' . $path . ']';
        }
        echo PHP_EOL;
        die;
    }
    require $path;
}

addLog('Initialized Hook Server.');
echo 'Initialized Hook Server. TIME: ' . date('Y-m-d H:i:s') . PHP_EOL;
echo 'I am listening...' . PHP_EOL;

// create swoole server
$server = new Swoole\WebSocket\Server(SERVER_HOST, SERVER_PORT);
$server->on('message', function ($server, $frame) {
    $data = json_decode($frame->data, true);
    if (!$data || !isset($data['accessSecret']) && !isset($data['hook']) || !trim($data['hook'])) {
        $server->push($frame->fd, 'Invalid params.');
        return;
    }
    if ($data['accessSecret'] != SERVER_ACCESS_SECRET) {
        $server->push($frame->fd, 'Access Denied.');
        return;
    }
    $hook = trim($data['hook']);
    foreach ($server->connections as $fd) {
        $server->push($fd, json_encode(['success' => true, 'hook' => $hook]));
    }
    addLog('Sent hook: ' . $hook);
    if (IN_DEBUG) {
        echo 'Sent hook: ' . $hook . PHP_EOL;
    }
});

// start the server
$server->start();
