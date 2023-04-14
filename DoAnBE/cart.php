<?php
session_start();
require_once './config/database.php';
spl_autoload_register(
    function ($classname) {
        require "./app/Models/$classname.php";
    }
);
$cartModel = new CartModel();
$userModel = new UserModel();
$bookModel = new BookModel();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = $userModel->getUserByUsername($username);
    $id_user = $user['id_user'];
    $itemProduct = $cartModel->getProductByIdUser($id_user);
}
if (isset($_POST['submit_del_product']) && $_POST['submit_del_product'] == 1) {
    if (!empty($_POST['productCart'])) {
        $id_books = $_POST['productCart'];
        foreach ($id_books as $id_book) {
            if ($cartModel->deleteID($id_book)) {
                header("Location:cart.php");
            } else {
                echo ("ERROR!!");
            }
        }

        $itemProduct = $cartModel->getProductByIdUser($id_user);
    }
}
if (isset($_POST['productCart'])) {
    if (isset($_POST['submit']) && $_POST['submit'] == 0) {
        $id_books = $_POST['productCart'];
        $temp = "";
        for ($i = 0; $i < count($id_books); $i++) {
            $temp .= "$id_books[$i],";
        }
        $temp = rtrim($temp, ",");
        header("Location: payment.php?id_book=$temp");
    }
}
$typeBooks = new TypeBookModel();
$items = $typeBooks->getNameTypeBook();
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

        <!-- san pham gio hang -->
        <div class="container">
            <form action="cart.php" method="post" enctype="multipart/form-data">
                <table class="table" style="background:#fff;">
                    <tr class="cart_item">
                        <th class="product_item"> <input type="checkbox" id="allProducts" onclick="toggle(this)">Sản phẩm </th>
                        <th>Đơn giá </th>
                        <th>Số lượng</th>
                        <th>Số tiền</th>
                        <th>Thao tác</th>
                    </tr>
                    <?php
                    foreach ($itemProduct as $item) {

                    ?>
                        <tr>
                            <td style="font-size: 15px;text-overflow:ellipsis;"> <input type="checkbox" name="productCart[]" id="productCart" value="<?php echo $item['id_book'] ?>" />
                                <a href="book.php?id_book=<?php echo $item['id_book'] ?>" class="book__item">

                                    <img src="./public/images/<?php $item_photo = explode(",", $item['book_photo']);
                                                                echo $item_photo[0] ?>" alt="" class="img-fluid " style="width:100px;">
                                    <?php echo $item['book_name'] ?>
                                </a>

                            </td>
                            <td class="book__desciption"><?php echo $item['book_price'] ?></td>
                            <td><?php echo $item['soLuong'] ?></td>
                            <td><?php echo $item['book_price'] * $item['soLuong']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <?php
                if ($itemProduct != null) {
                ?>
                    <div class="payment_cart_right">

                        <button id="payment_Product_checked" class="btn btn-danger" value="0" name="submit"> Mua Hàng</button>
                        <input type="hidden" name="deleleID[]" id="delete_product" value="<?php echo $item['id_book'] ?>">
                        <button type="submit" class="btn btn-danger" id="submit_del_product" name="submit_del_product" onclick="checkButton()">Xoá</button>
                    </div>
                <?php
                }
                ?>

            </form>
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
        function toggle(source) {
            checkboxes = document.getElementsByName('productCart[]');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        function CheckAll() {
            // var payment = document.getElementById('payment_Product_checked');
            // var del = document.getElementById('delete_product');

            if (document.getElementById('allProducts').clicked == true) {
                // itemProduct.forEach(element => {
                //     del.textContent+=element+",";

                // });
                return true;
            }
            return false;
        }

        function checkButton() {
            document.getElementById('submit_del_product').value = 1;
        }
    </script>
</body>

</html>