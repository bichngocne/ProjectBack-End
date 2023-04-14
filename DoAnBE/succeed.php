<?php
session_start();
require_once './config/database.php';
spl_autoload_register(
    function ($classname) {
        require "./app/Models/$classname.php";
    }
);
$bookModel = new BookModel();
$perpage = 8;
$page = 1;

$totalPage = ceil(($bookModel->TotalBook()) / $perpage);
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $bookList = $bookModel->getBookByPag($page, $perpage);
}
$bookList = $bookModel->getBookByPag($page, $perpage);
$typeBooks = new TypeBookModel();
$items = $typeBooks->getNameTypeBook();
$recentViewed = [];
if (isset($_COOKIE['recentviewed'])) {
    $arrId = json_decode($_COOKIE["recentviewed"], true);
    $recentViewed = $bookModel->getBookByIds($arrId);
}
//tao luot tim
if (isset($_GET['like'])) {
    $idlike = $_GET['like'];
    if (!isset($_COOKIE["like$idlike"])) {
        $bookModel->setLikeBook($idlike);
        setcookie("like$idlike", $idlike, time() + 3600 * 2);
        header("Location:index.php");
    } else {
        header("Location:index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mua hàng thành công</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .check {

            text-align: center;
        }

        .item {
            width: 300px;
            height: 300px;
            text-align: center;
            display: inline-table;
            margin-top: 100px;
            border: solid 3px red;
            border-radius: 999px;
           color: red;
font-family:Georgia, 'Times New Roman', Times, serif;

        }
    </style>
</head>

<body>
<div class="top-fluid">
        <div class="container " style="background: #fff;">
            <div class="row" style="padding:40px 0">
                <div class="col-md-3">
                    <div class="custom">
                        <p>
                            Get in touch:
                            <i class="fa-solid fa-phone"></i>
                            <a href="#" style="text-decoration: none;color: #000;" class="number">1-800-1234-567
                            </a>

                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="logo">
                        <h1 class="name__footer" style="margin-top:20px;">Daisuki.com</h1>
                    </div>
                </div>
                <div class="col-md-3">
                    <form class="d-flex" role="search" method="GET" action="search.php">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" style="margin: auto;">
                        <button class="btn btn-outline-success" type="submit" style="margin-bottom: 0;">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-light" style="padding: 0;">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: auto;">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="Index.php"> <i class="fa-solid fa-house-chimney"></i>  Home</a>
                            </li>
                            <div class="dropdown">
                                <ul class="nav-item" style="padding: 0;">
                                    <a class="nav-link"> <i class="fa-solid fa-recycle"></i> Phân Loại
                                        <div class="dropdown-content">
                                            <?php
                                            foreach ($items as $item) {
                                            ?>
                                                <a class="nav-link-content" href="typeBook.php?<?php
                                                                                                if (isset($_SESSION['username'])) {
                                                                                                    echo "id_type={$item['id_type']}#list-book&";
                                                                                                } else {
                                                                                                    echo "id_type=" . $item['id_type'] . "&#list-book";
                                                                                                }
                                                                                                ?>">
                                                    <?php
                                                    echo $item['type_name'] ?>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </a>

                                </ul>
                            </div>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php
                                                            if (isset($_SESSION['username'])) {
                                                                echo "cart.php";
                                                            } else {
                                                                echo "account.php?id=1";
                                                            }
                                                            ?>" name="cart">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    Giỏ Hàng
                                </a>
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
                                                <a href="informationUser.php">Thông Tin</a>
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
    <!-- check -->
    <div class="check">
        <div class="item">
            <a href="" style="font-size:150px; color: red; display:block;margin-bottom:-30px ;"> <i class="fa-solid fa-check"></i> </a>
           <b > Bạn đã thanh toán thành công.</b>
           
        </div>
    </div>
</body>

</html>