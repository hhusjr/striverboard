<?php
/*
 * Word Processing Server
 * Striverboard
 * @author JunRu Shen
 */

define('IN_DEBUG', true);
define('BASE_PATH', dirname(__FILE__) . '/');
define('SERVER_HOST', 'localhost');
define('SERVER_PORT', 9503);
define('SERVER_ACCESS_SECRET', 'Qks9@#kd.x.a0f9939kdfmmaa..al@##L');
define('MAX_LOG_SIZE', 1024 * 1024 * 32); //the maximum error log file size (default: 32MB)

//write something to the log file
function addLog($info)
{
    $path = BASE_PATH . '/logs/log_' . date('Y_m') . '.log.php';
    //create file
    if (!file_exists($path)) {
        file_put_contents($path, "<?php die; ?>\n[Word Processing Server handler]\n");
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

// import jieba word split libs and load them in the memory
import('libs/jieba/vendor/multi-array/MultiArray');
import('libs/jieba/vendor/multi-array/Factory/MultiArrayFactory');
import('libs/jieba/class/Jieba');
import('libs/jieba/class/Finalseg');
import('libs/jieba/class/JiebaAnalyse');
use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\JiebaAnalyse;
Jieba::init();
Finalseg::init();
JiebaAnalyse::init();

addLog('Initialized Jieba Components.');
echo 'Initialized Jieba Components. TIME: ' . date('Y-m-d H:i:s') . PHP_EOL;
echo 'I am listening...' . PHP_EOL;

// create swoole server
$server = new swoole_server(SERVER_HOST, SERVER_PORT);
$server->on('connect', function($server, $fd) {
    addLog('Connection open ' . $fd);
});
$server->on('receive', function($server, $fd, $reactorId, $data) {
    $data = json_decode($data, true);
    if (!isset($data['accessSecret']) || !isset($data['document']) || !$data['document']) {
        $result = ['success' => false, 'message' => 'Invalid params.'];
        $server->send($fd, json_encode($result));
        $server->close($fd);
        return;
    }
    if ($data['accessSecret'] != SERVER_ACCESS_SECRET) {
        $result = ['success' => false, 'message' => 'Secret key error.'];
        $server->send($fd, json_encode($result));
        $server->close($fd);
        return;
    }
    $document = $data['document'];
    addLog('Processing document ' . $document);
    $keywords = JiebaAnalyse::extractTags($document);
    $results = [];
    foreach ($keywords as $word => [$tf, $idf]) {
        $results[] = "[WORD:{$word}, TF:{$tf}, IDF:{$idf}]";
    }
    addLog('Result: ' . implode(', ', $results));
    $result = ['success' => true, 'keywords' => $keywords];
    $server->send($fd, json_encode($result));
    $server->close($fd);
});
$server->on('close', function($server, $fd) {
    addLog('Connection closed ' . $fd);
});

// start the server
$server->start();
