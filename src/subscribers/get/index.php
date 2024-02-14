<?php

require_once "../../config.php";
require_once base_dir_path() . '/vendor/autoload.php';
require_once base_dir_path() . '/app/db-connect.php';

use SuscriberAPI\Models\Subscriber;

// caching and rate limiter?

// Check id request parameter exists
if (isset($_REQUEST['id'])) {

    $submodel = new Subscriber($db);
    $sub = $submodel->find($_REQUEST['id']);

    // Check for any users found in query
    if($sub) {
        echo json_encode($sub);
    } else {
        echo json_encode(['error'=> 'No user found with id.']);
    }

    
} else {
    echo json_encode(['error'=> 'Missing id parameter.']);
}
