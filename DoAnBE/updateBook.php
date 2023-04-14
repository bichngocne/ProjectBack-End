<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    # code...
    require "./app/Models/$classname.php";
});

global $id;
global $itemBook;

$typeBooks = new TypeBookModel();
$items = $typeBooks->getNameTypeBook();

$bookModel = new BookModel();
if (isset($_GET['id_book'])) {
    $id = $_GET['id_book'];
    $itemBook = $bookModel->getBookById($id);
}
if (!empty($_POST['book_name']) && !empty($_POST['book_description']) && !empty($_FILES['uploadfile']['name']) && !empty($_POST['book_price']) && !empty($_POST['author_name']) && !empty($_POST['id_type'])) {
    $updatebook = new BookModel();
    $book_name = $_POST['book_name'];
    $book_description = $_POST['book_description'];
    $book_price = $_POST['book_price'];
    $book_photo = '';

    // upload hình
    for ($i = 0; $i < count($_FILES['uploadfile']['name']); $i++) {

        $uploadPath = 'public/images/' . $_FILES['uploadfile']['name'][$i];
        if (is_uploaded_file($_FILES['uploadfile']['tmp_name'][$i]) &&  move_uploaded_file($_FILES['uploadfile']['tmp_name'][$i], $uploadPath)) {
            $book_photo .= $uploadPath . ',';
        }
    }
    $author_name = $_POST['author_name'];
    $id_type = $_POST['id_type'];

    $id_book = $updatebook->updateBook($book_name, $book_description, $book_price, $book_photo, $author_name, $id_type, $id);


    header('Location:manageBook.php');
} else {
    echo "<script type='text/javascript'>alert('có lẽ bạn chưa cập nhật thông tin. Vui lòng cập nhật thông tin!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style2.css">
   
</head>
<style>
      #displayImg {
            margin-top: 30px;
        }
        
        #displayImg img {
            height: 100px;
            margin-right: 15px;
            display: inline-block;
        }
    .tools__Book {
        list-style-type: none;
        margin-left: 0;
        padding: 0;
        background-color: #e9d8f4;
        position: absolute;
        overflow: auto;
        height: 550px;
        display: inline-block;
    }

    .item__tools {
        text-decoration: none;
        display: block;
        color: white;
        padding: 8px 16px;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    .item__tools:hover {
        background-color: #db7093;
        font-weight: bold;
        color: white;
    }

    .item__tools.active {
        background-color: #58257b;
        font-weight: bold;
        color: white;
    }

    .search__addBook {
        width: 300px;
        height: 40px;
        margin-right: 20px;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    .btn__subThem {
        border-radius: 10px;
        background-color: #e9d8f4;
        padding: 10px 15px;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    .name__item {
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
</style>

<body>
    <div class="container-fluid bg-light" style="padding: 0;">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: auto;">
                        <li class="nav-item">

                            <p class="name__footer" style="margin-bottom: 30px; font-size: 35px; padding-right: 0px;">Daisuki.com</p>
                        <li class="nav-item">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="Index.php" style="padding-left: 0px;">Home</a>
                        </li>


                        <div class="dropdown">
                            <ul class="nav-item" style="padding: 0;">
                                <a class="nav-link" href="<?php
                                                            if (isset($_SESSION['username'])) {
                                                                echo "logout.php";
                                                            } else {
                                                                echo "account.php?id=1";
                                                            } ?>">
                                    <?php
                                    if (isset($_SESSION['username'])) {
                                    ?>
                                        <i class="fa-solid fa-user-secret">
                                            <?php echo $_SESSION['username'] ?>
                                        </i>
                                        <div class="dropdown-content">
                                            <a href="logout.php">Đăng Xuất</a>
                                        </div>
                                    <?php
                                    } else {
                                        echo "Đăng Nhập/Đăng Ký";
                                    }
                                    ?>
                                </a>
                            </ul>
                        </div>
                    </ul>
                </div>


            </div>
        </nav>

    </div>
    <div class="container" >
           <div class=" ">
                <form action="updateBook.php?id_book=<?php echo $_GET['id_book'] ?>" method="post" onsubmit="return confirm('bạn có muốn chỉnh sửa  sản phẩm này không?')">
                    <div class="mb-3">

                        <label for="book_name" class="form-label name__item">Tên sản phẩm</label>
                        <input type="text" name="book_name" id="book_name" value="<?php echo $itemBook['book_name'] ?>" class="form-control name__item">
                    </div>
                    <div class="mb-3">

                        <label for="book_description" class="form-label name__item">Mô tả</label>
                        <input type="text" name="book_description" id="book_description" value="<?php echo $itemBook['book_description'] ?>" class="form-control name__item">
                    </div>

                    <div class="mb-3">
                        <label for="book_price" class="form-label name__item">Giá</label>
                        <input type="text" name="book_price" id="book_price" value="<?php echo $itemBook['book_price'] ?>" class="form-control name__item">
                    </div>

                    <div class="mb-3">
                        <?php
                        $photos = explode(',', $itemBook['book_photo']);

                        ?>
                        
                        <img src="public/images/<?php echo reset($photos) ?>" alt="" class="img-fluid" style="width: 100px;">

                        <br>
                    
                       <br>
                       <input type="file" name="uploadfile[]" id="uploadfile" multiple>

                    </div>


                    <div class="mb-3">
                        <label for="author_name" class="form-label name__item">ten tac gia</label>
                        <input type="text" name="author_name" id="author_name" value="<?php echo $itemBook['author_name'] ?>" class="form-control name__item">
                    </div>

                    <div class="mb-3">
                        <div>
                            <?php
                            foreach ($items as $item) {

                            ?>
                                <input type="radio" checked="checked" name="id_type" id="id_type" value="<?php echo $item['id_type'] ?>">
                                <label for="id_type" class="form-label" style="margin-right: 10px;"> <?php echo $item['type_name'] ?></label>

                            <?php
                            }
                            ?>
                        </div>
                        <br>
                    </div>
                    <button type="submit" name="up" class="btn__subThem">Update</button>


                </form>
            </div>
      
    </div>

</body>

</html>