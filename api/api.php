<?php
header("Access-Control-Allow-Origin: https://library.memoryhubs.com");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once('../config/db.php');
include_once('../helper/img-upload-helper.php');
include_once('../helper/jwt.php');


foreach (glob("../models/*.class.php") as $filename) {
    include_once($filename);
}



foreach (glob("*-api.php") as $filename) {
    include_once($filename);
}

$request = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['method'] ?? null;

if ($endpoint) {



     if ($endpoint == 'users' && $request == 'GET') {
   
           getUsers();
    }else if($endpoint == 'login' && $request == 'POST') {
    $data = json_decode(file_get_contents("php://input"),true);
    // echo json_encode($data);
    checkLogin($data);
}
    
    else if ($endpoint == 'create-user' && $request == 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        createUsers($data);
    } else if ($endpoint == 'user-details' && $request == 'GET') {

        getUserDetails($_GET['id']);

    } else if ($endpoint == 'update' && $request == 'GET') {


        upUser($_GET['id']);


    } else if ($endpoint == 'update-user' && $request == 'PUT') {

        $data = json_decode(file_get_contents("php://input"), true);

        updateUser($data);

    } else if ($endpoint == "delete-user" && $request == 'DELETE') {

        deleteUser($_GET['id']);

    } else if ($endpoint == 'roles' && $request == 'GET') {
        getRoles();
    } else if ($endpoint == 'create-role' && $request == 'POST') {

        $data = json_decode(file_get_contents("php://input"), true);
        CreateRoles($data);
    } else if ($endpoint == 'delete-role' && $request == 'DELETE') {

        deleteRole($_GET['id']);

    } else if ($endpoint == 'role-details' && $request == 'GET') {

        getDetails($_GET['id']);

    } else if ($endpoint == 'role' && $request == 'GET') {

        getRole($_GET['id']);

    } else if ($endpoint == 'update-role' && $request == 'PUT') {

        $data = json_decode(file_get_contents("php://input"), true);

        updateRole($data);

    } else if ($endpoint == 'books' && $request == 'GET') {

        getBooks();

    } else if ($endpoint == 'authors' && $request == 'GET') {
        getAuthors();
    } else if ($endpoint == 'categories' && $request == 'GET') {
        getCategories();
    } else if ($endpoint == 'create-books' && $request == 'POST') {

        $data = json_decode(file_get_contents("php://input"), true);
        createBooks($_POST, $_FILES);
    } else if ($endpoint == 'book-details' && $request == 'GET') {

        bookDetails($_GET['id']);

    } else if ($endpoint == 'delete-book' && $request == 'DELETE') {

        deleteBook($_GET['id']);

    }else {
        echo "This url '$endpoint' not found!";
    }

}

?>