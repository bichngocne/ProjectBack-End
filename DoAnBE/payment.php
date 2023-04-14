<?php
require_once './config/database.php';
session_start();
spl_autoload_register(
    function ($classname) {
        require "./app/Models/$classname.php";
    }
);
$bookModel = new BookModel();
$bookList = $bookModel->getAllBook();
$typeBooks = new TypeBookModel();
$items = $typeBooks->getNameTypeBook();
// Sử ly address
$address = new AddressModel();
$consiousList = $address->getAllConscious();
global $districtList;
if (isset($_POST['id_conscious'])) {
    $id = $_POST['id_conscious'];
    $districtList = $address->getDistric($id);
}

if (isset($_SESSION["districtList"])) {
    $districtList = $_SESSION["districtList"];
}

// wards
if (isset($_POST['wardID'])) {
    $id = $_POST['wardID'];
    $wardsList = $address->getWards($id);
}
if (isset($_SESSION["wardList"])) {
    $wardsList = $_SESSION["wardList"];
}
//oucher
$vouchers = new voucherModel();
$voucherList = $vouchers->getAllVouchers();

// cart
// $cart = new CartModel();

// $cartList = $cart->getProductByIdUser($id);
// hiện sản phẩm
$bookModel = new BookModel();
if (isset($_GET['id_book'])) {
    $_GET['id_book'];
    $id = $_GET['id_book'];
    $ids = explode(",", $id);
}
$addressModel = new AddressModel();
if (isset($_POST["provinceId"])) {
    $districtList = $addressModel->getDistric($_POST["provinceId"]);

    $_SESSION["provinceId"] = $_POST["provinceId"];
    $districtList = $address->getDistric($_POST["provinceId"]);
}
if (isset($_POST["districtID"])) {

    $wardsList = $addressModel->getWards($_POST["districtID"]);
    $_SESSION["districtID"] = $_POST["districtID"];
}
$userModel = new UserModel();
$addressUser = $userModel->getAddressUser($_SESSION['username']);
if ($addressUser == "") {
    header('Location: informationUser.php?id=1');
}

