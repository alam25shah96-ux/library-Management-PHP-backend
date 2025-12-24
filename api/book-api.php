<?php

function getBooks()
{
    echo json_encode(Books::readAll());
}

function createBooks($data, $files){
    $image = imgUpload($files["cover_photo"],"../uploads/books");
    if(isset($image["success"])){
        $cover_photo = $image["success"];
    }else{
        $cover_photo = "";
        echo json_encode(["success" => false, "message" => $image["error"]]);
        exit;
    }
    $user = new Books(null, $cover_photo, $data["title"],
      $data["author_id"], $data["category_id"], $data["isbn"],$data["available"], $data["created_at"] ?? date("Y-m-d H:i:s"));
    echo json_encode($user->create());
}
function bookDetails($_id)
{
   echo json_encode(Books::readById($_id));

  
}

function deleteBook($_id)
{

    echo json_encode(Books::delete($_id));
}

?>