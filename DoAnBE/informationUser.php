<?php
session_start();
require_once './config/database.php';
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
if (isset($_GET['id_conscious'])) {
    $id = $_GET['id_conscious'];
    $districtList = $address->getDistric($id);
}

if (isset($_SESSION["districtList"])) {
    $districtList = $_SESSION["districtList"];
} else {
    $districtList = $address->getDistric(1);
}

// wards
if (isset($_GET['wards_id'])) {
    $id = $_GET['wards_id'];
    $wardsList = $address->getWards($id);
}
if (isset($_SESSION["wardList"])) {
    $wardsList = $_SESSION["wardList"];
} else {
    $wardsList = $address->getWards(1);
}

// voucher
$vouchers = new voucherModel();
$voucherList = $vouchers->getAllVouchers();

// cart
// $cart = new CartModel();

// $cartList = $cart->getProductByIdUser($id);
// hiện sản phẩm
$bookModel = new BookModel();
if (isset($_GET['id_book'])) {
    $id = $_GET['id_book'];
    $itemBook = $bookModel->getBookById($id);
}
$addressModel = new AddressModel();

if (isset($_POST["provinceId"])) {
    $_SESSION["districtList"] = $districtList;
    $districtList = $addressModel->getDistric($_POST["provinceId"]);

    $_SESSION["provinceId"] = $_POST["provinceId"];
}
if (isset($_POST["districtID"])) {

    $_SESSION["wardList"] = $wardsList;
    $wardsList = $addressModel->getWards($_POST["districtID"]);
    $_SESSION["districtID"] = $_POST["districtID"];
}
$userModel = new UserModel();
if (isset($_POST['name_customer']) && isset($_POST['email_customer']) && isset($_POST['phone_customer']) && isset($_POST['provinceId']) && isset($_POST['districtID']) && isset($_POST['wardID'])) {
    $fullname = $_POST['name_customer'];
    $email = $_POST['email_customer'];
    $phone = $_POST['phone_customer'];
    $address_detail = $_POST['address_customer'];
    $id_consious = $_POST['provinceId'];
    $id_distric = $_POST['districtID'];
    $id_ward = $_POST['wardID'];
    if ($userModel->addAddressUser($fullname,$email,$phone,$id_ward,$id_distric,$id_consious,$address_detail, $_SESSION['username'])) {
        echo "Lưu thông tin thành công";
    } else {
        echo "Lưu thông tin thất bại!!";
    }
}
$address_user = $userModel->getAddressUser($_SESSION['username']);
if (isset($_POST['deleteID'])) {
    $userModel->deleteAddress($_SESSION['username']);
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
        <!-- content -->
        <?php
        if ($address_user == null) {
        ?>
            <div class="menu">
                <a href="informationUser.php?id=1">
                    <h5>Địa chỉ giao hàng</h5>
                </a>
            </div>
            <div class="giaoHang">

                <form action="informationUser.php?id=1" method="post" id="cart_form">


                    <div class="row item__customer">
                        <div class="col-md-2"> <label class="" for="name_customer">Họ và tên người nhận</label> </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name_customer" id="name_customer" value="<?php if (isset($_POST['name_customer'])) echo $_POST['name_customer'] ?>" placeholder="Nhập vào họ và tên người nhận">
                        </div>
                    </div>

                    <div class="row item__customer">
                        <div class="col-md-2"> <label class="" for="email_customer">Email </label> </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="email_customer" id="email_customer" value="<?php if (isset($_POST['email_customer'])) echo $_POST['email_customer'] ?>" placeholder="Nhập vào Email">
                        </div>
                    </div>
                    <div class="row item__customer">
                        <div class="col-md-2"> <label class="" for="phone_customer">Số điện thoại</label> </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="phone_customer" id="phone_customer" value="<?php if (isset($_POST['phone_customer'])) echo $_POST['phone_customer'] ?>" placeholder="Nhập vào số điện thoại">
                        </div>
                    </div>

                    <div class="row item__customer">
                        <div class="col-md-2"> <label class="" for="conscious_customer">Tỉnh/Thành phố</label> </div>
                        <div class="col-md-10">
                            <select id="provinceList" class="form-select" name="provinceId" aria-label="Default select example">
                                <?php

                                foreach ($consiousList as $item) {
                                ?>

                                    <?php
                                    if (isset($_SESSION["provinceId"])) { ?>

                                        <option value="<?php echo $item['id'] ?>" <?php echo $item["id"] == $_SESSION["provinceId"] ? 'selected' : '' ?>><?php echo $item['name_conscious'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $item['id'] ?>"><?php echo $item['name_conscious'] ?></option>

                                <?php

                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>

                    <div class="row item__customer">
                        <div class="col-md-2"> <label class="" for="conscious_customer">Quận / Huyện</label> </div>
                        <div class="col-md-10">
                            <select id="districtList" class="form-select" name="districtID" aria-label="Default select example">
                                <?php
                                foreach ($districtList as $item) {

                                ?>
                                    <?php
                                    if (isset($_SESSION["districtID"])) {
                                    ?>
                                        <option value="<?php echo $item['id_district'] ?>" <?php echo $item["id_district"] == $_SESSION["districtID"] ? 'selected' : '' ?>><?php echo $item['name'] ?></option>
                                    <?php } else { ?>
                                        <?php
                                        if (isset($districtList)) {
                                            foreach ($districtList as $itemDistrict) {
                                        ?>
                                                <option value="<?php echo $itemDistrict['id_district'] ?>"> <?php echo $itemDistrict['name'] ?> </option>
                                        <?php
                                            }
                                        }
                                        ?>

                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row item__customer">
                        <div class="col-md-2"> <label class="" for="conscious_customer">Phường/ Xã</label> </div>
                        <div class="col-md-10">
                            <select class="form-select" id="wardList" name="wardID" aria-label="Default select example">
                                <?php


                                if (isset($wardsList)) {
                                    foreach ($wardsList as $itemWard) {
                                ?>
                                        <option value="<?php echo $itemWard['wards_id'] ?>"> <?php echo $itemWard['name'] ?> </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row item__customer">
                        <div class="col-md-2"> <label class="" for="address_customer">Địa chỉ nhận hàng</label> </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="address_customer" id="address_customer" placeholder="Nhập vào địa chỉ nhận hàng">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger" style="float: right;">Lưu Địa Chỉ</button>

                </form>
            <?php
        } else {
            ?>
                <div class="menu">
                    <a href="informationUser.php?id=1">
                        <h5>Thay đổi địa chỉ giao hàng</h5>
                    </a>
                    <a href="informationUser.php?id=2">
                        <h5>Địa chỉ giao hàng</h5>
                    </a>
                </div>
                <div class="giaoHang">

                    <?php

                    if ($_GET['id'] == 1) {
                    ?>
                        <form action="informationUser.php?id=1" method="post" id="cart_form">


                            <div class="row item__customer">
                                <div class="col-md-2"> <label class="" for="name_customer">Họ và tên người nhận</label> </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="name_customer" id="name_customer" value="<?php if (isset($_POST['name_customer'])) echo $_POST['name_customer'] ?>" placeholder="Nhập vào họ và tên người nhận">
                                </div>
                            </div>

                            <div class="row item__customer">
                                <div class="col-md-2"> <label class="" for="email_customer">Email </label> </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="email_customer" id="email_customer" value="<?php if (isset($_POST['email_customer'])) echo $_POST['email_customer'] ?>" placeholder="Nhập vào Email">
                                </div>
                            </div>
                            <div class="row item__customer">
                                <div class="col-md-2"> <label class="" for="phone_customer">Số điện thoại</label> </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="phone_customer" id="phone_customer" value="<?php if (isset($_POST['phone_customer'])) echo $_POST['phone_customer'] ?>" placeholder="Nhập vào số điện thoại">
                                </div>
                            </div>

                            <div class="row item__customer">
                                <div class="col-md-2"> <label class="" for="conscious_customer">Tỉnh/Thành phố</label> </div>
                                <div class="col-md-10">
                                    <select id="provinceList" class="form-select" name="provinceId" aria-label="Default select example">
                                        <?php

                                        foreach ($consiousList as $item) {
                                        ?>

                                            <?php
                                            if (isset($_SESSION["provinceId"])) { ?>

                                                <option value="<?php echo $item['id'] ?>" <?php echo $item["id"] == $_SESSION["provinceId"] ? 'selected' : '' ?>><?php echo $item['name_conscious'] ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $item['id'] ?>"><?php echo $item['name_conscious'] ?></option>

                                        <?php

                                            }
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>

                            <div class="row item__customer">
                                <div class="col-md-2"> <label class="" for="conscious_customer">Quận / Huyện</label> </div>
                                <div class="col-md-10">
                                    <select id="districtList" class="form-select" name="districtID" aria-label="Default select example">
                                        <?php
                                        foreach ($districtList as $item) {

                                        ?>
                                            <?php
                                            if (isset($_SESSION["districtID"])) {
                                            ?>
                                                <option value="<?php echo $item['id_district'] ?>" <?php echo $item["id_district"] == $_SESSION["districtID"] ? 'selected' : '' ?>><?php echo $item['name'] ?></option>
                                            <?php } else { ?>
                                                <?php
                                                if (isset($districtList)) {
                                                    foreach ($districtList as $itemDistrict) {
                                                ?>
                                                        <option value="<?php echo $itemDistrict['id_district'] ?>"> <?php echo $itemDistrict['name'] ?> </option>
                                                <?php
                                                    }
                                                }
                                                ?>

                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row item__customer">
                                <div class="col-md-2"> <label class="" for="conscious_customer">Phường/ Xã</label> </div>
                                <div class="col-md-10">
                                    <select class="form-select" id="wardList" name="wardID" aria-label="Default select example">
                                        <?php


                                        if (isset($wardsList)) {
                                            foreach ($wardsList as $itemWard) {
                                        ?>
                                                <option value="<?php echo $itemWard['wards_id'] ?>"> <?php echo $itemWard['name'] ?> </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row item__customer">
                                <div class="col-md-2"> <label class="" for="address_customer">Địa chỉ nhận hàng</label> </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="address_customer" id="address_customer" placeholder="Nhập vào địa chỉ nhận hàng">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger" style="float: right;">Lưu Địa Chỉ</button>

                        </form>
                    <?php
                    } else {
                    ?>
                        <div class="address" style="background-color: #fff; padding:20px;">
                            <?php
                               $fullname = $address_user['fullname'];
                               $email = $address_user['email'];
                               $phone = $address_user['phone'];
                               $id_ward = $address->getNameward($address_user['id_ward']);
                               $id_distric =$address->getNameDistric($address_user['id_distric']);
                               $id_consious = $address->getNameConscious($address_user['id_consious']);
                               $address_detail= $address_user['address_detail'];
                               echo "$fullname, $email, $phone, $address_detail,$id_ward, $id_distric, $id_consious";
                            ?>
                        </div>
                        
                        <form action="informationUser.php?id=2" method="post">
                                <input type="hidden" name="deleteID" value="deleteAddress">
                                <button type="submit" class="btn btn-danger itemEdit" style="margin-top:20px;">Xoá địa chỉ</button>

                            </form>
                <?php
                    }
                }
                ?>

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
                        cartForm.action = "informationUser.php?id=1";

                        cartForm.submit();
                    }
                );
                selectedDistrict.addEventListener(
                    "change",
                    function() {
                        cartForm.action = "informationUser.php?id=1";
                        cartForm.submit();

                    }
                );
            </script>
</body>

</html>