<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
        header("Location:Index.php");
    } else {
        header("Location:Index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daisuki</title>
    <link rel="icon" type="image/x-icon" href="./public/images/th.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
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
    <!-- Navigation -->

    <div class="container-fluid bg-light" style="padding: 0;">
        <div class="container-fluid bg-light" style="padding: 0; position: sticky;top: 0;left: 0;right: 0;">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: auto;">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="Index.php"> <i class="fa-solid fa-house-chimney"></i> Home</a>
                            </li>
                            <div class="dropdown">
                                <ul class="nav-item" style="padding: 0;">
                                    <a class="nav-link"><i class="fa-solid fa-recycle"></i> Phân Loại
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
                                                <a href="showOderUser.php">Đơn Đặt Hàng</a>
                                                <a href="informationUser.php?id=1">Thông Tin</a>
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
        <div class="item-photo-header">
            <div class="container-fluid">
                <h1>
                    Unique creations
                </h1>
                <p>
                    For Unique Occasions
                </p>
                <br>
                <a href="#" class="shopnow">Shop Now</a>
                <a href="#list-book" class="blog">View Blog</a>
            </div>
        </div>
        <?php
        if (isset($_COOKIE['recentviewed'])) {
        ?>
            <div class="container">
                <div class="viewed">
                    <div class="title-recent">
                        <span style="margin-right:8px;"><i class="fa-sharp fa-solid fa-grid-2"></i></span>
                        <span class="fhs_block_title_head">Sản Phẩm Vừa Xem</span>
                    </div>
                    <div class="content-book">
                        <?php
                        foreach ($recentViewed as $value) {
                        ?>
                            <a href="book.php?id_book=<?php echo $value['id_book'] ?>" class="book__item">
                                <img src="./public/images/<?php $item_photo = explode(",", $value['book_photo']);
                                                            echo $item_photo[0] ?>" alt="" class="img-fluid book__photo" style="width:100px;height:90px;">
                                <div class="book__name"><?php echo $value['book_name'] ?>
                                </div>

                            </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

        <div class="container" id="list-book">
            <div class="row">
                <?php
                foreach ($bookList as $item) {
                ?>
                    <div class="col-md-3 col-lg-3 col-12 frames">
                        <div class='col-book'>
                            <a href="book.php?id_book=<?php echo $item['id_book'] ?>" class="book__item">
                                <img src="./public/images/<?php $item_photo = explode(",", $item['book_photo']);
                                                            echo $item_photo[0] ?>" alt="" class="img-fluid book__photo" style="width:250px">
                                <div class="book__name"><?php echo $item['book_name'] ?></div>
                                <div class="book-price">
                                    <?php echo number_format($item['book_price']) ?> VND</div>
                            </a>
                            <div class="icon__book">
                                <a href="book.php?id_book=<?php echo $item['id_book'] ?>"><i class="fa-solid fa-eye"></i></a><?php echo $item['view'] ?>
                                <?php if (isset($_SESSION['username'])) { ?>
                                    <a href="Index.php?like=<?php echo $item['id_book'] ?>&#list-book"><i class="fa-regular fa-heart"></i></a><?php echo $item['like'] ?>
                                <?php } ?>

                            </div>
                        </div>

                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        </div>
        <div class="page">
            <nav aria-label="Page navigation example">
                <ul class="pagination" style="justify-content: center;padding-top: 40px">
                    <li class="page-item">
                        <?php
                        if (isset($_GET['page'])) {
                            if ($_GET['page'] != 1) {
                        ?>
                                <a class="page-link" name="Previous" href="Index.php?page=<?php echo $_GET['page'] - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                        <?php
                            }
                        }

                        ?>

                    </li>
                    <?php
                    for ($i = 1; $i <= $totalPage; $i++) {
                        # code...
                    ?>
                        <li class="page-item"><a class="page-link" href="Index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php
                    }
                    ?>
                    <li class="page-item">
                        <?php
                        if (isset($_GET['page'])) {
                            if ($_GET['page'] != $totalPage) {
                        ?>
                                <a class="page-link" href="Index.php?page=<?php echo $_GET['page'] + 1 ?>" aria-label="Next" name="next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            <?php
                            }
                        } else {
                            ?>
                            <a class="page-link" href="Index.php?page=2" aria-label="Next" name="next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        <?php
                        }
                        ?>

                    </li>
                </ul>
            </nav>
        </div>
        <!-- Footer -->
        <div class="container footer__book">
            <div class="form__foter">
                <form action="">
                    <label for="" style="color: white;">ĐĂNG KÝ NHẬN BẢN TIN</label>
                    <input type="text" class="input__email" name="" placeholder="nhập địa chỉ email của bạn">
                    <button class="btn__dangKy">Đăng ký</button>
                </form>
            </div>
            <div class="row">
                <div class="col-md-4 left__footer">
                    <h3 class="name__footer">Daisuki.com</h3>
                    <p>14/6 đường sô 9 ,phường Linh Trung , quận Thủ Đức , thành phố Hồ Chí Minh Công ty cổ phần phát hành sách Daisuki
                        <br>
                        daisuki.com nhận đặt hàng trực tuyến và giao hàng tận nơi. KHÔNG hỗ trợ đặt mua và nhận hàng trực tiếp tại văn phòng.
                    </p>
                    <a class="item__icon" style="font-size:40px;"> <i class="fa-brands fa-facebook"></i> </a>
                    <a class="item__icon" style="font-size:40px;"> <i class="fa-brands fa-youtube"></i> </a>
                    <a class="item__icon" style="font-size:40px;"> <i class="fa-brands fa-square-instagram"></i> </a>
                    <a class="item__icon" style="font-size:40px;"> <i class="fa-brands fa-twitter"></i> </a>
                    <a class="item__icon" style="font-size:40px;"> <i class="fa-brands fa-telegram"></i> </a>
                    <img src="./public/images/ggPlay.png" alt="" class="img-fluid item__dowloadApp">
                    <img src="./public/images/Download_on_the_App_Store_Badge.svg.png" alt="" class="img-fluid item__dowloadAppstore">
                </div>
                <div class="col-md-8 right__footer">
                    <div class="row">
                        <div class="col-md-4 ">
                            <h5>Dịch vụ</h5>
                            <a href="" class="item__footerRight">Điều khoản sử dụng</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight">Chính sách bảo mật thông tin cá nhân</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight">Chính sách bảo mật thanh toán</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight">Giới thiệu Daisuki</a>
                        </div>
                        <div class="col-md-4">
                            <h5>Hỗ trợ</h5>
                            <a href="" class="item__footerRight">Chính sách đổi trả-hoàn tiền</a>
                            <br>
                            <br>

                            <a href="" class="item__footerRight">Chính sách bảo hành - bồi toàn</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight">Chính sách vận chuyển </a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight">Chính sách khách sỉ</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight">Chính sách thanh toán và xuất HĐ</a>
                        </div>

                        <div class="col-md-4">
                            <h5>Tài khoản của tôi</h5>
                            <a href="account.php?id=1" class="item__footerRight">Đăng nhập/Tạo tài khoản mới</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight">Thay đổi địa chỉ khách hàng</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight">Chi tiết tài khoản </a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight">Lịch sử mua hàng</a>

                        </div>

                    </div>
                    <h5 style=" margin-top: 20px;">Liên hệ </h5>
                    <a class="item__lienhe"><i class="fa-solid fa-location-dot"></i>14/6,Linh Trung ,Thủ Đức.</a>
                    <a class="item__lienhe"> <i class="fa-solid fa-envelope"></i>daisuki@gmail.com </a>
                    <a class="item__lienhe"> <i class="fa-solid fa-phone"></i> 0985663329</a>
                    <br>
                    <img src="./public/images/ghn.jpg" alt="img-fluid" class="photo_giaoHang">
                    <img src="./public/images/appmomo.png" alt="img-fluid " class="photo_giaoHangAppmomo">
                    <img src="./public/images/vnpayqr.png" alt="img-fluid" class="photo_giaoHangVnpay">
                    <img src="./public/images/zalopay.jpg" alt="img-fluid" class="photo_giaoHang">
                </div>
            </div>
        </div>
    </div>
</body>

</html>