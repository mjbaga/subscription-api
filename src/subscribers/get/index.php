<?php

require_once "../../config.php";
require_once base_dir_path() . '/vendor/autoload.php';
require_once base_dir_path() . '/app/db-connect.php';

use SuscriberAPI\Models\Subscriber;

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

// check if key exists in cache and return it
if($redis->hgetall($key)) {
    echo json_encode($redis->hgetall($key));
    return false;
}

$submodel = new Subscriber($db);
$sub = $submodel->find($id);

// Check for any users found in query
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

