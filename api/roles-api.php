<?php
function getRoles()
{
    echo json_encode(Roles::readAll());
}
function CreateRoles($data)
{
    $role = new Roles(null, $data["role_name"], $data["description"], $data["created_at"] ?? date("Y-m-d H:i:s"));
    echo json_encode($role->create());
}

function deleteRole($_id)
{

    echo json_encode(Roles::delete($_id));
}

function getDetails($_id)
{
   echo json_encode(Roles::readById($_id));

  
}

function getRole($_id)
{
   echo json_encode(Roles::readById($_id));
}
function updateRole( $data)
{
    $user = new Roles(
        
        $data["id"],
        $data["role_name"],
        $data["description"],
        $data["updated_at"] ?? date("Y-m-d H:i:s")
    );

     echo json_encode($user->update($data["id"]));
}
?>