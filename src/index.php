<?php

require_once './vendor/autoload.php';

$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'cache',
    'port'   => 6379,
]);

$client->set('foo', 'bar');
$value = $client->get('foo');

echo $value;