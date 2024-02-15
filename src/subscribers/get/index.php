<?php

require_once "../../config.php";
require_once base_dir_path() . '/vendor/autoload.php';
require_once base_dir_path() . '/app/db-connect.php';

use SuscriberAPI\Models\Subscriber;
use \PalePurple\RateLimit\RateLimit;
use \PalePurple\RateLimit\Adapter\Predis as PredisAdapter;

// Check id request parameter exists
if(!isset($_REQUEST['id'])) {
    echo json_encode(['error'=> 'Missing id parameter.']);
    return false;
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
$rateLimiter = new RateLimit("get-subs", 1000, 60, $adapter); // 1000 requests per minute

$clientIP = $_SERVER['REMOTE_ADDR'];

// check if user with ip has exceeded request limit
if (!$rateLimiter->check($id)) {
    echo json_encode(['error' => 'You have exceeded the amount of requests.']);
    return false;
}

// check if key exists in cache and return it
if($redis->hgetall($key)) {
    echo json_encode($redis->hgetall($key));
    return false;
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
    echo json_encode($sub);
} else {
    echo json_encode(['error'=> 'No user found with id.']);
}

