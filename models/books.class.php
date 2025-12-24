<?php

class Books
{
  private $book_id;
  private $cover_photo;
  private $title;
  private $author_id;
  private $category_id;
  private $isbn;
  private $available;
  private $created_at;

  public function __construct($_book_id, $_cover_photo, $_title, $_author_id, $_category_id, $_isbn, $_available, $_created_at)
  {
    $this->book_id = $_book_id;
    $this->cover_photo = $_cover_photo;
    $this->title = $_title;
    $this->author_id = $_author_id;
    $this->category_id = $_category_id;
    $this->isbn = $_isbn;
    $this->available = $_available;
    $this->created_at = $_created_at;
  }

  public function create()
  {
    global $db;
    $sql = "INSERT INTO books (book_id,cover_photo,title,author_id,category_id,isbn,available,created_at) VALUES ('{$this->book_id}', '{$this->cover_photo}', '{$this->title}', '{$this->author_id}', '{$this->category_id}', '{$this->isbn}', '{$this->available}', '{$this->created_at}')";
    if ($db->query($sql)) {
      return $db->insert_id;
    } else {
      return "Query failed: " . $db->error;
    }
  }

  // public static function readAll() {
  //     global $db;
  //     $sql = "SELECT * FROM books";
  //     $res = $db->query($sql);
  //     if ($res) {
  //       return $res->fetch_all(MYSQLI_ASSOC);
  //     } else {
  //       return "Query failed: " . $db->error;
  //     }
  // }
  public static function readAll()
  {
    global $db;
    $sql = "
       SELECT 
    b.book_id, 
    b.cover_photo, 
    b.title, 
    b.author_id, 
    b.category_id, 
    b.isbn, 
    b.available, 
    a.name AS auth, 
    c.name AS category
FROM books b
LEFT JOIN authors a ON b.author_id = a.id
LEFT JOIN categories c ON b.category_id = c.id
ORDER BY b.book_id DESC";
    $res = $db->query($sql);
    if ($res) {
      return $res->fetch_all(MYSQLI_ASSOC);
    } else {
      return "Query failed: " . $db->error;
    }
  }

  public static function readById($id)
  {
    global $db;
    $id = (int) $id;
    $sql = "SELECT * FROM books WHERE book_id = $id";
    $res = $db->query($sql);
    if ($res) {
      return $res->fetch_assoc();
    } else {
      return "Query failed: " . $db->error;
    }
  }

  public function update($id)
  {
    global $db;
    $sql = "UPDATE books SET book_id='{$this->book_id}', cover_photo='{$this->cover_photo}', title='{$this->title}', author_id='{$this->author_id}', category_id='{$this->category_id}', isbn='{$this->isbn}', available='{$this->available}', created_at='{$this->created_at}' WHERE id = $id";
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

  public static function delete($id)
  {
    global $db;
    $sql = "DELETE FROM books WHERE book_id = $id";
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
