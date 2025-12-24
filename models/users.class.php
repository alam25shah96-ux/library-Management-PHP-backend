<?php

class Users {
    public $id;
    public $name;
    public $email;
    public $password_hash;
    public $role_id;
    public $created_at;

    public function __construct($_id, $_name, $_email, $_password_hash, $_role_id, $_created_at) {
        $this->id = $_id;
        $this->name = $_name;
        $this->email = $_email;
        $this->password_hash = $_password_hash;
        $this->role_id = $_role_id;
        $this->created_at = $_created_at;
    }

    public function create() {
        global $db;
        $sql = "INSERT INTO users (id,name,email,password_hash,role_id,created_at)
         VALUES ('{$this->id}', '{$this->name}', '{$this->email}', '{$this->password_hash}', 
         '{$this->role_id}', '{$this->created_at}')";
        if ($db->query($sql)) {
          return $db->insert_id;
        } else {
          return "Query failed: " . $db->error;
        }
    }

   
    public static function readAll() {
    global $db;

    $sql = "
        SELECT 
            u.id, 
            u.name, 
            u.email, 
            u.role_id, 
            r.role_name AS role, 
            r.description
        FROM users u
        JOIN roles r ON u.role_id = r.id       
    ";

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

    $sql = "SELECT users.*, roles.role_name 
            FROM users 
            LEFT JOIN roles ON users.role_id = roles.id 
            WHERE users.id = $id";

    $res = $db->query($sql);
    if ($res) {
        return $res->fetch_assoc();
    } else {
        return "Query failed: " . $db->error;
    }
}

    public function update($id) {
        global $db;
        $sql = "UPDATE users SET id='{$this->id}', name='{$this->name}', email='{$this->email}',
         password_hash='{$this->password_hash}', role_id='{$this->role_id}',
          created_at='{$this->created_at}' WHERE id = $id";
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
        $sql = "DELETE FROM users WHERE id = $id";
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
    public static function login($_email, $_password){
        global $db;
       $sql = "SELECT u.name, u.email, r.role_name AS role_name 
        FROM users u, roles r 
        WHERE u.email = '{$_email}' 
        AND u.password_hash = '{$_password}' 
        AND u.role_id = r.id";

        $res = $db->query($sql);
        if ($res) {
          if($res->num_rows > 0){
            $result = $res->fetch_assoc();
            $token = generateJWT($result, 60 * 60 * 24 * 7);

            return ["success"=>true, "data"=>$result, "token"=>$token];
          }else{
            return ["success"=>false, "message"=>"Invalid email or password"];
          }
          
        } else {
          return ["success"=>false, "message"=>"Query failed: " . $db->error];
        }
      
    }
}
