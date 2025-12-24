<?php
function getUsers()
{
    $users = Users::readAll();
    echo json_encode($users);
}
function createUsers($data)
{
    $user = new Users(
        null,
        $data["name"],
        $data["email"],
        null,
        $data["role_id"],
        $data["created_at"] ?? date("Y-m-d H:i:s")
    );
    echo json_encode($user->create());

}

function deleteUser($_id)
{

    echo json_encode(Users::delete($_id));
}

function getUserDetails($_id)
{
   echo json_encode(Users::readById($_id));

  
}

function upUser($_id)
{
   echo json_encode(Users::readById($_id));
}


function updateUser( $data)
{
    $user = new Users(
        
        $data["id"],
        $data["name"],
        $data["email"],
        !empty($data["password"]) ? password_hash($data["password"], PASSWORD_DEFAULT) : null,
        $data["role_id"],
        $data["updated_at"] ?? date("Y-m-d H:i:s")
    );

     echo json_encode($user->update($data["id"]));
}
function checkLogin($data){
    echo json_encode(Users::login($data["email"], $data["password_hash"]));
}

?>