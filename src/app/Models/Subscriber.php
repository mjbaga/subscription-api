<?php

namespace SuscriberAPI\Models;

class Subscriber {
    private $db = null;

    /**
     * @param $db - instance of MysqliDb class for CRUD operations
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * @param $id - $id of subscriber to find
     */
    public function find($id): null|array
    {
        $this->db->where("id", $id);
        $sub = $this->db->getOne("subscribers");

        if($sub) {
            return $sub;
        }

        return null;
    }

    public function add(array $data): array
    {
        $this->db->where("name", $data["name"]);
        $this->db->where("last_name", $data["last_name"]);

        // check database if user already exists
        if(!$this->db->has("subscribers")) {

            $id = $this->db->insert("subscribers", $data);

            // successfully added user
            if ($id) {

                $userData = $this->find($id);

                return [ 
                    "message" => "Successfully added user with id of {$id}.",
                    "data" => $userData
                ];
            }

            // failed adding user
            return ["message" => 'Adding of user failed: ' . $this->db->getLastError() ];
            // return ["message" => "user does not exist."];
        }

        return ["message" => "User already exists."];
    }

    // very simple check to require all data fields
    public function validateData($data): bool
    {
        if(!isset($data["name"]) || !isset($data["last_name"]) || !isset($data["status"]))
            return false;

        foreach($data as $val) {
            if($val === "" || $val === null) {
                return false;
            }
        }

        return true;
    }
}