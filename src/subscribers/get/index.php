<?php

require_once "../../config.php";
require_once base_dir_path() . '/vendor/autoload.php';
require_once base_dir_path() . '/app/db-connect.php';

use SuscriberAPI\AppFunctions;
use SuscriberAPI\Models\Subscriber;

// create redis client for caching
$redis = new \Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'cache',
    'port'   => 6379,
]);

// Check id request parameter exists
if(!isset($_REQUEST['id'])) {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error'=> 'Missing id parameter.']);
    exit();
}

$id = $_REQUEST['id'];
$key = "sub-" . $id;

AppFunctions::addRateLimiter($redis, "get-subs-" . $id);

$submodel = new Subscriber($db);
$sub = $submodel->find($id);

// check for any users found in query
if($sub) {
    // cache results and set it to expire in an hour
    $redis->hmset($key, $sub);
    $redis->expire($key, 3600);
    header('HTTP/1.1 200 OK');
    echo json_encode($sub);
    exit();
} else {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error'=> 'Subcriber not found.']);
    exit();
}

