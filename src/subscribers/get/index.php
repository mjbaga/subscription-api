<?php

require_once "../../config.php";
require_once base_dir_path() . '/vendor/autoload.php';
require_once base_dir_path() . '/app/db-connect.php';

use SuscriberAPI\Models\Subscriber;
use \PalePurple\RateLimit\RateLimit;
use \PalePurple\RateLimit\Adapter\Predis as PredisAdapter;

// Check id request parameter exists
if(!isset($_REQUEST['id'])) {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error'=> 'Missing id parameter.']);
    exit();
}

$id = $_REQUEST['id'];
$key = "sub-" . $id;

// create redis client for caching
$redis = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'cache',
    'port'   => 6379,
]);

$adapter = new PredisAdapter($redis);
$rateLimiter = new RateLimit("get-subs", 3, 60, $adapter); // 1000 requests per minute

$clientIP = $_SERVER['REMOTE_ADDR'];

// check if user with ip has exceeded request limit
if (!$rateLimiter->check($id)) {
    header('HTTP/1.1 429 Too many requests');
    echo json_encode(['error' => 'You have exceeded the amount of requests.']);
    exit();
}

// check if key exists in cache and return it
if($redis->hgetall($key)) {
    header('HTTP/1.1 200 OK');
    echo json_encode($redis->hgetall($key));
    exit();
}

$submodel = new Subscriber($db);
$sub = $submodel->find($id);

// check for any users found in query
if($sub) {
    $subredis = $sub;
    $subredis['cache'] = true; 
    
    // cache results and set it to expire in an hour
    $redis->hmset($key, $subredis);
    $redis->expire($key, 3600);
    header('HTTP/1.1 200 OK');
    echo json_encode($sub);
    exit();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error'=> 'Subcriber not found.']);
    exit();
}

