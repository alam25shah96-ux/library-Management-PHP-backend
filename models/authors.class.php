<?php

class Authors {
    private $id;
    private $name;
    private $date_of_birth;
    private $nationality;
    private $created_at;

    public function __construct($_id, $_name, $_date_of_birth, $_nationality, $_created_at) {
        $this->id = $_id;
        $this->name = $_name;
        $this->date_of_birth = $_date_of_birth;
        $this->nationality = $_nationality;
        $this->created_at = $_created_at;
    }

    public function create() {
        global $db;
        $sql = "INSERT INTO authors (id,name,date_of_birth,nationality,created_at) VALUES ('{$this->id}', '{$this->name}', '{$this->date_of_birth}', '{$this->nationality}', '{$this->created_at}')";
        if ($db->query($sql)) {
          return $db->insert_id;
        } else {
          return "Query failed: " . $db->error;
        }
    }

    public static function readAll() {
        global $db;
        $sql = "SELECT * FROM authors";
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
        $sql = "SELECT * FROM authors WHERE id = $id";
        $res = $db->query($sql);
        if ($res) {
          return $res->fetch_assoc();
        } else {
          return "Query failed: " . $db->error;
        }
    }

    public function update($id) {
        global $db;
        $sql = "UPDATE authors SET id='{$this->id}', name='{$this->name}', date_of_birth='{$this->date_of_birth}', nationality='{$this->nationality}', created_at='{$this->created_at}' WHERE id = $id";
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
        $sql = "DELETE FROM authors WHERE id = $id";
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
