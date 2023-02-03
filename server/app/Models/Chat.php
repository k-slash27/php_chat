<?php 
declare(strict_types=1);

namespace App\Models;

require_once "Model.php";

class Chat
{
    private $tbl_name = "message";
    private $db;

    public function __construct() {
        $db = new Model();
        $this->db = $db;
    }

    // public function find ($fields=[], $cond=[]) {

    // }

    public function fetchAll() {
        $sql = "select * from {$this->tbl_name}";
        $result = $this->db->fetch($sql);
        return $result;
    }

    public function insert($data = []) {
        $fields = null;
        $values = null;

        end($data);
        $lastKey = key($data);

        foreach ($data as $key => $val) {
            $fields .= $key;
            $values .= (is_string($val))? "'{$val}'" : $val;

            if ($lastKey != $key) {
                $fields .= ", ";
                $values .= ", ";
            }
        }
        
        $sql = "insert into {$this->tbl_name} (". $fields .") values (". $values .")";
        $result = $this->db->execute($sql);

        return $result;
    }

    public function delete($data = []) {

        $id = intval($data['id']);
        $passcode = intval($data['passcode']);
        
        $sql = "select id from {$this->tbl_name} where passcode = ". $passcode . " and id = " . $id;
        $result = $this->db->fetch($sql);

        if ($id != $result[0]['id'])
            return false;
        
        $sql = "delete from {$this->tbl_name} where id = " . $id;
        $result = $this->db->execute($sql);

        return $result;
    }

}
