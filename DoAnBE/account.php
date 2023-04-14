<?php
session_start();

require_once './config/database.php';
spl_autoload_register(
    function ($classname) {
        require "./app/Models/$classname.php";
    }
);

$typeBooks = new TypeBookModel();
$items = $typeBooks->getNameTypeBook();
$userModel = new UserModel();
$itemUsers = $userModel->getUser();
global $user;
global $type_user;
global $userByUsername;
function checkAccount($username, $pass, $itemUsers)
{
    foreach ($itemUsers as $item) {
        if (password_verify($pass, $item['pass']) && $item['user_name'] == $username) {
            return true;
        }
    }
    return false;
}
function checkUserExit($username, $itemUsers)
{
    foreach ($itemUsers as $item) {
        if ($item['user_name'] == $username) {
            return false;
        }
    }
    return true;
}
if (!empty($_POST['username']) && !empty($_POST['pass'])) {
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    if ($_GET['id'] == 1) {
        if (checkAccount($username, $pass, $itemUsers)) {
            //lay dia chi username chuyen sang trag giao dien nguoi dung 
            $_SESSION['username'] = $username;
            $userByUsername = $userModel->getUserByUsername($_SESSION['username']);
            //chuyen trang
            if (isset($userByUsername['type_user'])) {
                if (($userByUsername['type_user']) == "customer") {
                    header('Location: index.php');
                } else {
                    header('Location: manageBook.php');
                }
            } else {
                echo "index.php";
            }
        } else {
            echo "<script type='text/javascript'>alert('Tài khoản hoặc mật khẩu sai');</script>";
        }
    } else {
        if (checkUserExit($username, $itemUsers) == false) {

            echo "<script type='text/javascript'>alert('Tài khoản đã tồn tại');</script>";
        } else {
            if ($pass != $_POST['passagain']) {
                echo "<script type='text/javascript'>alert('Mật khẩu không trùng nhau');</script>";
            } else if ($userModel->addUser($username, $pass, "customer")) {
                header('Location: account.php?id=1');
            } else {
                echo "<script type='text/javascript'>alert('Đăng ký thất bại');</script>";
            }
        }
    }
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
                                    <a class="nav-link"> <i class="fa-solid fa-recycle"></i>  Phân Loại
                                        <div class="dropdown-content">
                                            <?php
                                            foreach ($items as $item) {
                                            ?>
                                                <a class="nav-link-content" href="typeBook.php?id_type=<?php echo $item['id_type'] ?>">
                                                    <?php echo $item['type_name'] ?>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </a>

                                </ul>
                            </div>

                            <li class="nav-item">
                                <a class="nav-link" href="" name="cart">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    Giỏ Hàng
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="account.php?id=1">
                                    Đăng Nhập/Đăng Ký
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>
        </div>
        <div class="container-fluid bg-light">

            <div class="container form-box">

                <div class="form-div">
                    <div style="margin-bottom: 2rem;">
                        <a href="account.php?id=1" class="config">
                            Đăng Nhập
                        </a>
                        <a href="account.php?id=2" class="config">
                            Đăng Ký
                        </a>
                    </div>
                    <?php
                    if ($_GET['id'] == 1) {
                    ?>
                        <form action="account.php?id=1" method="post">
                            <div>
                                <label for="username" class="form-label">Tài khoản</label>
                                <input type="text" name="username" id="username" placeholder="Nhập tài khoản của bạn" class="form-control" autofocus>
                            </div>
                            <div>
                                <label for="pass" class="form-label">Mật khẩu</label>
                                <input type="password" name="pass" id="pass" placeholder="Nhập mật khẩu của bạn" class="form-control">
                            </div>
                            <div>
                                <br />
                                <button type="submit" name="dangnhap" class="btn btn-primary" style="margin:auto;display:block;">Đăng Nhập</button>
                            </div>
                        </form>
                    <?php
                    } else if ($_GET['id'] == 2) {
                    ?>

                        <form action="account.php?id=2" method="post">
                            <div>
                                <label for="username" class="form-label">Tài khoản</label>
                                <input type="text" name="username" id="username" placeholder="Nhập tài khoản đăng kí" class="form-control" autofocus>
                            </div>
                            <div>
                                <label for="pass" class="form-label">Mật khẩu(6 kí tự)</label>
                                <input type="password" name="pass" id="pass" placeholder="Nhập mật khẩu đăng kí" class="form-control" maxlength="6">
                            </div>
                            <div>
                                <label for="passagain" class="form-label">Nhập lại mật khẩu</label>
                                <input type="password" name="passagain" id="passagain" placeholder="Nhập lại mật khẩu đăng kí " class="form-control" maxlength="6">
                            </div>
                            <!-- <div style="padding-top:10px;">
                        <label for="customer" class="form-label">Khách Hàng</label>
                        <input type="radio" name="account" id="customer" value="customer" checked>
                        <label for="salesman" class="form-label">Bán Hàng</label>
                        <input type="radio" name="account" id="salesman" value="salesman">
                    </div> -->
                            <div style="margin-top: 19px;">
                                <button type="submit" name="dangky" class="btn btn-primary" style="margin:auto;display:block;">Đăng ký</button>
                            </div>
                        </form>
                    <?php
                    }
                    ?>


                </div>
            </div>
            <!-- Footer -->
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