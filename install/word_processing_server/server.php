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

//ini_set('memory_limit', '1024M'); //memory limit 1GB

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
JiebaAnalyse::setStopWords(BASE_PATH . 'libs/jieba/dict/stop_words.txt');

addLog('Initialized Jieba Components.');
echo 'Initialized Jieba Components. TIME: ' . date('Y-m-d H:i:s') . PHP_EOL;
echo 'I am listening...' . PHP_EOL;

// create swoole server
$server = new Swoole\Http\Server(SERVER_HOST, SERVER_PORT);
$server->on('request', function ($request, $response) {
    $response->header('Content-Type', 'application/json');
    $data = $request->post;
    if (!isset($data['access_secret']) || !isset($data['kw']) || !isset($data['document']) || !$data['document']) {
        $result = ['success' => false, 'message' => 'Invalid params.'];
        $response->status(400);
        $response->end(json_encode($result));
        return;
    }
    if ($data['access_secret'] != SERVER_ACCESS_SECRET) {
        $result = ['success' => false, 'message' => 'Secret key error.'];
        $response->status(403);
        $response->end(json_encode($result));
        return;
    }
    $document = $data['document'];
    $kw = (bool) $data['kw'];
    $cnt = isset($data['cnt']) ? abs(intval($data['cnt'])) : 48;
    addLog('Processing document ' . $document);
    $keywords = JiebaAnalyse::extractTags($document, $cnt, ['kw' => $kw]);
    $results = [];
    foreach ($keywords as $word => [$tf, $idf]) {
        $results[] = "[WORD:{$word}, TF:{$tf}, IDF:{$idf}, KW:{$kw}]";
    }
    addLog('Result: ' . implode(', ', $results));
    $result = ['success' => true, 'keywords' => $keywords];
    $response->status(200);
    $response->end(json_encode($result));
});

// start the server
$server->start();
