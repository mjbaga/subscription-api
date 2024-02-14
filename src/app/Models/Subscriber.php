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
    public function find($id)
    {
        $this->db->where("id", $id);
        $sub = $this->db->getOne("subscribers");

        if($sub) {
            return $sub;
        }

        return null;
    }

    public function add(array $data)
    {
        $this->db->where("name", $data["name"]);
        $this->db->where("last_name", $data["last_name"]);

        if($this->db->has("subscribers")) {
            $id = $this->db->insert("subscribers", $data);

            return ["message" => "Successfully added user with id of {$id}."];
        }

        return ["message" => "User already exists."];
    }
}