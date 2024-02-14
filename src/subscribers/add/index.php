<?php

require_once "../../config.php";
require_once base_dir_path() . '/vendor/autoload.php';
require_once base_dir_path() . '/app/db-connect.php';

use SuscriberAPI\Models\Subscriber;

// check request method to only allow post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // allow checks for request content type
    if(str_starts_with($_SERVER["CONTENT_TYPE"], 'multipart/form-data')) {
        
        $data = $_POST;

    } elseif($_SERVER["CONTENT_TYPE"] === 'application/json') {
        $json = file_get_contents('php://input');

        // convert decoded json to array
        $data = (array) json_decode($json);

    } else {
        return json_encode(['error'=> 'Invalid data format.']);
    }

    $submodel = new Subscriber($db);

     // validate data
    if($submodel->validateData($data)) {
        $result = $submodel->add($data);

        echo json_encode($result);
    } else {
        echo json_encode(['error'=> 'One or more fields are required.']);
    }

} else {
    echo json_encode(['error'=> 'Request method not allowed.']);
}