$fullname = $addressUser['fullname'];
$email = $addressUser['email'];
$phone = $addressUser['phone'];
$id_ward = $address->getNameward($addressUser['id_ward']);
$id_distric = $address->getNameDistric($addressUser['id_distric']);
$id_consious = $address->getNameConscious($addressUser['id_consious']);
$address_detail = $addressUser['address_detail'];
$id_user = $userModel->getUserID($_SESSION['username']);
if (isset($_POST['fav_language']) && isset($_POST['payment'])) {
    $deliver = $_POST['fav_language'];
    $payment = $_POST['payment'];
    $id_product = $_GET['id_book'];
    $voucher = $_POST['voucher'];
    $quantity = $_POST['soLuong'];
    foreach ($ids as $id) {
        $itemBook = $bookModel->getBookById($id);
        $price +=  $itemBook['book_price'];
    }
    $id_ward1 = $addressUser['id_ward'];
    $id_distric1 = $addressUser['id_distric'];
    $id_consious1 = $addressUser['id_consious'];
    if ($voucher == 1) {
        $price = $price - 2;
    } else if ($voucher == 2) {
        $price = $price - 5;
    } else {
        $price = $price - 10;
    }
    $cartModel = new CartModel();
    $invoice_code = $cartModel->payment($id_user, $fullname, $email, $phone, $id_ward1, $id_distric1, $id_consious1, $address_detail);
    if ($cartModel->addOderItem($invoice_code, $id_product, $quantity, $price, $voucher)) {
        $id = $_GET['id_book'];
        $ids = explode(",", $id);

        foreach ($ids as $id_book) {
            $cartModel->deleteID($id_book);
        }
    }
    header('Location: succeed.php');
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

        <div class="container">
            <?php

            if ($addressUser != null) {

            ?>
                <div class="address1" style="background-color: #fff; padding:20px;">
                    <h3 style="margin-top: 10px;">Địa chỉ</h3>
                    <?php

                    echo "$fullname, $email, $phone, $address_detail,$id_ward, $id_distric, $id_consious";
                    ?>

                </div>

            <?php
            }

            ?>
            <form action="payment.php?id_book=<?php echo $_GET['id_book'] ?>" method="post" id="cart_form">
                <div class="payment_form">



                    <!-- Phương thức vận chuyển -->
                    <div class="phuongThucVC">
                        <h5>Phương thức vận chuyển</h5>
                        <hr>
                        <input type="radio" class="ptvc" id="GHN" name="fav_language" value="GiaoHangNhanh">
                        <label for="html">Giao hàng nhanh</label>
                        <input type="radio" class="ptvc" id="GHN" name="fav_language" checked value="GiaoHangTiepKiem">
                        <label for="html">Giao hàng tiết kiệm</label>
                        <input type="radio" class="ptvc" id="GHN" name="fav_language" value="HoaToc">
                        <label for="html">Hoả tốc</label>
                    </div>
                    <!-- phương thức thanh toán -->

                    <div class="phuongThucTT">
                        <h5>Phương thức thanh toán</h5>
                        <hr>
                        <div class="item__pttt">
                            <input type="radio" class="pttt" id="GHN" name="payment" value="zalopay">
                            <label for="html"><img src="./public/images/zalopay.jpg" alt="zalopay" class="img-fluid item_img"> Ví zalopay</label>
                        </div>

                        <div class="item__pttt">
                            <input type="radio" class="pttt" id="GHN" name="payment" value="moca">
                            <label for="html"><img src="./public/images/moca.jpg" alt="moca" class="img-fluid item_img"> Ví Moca trên ứng dụng Grab</label>
                        </div>

                        <div class="item__pttt">
                            <input type="radio" class="pttt" id="GHN" name="payment" value="VNPay">
                            <label for="html"><img src="./public/images/vnpayqr.png" alt="VNPay" class="img-fluid item_img"> VNpay</label>
                        </div>

                        <div class="item__pttt">
                            <input type="radio" class="pttt" id="GHN" name="payment" value="ShoopePay">
                            <label for="html"><img src="./public/images/shopee-pay-logo-2217CDC100-seeklogo.com.png" alt="ShoopePay" class="img-fluid item_img"> Ví ShoopePay</label>
                        </div>

                        <div class="item__pttt">
                            <input type="radio" class="pttt" id="GHN" name="payment" value="momp">
                            <label for="html"> <img src="./public/images/appmomo.png" alt="momp" class="img-fluid item_img"> Ví Momo</label>
                        </div>

                        <div class="item__pttt">
                            <input type="radio" class="pttt" id="GHN" name="payment" value="ATM">
                            <label for="html"> <img src="./public/images/banking.jpg" alt="ATM" class="img-fluid item_img"> ATM / Internet Banking</label>
                        </div>

                        <div class="item__pttt">
                            <input type="radio" class="pttt" id="GHN" name="payment" value="Tienmat" checked>
                            <label for="html"> <img src="./public/images/tienMat.jpg" alt="cost" class="img-fluid item_img"> Thanh Toán bằng tiền mặt</label>
                        </div>
                    </div>
                    <!-- khuyến mãi -->
                    <div class="khuyenMai">
                        <h5>Mã khuyến mãi / quà tặng</h5>
                        <div class="item__pttt">
                            <?php
                            foreach ($voucherList as $value) {

                            ?>
                                <input type="radio" class="voucher" id="GHN" checked name="voucher" value="<?php echo $value["id_voucher"] ?>">
                                <label for="html" style="margin-right:20px;"><?php echo $value["name_voucher"] ?> </label>
                            <?php
                            }
                            ?>
                        </div>

                        <hr>
                    </div>

                    <!-- Kiểm tra lại đơn hàng -->
                    <div class="testLai">
                        <h5>Kiểm tra lại đơn hàng</h5>
                        <hr>

                        <div class="row">
                            <?php
                            foreach ($ids as $id) {
                                $itemBook = $bookModel->getBookById($id);
                            ?>
                                <div class="col-md-3 ">
                                    <img src="./public/images/<?php $item_photo = explode(",", $itemBook['book_photo']);
                                                                echo $item_photo[0] ?>" alt="" class="img-fluid" style="width:50%;margin: 16%">

                                </div>
                                <div class="col-md-9">
                                    <h4><?php echo $itemBook['book_name'] ?></h4    >
                                    <div>Tác giả : <?php echo $itemBook['author_name'] ?></div>
                                    <div style="padding:8px;font-size: 32px;line-height: 32px;color: #C92127;font-family: 'Roboto',sans-serif !important;">
                                        <?php echo number_format($itemBook['book_price']) ?> VND</div>
                                    <div for="soLuong" class="form-label" style="padding:8px;">Số Lượng:
                                        <input type="text" name="soLuong" id="soLuong" value="<?php if (isset($_POST['soLuong'])) {
                                                                                                    echo $_POST['soLuong'];
                                                                                                } else {

                                                                                                    echo "1";
                                                                                                } ?>">
                                    </div>
                                </div>
                                <hr>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!-- thành tiền -->

                    <div class="thanhTien">
                        <?php
                        $gia = 0;
                        foreach ($ids as $id) {
                            $itemBook = $bookModel->getBookById($id);
                            $gia +=  $itemBook['book_price'];
                            $voucher = 5000;
                        }
                        // if($voucher == 1){
                        //     $khuyenMai = 2;
                        // }else if($voucher == 2){
                        //     $khuyenMai = 5;
                        // }else{
                        //     $khuyenMai = 10;
                        // }
                        if (isset($_POST['soLuong'])) {
                            $soLuong = $_POST['soLuong'];
                        } else {

                            $soLuong = 1;
                        }
                        ?>
                        <pre>Thành tiền       <?php echo   number_format($thanhTien = $gia * $soLuong) . " đ" ?></pre>
                        <pre>Phí vận chuyển   <?php echo  number_format(16000) . " đ" ?></pre>
                        <pre>Khuyến mãi       <?php echo  number_format($voucher) . " đ" ?></pre>
                        <b>
                            <pre>Tổng tiền        <?php echo  number_format($thanhTien + $voucher) . " đ" ?> </pre>
                        </b>


                        <hr>
                        <button type="submit" class="xacNhan">Xác nhận thanh toán</button>
                    </div>
                </div>

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
        let cartForm = document.querySelector("#cart_form");
        let selectedProvince = document.querySelector("#provinceList");
        let selectedDistrict = document.querySelector("#districtList");
        selectedProvince.addEventListener(
            "change",
            function() {
                // console.log(selectedProvince);
                cartForm.action = "payment.php?id_book=<?php echo $_GET['id_book'] ?>";

                cartForm.submit();
            }
        );
        selectedDistrict.addEventListener(
            "change",
            function() {
                cartForm.action = "payment.php?id_book=<?php echo $_GET['id_book'] ?>";
                cartForm.submit();
            }
        );
    </script>
</body>

</html>