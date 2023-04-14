<?php
session_start();

require_once './config/database.php';
spl_autoload_register(
    function ($classname) {
        require "./app/Models/$classname.php";
    }
);
$bookModel = new BookModel();
if (isset($_GET['id_book'])) {
    $id = $_GET['id_book'];
    $itemBook = $bookModel->getBookById($id);

    if (isset($_COOKIE["recentviewed"])) {
        $arrId = json_decode($_COOKIE["recentviewed"], true);
        if (count($arrId) == 5) {
            array_shift($arrId);
        }
        if (!in_array($id, $arrId)) {
            array_push($arrId, $id);
            setcookie("recentviewed", json_encode($arrId), time() + 3600 * 24);
        } else {
            unset($arrId[array_search($id, $arrId)]);
            array_push($arrId, $id);
            setcookie("recentviewed", json_encode($arrId), time() + 3600 * 24);
        }
    } else {
        $arrId = [$id];
        setcookie('recentviewed', json_encode($arrId), time() + 3600 * 24);
    }
    //them cookie luot xem

    if (!isset($_COOKIE["view_number$id"])) {
        $bookModel->setViewBook($id);
        setcookie("view_number$id", $id, time() + 1);
    }
}


$typeBooks = new TypeBookModel();
$items = $typeBooks->getNameTypeBook();
$userModel = new UserModel();
$modelCart = new CartModel();

//them vao gio hang
if (isset($_SESSION['username']) && isset($_POST['soLuong'])) {
    $id_book = $_GET['id_book'];
    $soLuong = $_POST['soLuong'];
    $username = $_SESSION['username'];
    $itemCart = $modelCart->getAllProductInCart();
    $user = $userModel->getUserByUsername($username);
    $id_user = $user['id_user'];
    //ham kiem tra sach da ton tai trong cart chua? de them moi so luong
    function KiemTraTonTai($itemCart, $id_user, $id_book)
    {
        foreach ($itemCart as $item) {
            if ($id_user == $item['id_user'] && $id_book == $item['id_book']) {
                return true;
            }
        }
        return false;
    }
    if (KiemTraTonTai($itemCart, $id_user, $id_book)) {
        if ($modelCart->updateProductInCart($soLuong, $id_user, $id_book)) {
            //  echo "<script type='text/javascript'>alert('Thêm thành công');</script>";
        }
    } else {
        if ($modelCart->addProductIntoCart($id_book, $soLuong, $id_user)) {
            // echo "<script type='text/javascript'>alert('Thêm thành công');</script>";
        }
    }
}
if (isset($_GET['nextImg'])) {
    $item_photo = explode(",", $itemBook['book_photo']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
        <div class="container-fluid bg-light" style="padding: 0;">
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

        <div class="container" style="margin-top:20px;background: #fff;">
            <div class="row">
                <div class="col-md-4 ">
                    <div class="show_img_main">
                        <button class="next round" onclick="plusDivs(-1)">&#10094;</button>
                        <div class="img_main">
                            <?php
                            $item_photo = explode(",", $itemBook['book_photo']);
                            foreach ($item_photo as $photo) {
                            ?>
                                <img id="theImage" class="mySlides" src="./public/images/<?php echo $photo ?>" alt="" >
                            <?php
                            }
                            ?>
                        </div>
                        <button class="next round" onclick="plusDivs(1)">&#10095;</button>
                    </div>

                    <div class="show_img">

                        <?php
                        foreach ($item_photo as $photo) {
                        ?>
                            <img src="./public/images/<?php
                                                        echo $photo ?>" alt="" class="img-fluid" style="width:20%;">
                        <?php
                        }
                        ?>
                    </div>

                </div>
                <div class="col-md-8">
                    <h3 style="padding-top:65px;"><?php echo $itemBook['book_name'] ?></h3>
                    <div style="padding:8px;">Tác giả : <?php echo $itemBook['author_name'] ?></div>
                    <div style="padding:8px;font-size: 32px;line-height: 32px;color: #C92127;font-family: 'Roboto',sans-serif !important;">
                        <?php echo number_format($itemBook['book_price']) ?> VND</div>
                    <div>
                        Chính sách đổi trả : Đổi trả sản phẩm trong 30 ngày <a href="<?php
                                                                                        if (isset($_GET['user_name'])) {
                                                                                            echo "xemthem.php";
                                                                                        } else {
                                                                                            echo "xemthem.php";
                                                                                        }
                                                                                        ?> " style="text-decoration: auto;">Xem thêm</a>
                    </div>

                    <div class="muaHang">
                        <form action="<?php
                                        if (isset($_SESSION['username'])) {
                                            if (isset($_POST['soLuong'])) {
                                                echo "book.php?id_book={$_GET['id_book']}&soLuong={$_POST['soLuong']}";
                                            }
                                        } else {
                                            echo "account.php?id=1";
                                        }
                                        ?>" method="post" onsubmit=" ">
                            <div for="soLuong" class="form-label" style="padding:17px 0;">Số Lượng:
                                <input type="text" name="soLuong" id="soLuong" value="1">
                            </div>
                            <button type="submit" class="themGioHang" onclick="myFuntion()">Thêm vào giỏ hàng</button>
                            <a href="<?php if (isset($_SESSION['username'])) {
                                        echo "payment.php?id_book=<?php echo {$itemBook['id_book']}";
                                } else {
                                    echo "account.php?id=1";
                                }
                            ?>" type="button" class="buy">Mua ngay</a>
                        </form>
                    </div>
                    <div class="complete"><i class="fa-solid fa-check"></i><br><b>Thêm Sản Phẩm Vào Giỏ Hàng Thành Công</b></div>
                </div>
            </div>
        </div>
        <div class="container" style="margin-top:20px; background:#fff;">
            <h3 style="padding-top:20px">Mô Tả Sản Phẩm</h3>
            <div style="padding:5px;"><?php echo $itemBook['book_description'] ?></div>

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
    <script>
        myFuntion = function() {
            var addcart = document.querySelector('.themGioHang');
            addcart.addEventListener('click',
                document.querySelector('.complete').style.display = "block"
            )
        };
    </script>
    <script>
        var slideIndex = 1;
        showDivs(slideIndex);

        function plusDivs(n) {
            showDivs(slideIndex += n);
        }

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            if (n > x.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = x.length
            }
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            x[slideIndex - 1].style.display = "block";
        }
    </script>
</body>

</html>