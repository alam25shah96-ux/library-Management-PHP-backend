<?php

class Roles {
    private $id;
    private $role_name;
    private $description;
    private $created_at;

    public function __construct($_id, $_role_name, $_description, $_created_at) {
        $this->id = $_id;
        $this->role_name = $_role_name;
        $this->description = $_description;
        $this->created_at = $_created_at;
    }

    public function create() {
        global $db;
        $sql = "INSERT INTO roles (id,role_name,description,created_at) VALUES ('{$this->id}', '{$this->role_name}', '{$this->description}', '{$this->created_at}')";
        if ($db->query($sql)) {
          return $db->insert_id;
        } else {
          return "Query failed: " . $db->error;
        }
    }

    public static function readAll() {
        global $db;
        $sql = "SELECT * FROM roles";
        $res = $db->query($sql);
        if ($res) {
          return $res->fetch_all(MYSQLI_ASSOC);
        } else {
          return "Query failed: " . $db->error;
        }
    }

    public static function readById($id) {
        global $db;
        $id = (int)$id;
        $sql = "SELECT * FROM roles WHERE id = $id";
        $res = $db->query($sql);
        if ($res) {
          return $res->fetch_assoc();
        } else {
          return "Query failed: " . $db->error;
        }
    }

    public function update($id) {
        global $db;
        $sql = "UPDATE roles SET id='{$this->id}', role_name='{$this->role_name}', description='{$this->description}', created_at='{$this->created_at}' WHERE id = $id";
        if ($db->query($sql)) {
          if ($db->affected_rows > 0) {
            return "Update successful.";
          } else {
            return "No changes made or record not found.";
          }
        } else {
          return "Update failed: " . $db->error;
        }
    }

    public static function delete($id) {
        global $db;
        $sql = "DELETE FROM roles WHERE id = $id";
        if ($db->query($sql)) {
          if ($db->affected_rows > 0) {
            return "Delete successful.";
          } else {
            return "No record found with ID $id.";
          }
        } else {
          return "Delete failed: " . $db->error;
        }
    }
}
