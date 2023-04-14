<?php
session_start();
require_once './config/database.php';
spl_autoload_register(
    function ($classname) {
        require "./app/Models/$classname.php";
    }
);

$bookModel = new BookModel();
$typeBooks = new TypeBookModel();
$items = $typeBooks->getNameTypeBook();
if (isset($_POST['deleteID'])) {
    $id_book = $_POST['deleteID'];
    $bookModel->deleteBook($id_book);
    $typeBooks->deletetypeBook($id_book);
}
$bookList = $bookModel->getAllBook();
if (isset($_POST['sort'])) {
    $sort = $_POST['sort'];
    if ($sort == 0) {
        $bookList = $bookModel->getAllBook();
    }
    if ($sort == '1') {
        $bookList = $bookModel->getSortDecreasePrice();
    }
    if ($sort == '2') {
        $bookList = $bookModel->getSortAscendingPrice();
    }
    if ($sort == '3') {
        $bookList = $bookModel->getSortAscendingNameBook();
    }
    if ($sort == '4') {
        $bookList = $bookModel->getSortDecreaseNameBook();
    }
    if ($sort == '5') {
        $bookList = $bookModel->getSortDecreaseIDBook();
    }
    if ($sort == '6') {
        $bookList = $bookModel->getSortAscendingIDBook();
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

<style>
    .search__addBook {
        width: 300px;
        height: 40px;
        margin-right: 20px;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
</style>

<body>
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
                   
                    <form class="d-flex " method="GET" action="addBook.php">

                        <button class="btn btn-outline-success" type="submit" style="margin-right:20px;">Add</button>
                    </form>
                    <form class="d-flex " method="GET" action="manageOrder.php" style="margin-right: 100px;">

                        <button class="btn btn-outline-success" type="submit" style="margin-right:10px;">Quản Lý</button>
                    </form>
                </div>
            </nav>

        </div>
        <div class="container" style="background-color:bisque ;">
            <div class="">
                <p style="padding: 10px 0 0 0;"><b>sắp xếp sản phẩm</b></p>
                <form class="d-flex" action="manageBook.php" method="POST" style="width: 255px;">
                    <select name="sort" class="form-control" style="height: 38px; width: 200px;">
                        <option selected value="0">Mặc định</option>
                        <option value="1">Giá giảm</option>
                        <option value="2">Giá tăng</option>
                        <option value="3">Tên tăng</option>
                        <option value="4">Tên giảm </option>
                        <option value="5">ID tăng</option>
                        <option value="6">ID giảm</option>
                    </select>
                    <button style="width: 120px; margin-left: 10px;" class="btn btn-success" type="submit">Sắp xếp</button>
                </form>
            </div>
            <table class="table">
                <tr>
                    <td>ID</td>
                    <td>Book name</td>
                    <td>Book discription</td>
                    <td>Book price</td>
                    <td>book photo</td>
                    <td>author name</td>
                    <td>id type</td>
                </tr>
                <?php
                foreach ($bookList as $item) {
                ?>

                    <tr>
                        <td><?php echo $item['id_book'] ?></td>
                        <td><?php echo $item['book_name'] ?></td>
                        <td class="book__desciption"><?php echo $item['book_description'] ?></td>
                        <td><?php echo $item['book_price'] ?></td>
                        <td>
                            <?php
                            $photos = explode(',', $item['book_photo']);
                            ?>
                            <img src="public/images/<?php echo reset($photos) ?>" alt="" class="img-fluid " style="width:100px;">

                        </td>
                        <td><?php echo $item['author_name'] ?></td>
                        <td><?php echo $item['id_type'] ?></td>
                        <td>
                            <a href="updateBook.php?id_book=<?php echo $item['id_book'] ?>" class="btn btn-primary ">Edit</a>

                            <form action="manageBook.php" method="post" onsubmit="return confirm('bạn có muốn xóa sản phẩm  <?php echo $item['book_name'] ?>  không?')">
                                <input type="hidden" name="deleteID" value="<?php echo $item['id_book'] ?>">
                                <button type="submit" class="btn btn-danger itemEdit" style="margin-top:20px;">delete</button>

                            </form>
                        </td>
                    </tr>

                <?php
                }
                ?>
            </table>
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