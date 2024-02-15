<?php

require_once './vendor/autoload.php';

$redis = new Redis();
$redis->connect('redis-server', 6379);

echo "Connection to server successfully <br>";

echo "Server is running: " . $redis->ping() . "<br>";