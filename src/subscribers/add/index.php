<?php

require_once "../config.php";
require_once base_dir_path() . '/vendor/autoload.php';
require_once base_dir_path() . '/app/db-connect.php';

// api endpoint to add subscriber
// check request method to only allow post
// checking if user exists implemented in subscriber add method
// return added subscriber in json