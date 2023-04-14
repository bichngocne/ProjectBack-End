<?php
class BookModel extends Model
{
    public function getAllBook(){

        $sql = parent::$connection->prepare('SELECT * FROM books');
        return parent::select($sql);
    }
    public function getBookByPag($page,$perpage){

        $startPage = ($page-1)*$perpage;
        $sql = parent::$connection->prepare('SELECT * FROM books LIMIT ?,?');
        $sql->bind_param('ii',$startPage,$perpage);
        return parent::select($sql);
    }
    public function TotalBook(){
        $sql = parent::$connection->prepare('SELECT COUNT(id_book) AS Total_book FROM books');
        return parent::select($sql)[0]['Total_book'];
    }
    public function getBookById($id)
    {
        $sql = parent::$connection->prepare('SELECT * FROM books WHERE id_book = ?');
        $sql->bind_param('i',$id);
        return parent::select($sql)[0];
    }
    public function getBookByIds($arrId)
    {
        $chamHoi = str_repeat('?,',count($arrId)-1);
        $chamHoi .='?';
        $i = str_repeat('i',count($arrId));

        $sql = parent::$connection->prepare("SELECT * FROM books WHERE id_book IN ($chamHoi) ORDER BY FIELD(id_book,$chamHoi) DESC");
        $sql->bind_param($i . $i, ...$arrId, ...$arrId);
        return parent::select($sql);
    }
    public function getSearchByKey($key)
    {
        $sql = parent::$connection->prepare('SELECT * FROM books WHERE book_name LIKE ?');
        $keyWord = "%{$key}%";
        $sql->bind_param('s',$keyWord);
        return parent::select($sql);        
    }
    public function addBook( $book_name, $book_description, $book_price, $book_photo , $author_name , $id_type)
    {
        $sql = parent::$connection->prepare('INSERT INTO `books`(`book_name`, `book_description`, `book_price`, `book_photo` , `author_name`,`id_type` ) VALUES (?,?,?,?,?,?)');
        $sql->bind_param('ssissi', $book_name, $book_description, $book_price, $book_photo , $author_name , $id_type);
           
        return $sql->execute();
    }
    public function updateBook( $book_name, $book_description, $book_price, $book_photo , $author_name , $id_type ,$id_book)
    {
        $sql = parent::$connection->prepare("UPDATE `books` SET `book_name`=?,`book_description`=?,`book_price`=?,`book_photo`=?,`author_name`=?,`id_type`= ? WHERE `id_book`=?");
        $sql->bind_param("ssissii",$book_name, $book_description, $book_price, $book_photo , $author_name , $id_type ,$id_book);

        return $sql->execute();

   }
    public function setViewBook($id)
    {
        $sql = parent::$connection->prepare("UPDATE `books` SET `view`= `view` +1 WHERE `id_book`=?");
        $sql->bind_param('i',$id);
        return $sql->execute();
    }
    public function setLikeBook($id)
    {
        $sql = parent::$connection->prepare("UPDATE `books` SET `like`= `like` +1 WHERE `id_book`=?");
        $sql->bind_param('i',$id);
        return $sql->execute();
    }
    public function deleteBook($id_book)
    {
        $sql= parent::$connection->prepare('DELETE FROM `books` WHERE  `id_book`= ?');
        $sql->bind_param('i',$id_book);
        return $sql->execute();
    }
     // sắp xếp  giá tăng dần
     public function getSortAscendingPrice()
     {
         $sql=parent::$connection->prepare('SELECT * FROM `books` ORDER BY `books`.`book_price` ASC');
         return parent::select($sql);
     }
     //sắp xếp giá giảm dần
     public function getSortDecreasePrice()
     {
         $sql=parent::$connection->prepare('SELECT * FROM `books` ORDER BY `books`.`book_price` DESC');
         return parent::select($sql);
     }

     // tên tăng
     public function getSortAscendingNameBook()
     {
         $sql=parent::$connection->prepare('SELECT * FROM `books` ORDER BY `books`.`book_name` ASC');
         return parent::select($sql);
     }
     // tên giảm
     public function getSortDecreaseNameBook()
     {
         $sql=parent::$connection->prepare('SELECT * FROM `books` ORDER BY `books`.`book_name` DESC');
         return parent::select($sql);
     }
     // id tăng
     public function getSortDecreaseIDBook()
     {
         $sql=parent::$connection->prepare('SELECT * FROM `books` ORDER BY `books`.`id_book` ASC');
         return parent::select($sql);
     }
     // id giảm
     public function getSortAscendingIDBook()
     {
         $sql=parent::$connection->prepare('SELECT * FROM `books` ORDER BY `books`.`id_book` DESC');
         return parent::select($sql);
     }
     
     
     
}
