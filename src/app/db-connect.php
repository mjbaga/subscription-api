<?php

$dotenv = \Dotenv\Dotenv::createMutable(base_dir_path());
$dotenv->load();

$host = $_ENV["MYSQL_HOST"];
$database = $_ENV["MYSQL_DATABASE"];
$user = $_ENV["MYSQL_USER"];
$pw = $_ENV["MYSQL_PASSWORD"];

$db = new MysqliDb($host, $user, $pw, $database);