<?php

require_once './vendor/autoload.php';

$host = $_ENV["MYSQL_HOST"];
$db = $_ENV["MYSQL_DATABASE"];
$user = $_ENV["MYSQL_USER"];
$pw = $_ENV["MYSQL_PASSWORD"];

$db = new MysqliDb($host, $user, $pw, $db);

echo "test";

$data = [
    "name" => "Marvin Jayson",
    "last_name" => "Baga",
    "status" => "active"
];

$id = $db->insert('subscribers', $data);

if($id)
    echo 'user was created. Id=' . $id;
