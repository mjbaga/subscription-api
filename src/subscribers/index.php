<?php

require_once "../config.php";
require_once base_dir_path() . '/vendor/autoload.php';
require_once base_dir_path() . '/app/db-connect.php';

use SuscriberAPI\Models\Subscriber;
use SuscriberAPI\AppFunctions;

$page = isset( $_GET['page'] ) ? $_GET['page'] : 1 ;

// create redis client for caching
$redis = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'cache',
    'port'   => 6379,
]);

AppFunctions::addRateLimiter($redis, "get-list-" . $page);

$submodel = new Subscriber($db);

$db->pageLimit = 10;
$subscribers = $db->arraybuilder()->paginate("subscribers", $page);

$result = [
    "per_page" => 10,
    "totalPages" => $db->totalPages,
    "total" => (int) $db->totalCount,
    "current_page" => $page,
    "data" => $subscribers,
];

header('HTTP/1.1 200 OK');
echo json_encode($result);
exit();