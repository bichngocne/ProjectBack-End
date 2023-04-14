<?php
require_once './config/database.php';
spl_autoload_register(
    function ($classname)
    {
        require "./app/Models/$classname.php";
    }
);
$bookModel = new BookModel();
$bookList = $bookModel->getAllBook();
$typeBooks = new TypeBookModel();
$items = $typeBooks->getNameTypeBook();
$userModel = new UserModel();
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
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    
    <style>
        .nav-item{
            padding: 15px 15px;
        }
    </style>
</head>
<body>
<div class="top-fluid">
            <div class="container "style="background: #fff;">
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
                        <form class="d-flex" role="search" method="GET" action="search.php" >
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                                name="search" style="margin: auto;">
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: auto;">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?php
                                                                                        if (isset($_GET['user_name'])) {
                                                                                            echo "userInterface.php?user_name=" . $_GET['user_name'];
                                                                                        } else {
                                                                                            echo "index.php";
                                                                                        }
                                                                                        ?>
                            "> <i class="fa-solid fa-house-chimney"></i> Home</a>
                            </li>
                            <div class="dropdown">
                                <ul class="nav-item" style="padding: 0;">
                                    <a class="nav-link"><i class="fa-solid fa-recycle"></i>  Phân Loại
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
                                    <a class="nav-link" href="
                                <?php
                                if (isset($_SESSION['username'])) {
                                    echo "logout.php";
                                } else {
                                    echo "account.php?id=1";
                                }
                                ?>
                                ">
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
<div class="container" style="background:#fff;padding-top: 3%;" >
<pre>
        Chúng tôi luôn trân trọng sự tin tưởng và ủng hộ của quý khách hàng khi trải nghiệm mua hàng tại Fahasa.com. Do đó chúng tôi luôn cố gắng hoàn thiện dịch vụ tốt nhất để phục vụ mọi nhu cầu mua sắm của quý khách.

Fahasa.com chúng tôi luôn luôn cam kết tất cả các sản phẩm bán tại Fahasa.com 100% là những sản phẩm chất lượng và xuất xứ nguồn gốc rõ ràng, hợp pháp cũng như an toàn cho người tiêu dùng. Để việc mua sắm của quý khách tại Fahasa.com là trải nghiệm dịch vụ thân thiện, chúng tôi hy vọng quý khách sẽ kiểm tra kỹ các nội dung sau trước khi nhận hàng: 

Thông tin sản phẩm: tên sản phẩm và chất lượng sản phẩm.

Số lượng sản phẩm.

Thông tin sản phẩm, người nhận (Đối chiếu với thông tin trên phiếu giao hàng được bỏ trong hộp) trong lúc nhận hàng trước khi ký nhận và thanh toán tiền cho nhân viên giao nhận.

Trong trường hợp hiếm hoi sản phẩm quý khách nhận được có khiếm khuyết, hư hỏng hoặc không như mô tả, Fahasa.com cam kết bảo vệ khách hàng bằng chính sách đổi trả/ hoàn tiền trên tinh thần bảo vệ quyền lợi người tiêu dùng nhằm cam kết với quý khách về chất lượng sản phẩm và dịch vụ của chúng tôi.

Khi quý khách hàng có hàng hóa mua tại Fahasa.comcần đổi/ trả/bảo hành/hoàn tiền, xin quý khách hàng liên hệ với chúng tôi qua hotline 1900636467 hoặc truy cập fahasa.com/chinh-sach-doi-tra-hang để tìm hiểu thêm về chính sách đổi/trả:

1. Thời gian áp dụng đổi/trả
 

KỂ TỪ KHI FAHASA.COM GIAO HÀNG THÀNH CÔNG

SẢN PHẨM LỖI
(do nhà cung cấp)

SẢN PHẨM KHÔNG LỖI (*)

SẢN PHẨM LỖI DO NGƯỜI SỬ DỤNG

Sản phẩm Điện tử, Đồ chơi điện - điện tử, điện gia dụng,... (có tem phiếu bảo hành từ nhà cung cấp)

7 ngày đầu tiên

Đổi mới

Trả hàng không thu phí

Bảo hành hoặc sửa chữa có thu phí theo quy định của nhà cung cấp.

Trả không thu phí

8 - 30 ngày

Bảo hành

30 ngày trở đi

Bảo hành

Không hỗ trợ đổi/ trả

Voucher/ E-voucher

30 ngày đầu tiên

Đổi mới

Không hỗ trợ đổi/ trả

Không hỗ trợ đổi/ trả

Trả hàng không thu phí

30 ngày trở đi

Không hỗ trợ đổi trả

Đối với các ngành hàng còn lại

30 ngày đầu tiên

Đổi mới

Trả hàng không thu phí

Không hỗ trợ đổi/ trả

Trả không thu phí

30 ngày trở đi

Không hỗ trợ đổi/ trả

 

Fahasa.com sẽ tiếp nhận thông tin yêu cầu đổi trả của quý khách trong vòng 3 ngày kể từ khi quý khách nhận hàng thành công.

Sau khi Fahasa.com xác nhận mail tiếp nhận yêu cầu kiểm tra xử lý, Fahasa.com sẽ liên hệ đến quý khách để xác nhận thông tin hoặc nhờ bổ sung thông tin (nếu có). Trường hợp không liên hệ được Fahasa.com rất tiếc xin được phép từ chối xử lý yêu cầu. Thời gian Fahasa.com liên hệ trong giờ hành chính tối đa 3 lần trong vòng 7 ngày sau khi nhận thông tin yêu cầu.

Chúng tôi sẽ kiểm tra các trường hợp trên và giải quyết cho quý khách tối đa trong 30 ngày làm việc kể từ khi quý khách nhận được hàng, quá thời hạn trên rất tiếc chúng tôi không giải quyết khiếu nại.

2. Các trường hợp yêu cầu đổi trả
Lỗi kỹ thuật của sản phẩm - do nhà cung cấp (sách thiếu trang, sút gáy, trùng nội dung, sản phẩm điện tử, đồ chơi điện – điện tử không hoạt động..)

Giao nhầm/ giao thiếu (thiếu sản phẩm đã đặt, thiếu phụ kiện, thiếu quà tặng kèm theo)

Chất lượng hàng hóa kém, hư hại do vận chuyển.

Hình thức sản phẩm không giống mô tả ban đầu.

Quý khách đặt nhầm/ không còn nhu cầu (*)

(*) Đối với các Sản phẩm không bị lỗi, chỉ áp dụng khi sản phẩm đáp ứng đủ điều kiện sau:

Quý khách có thể trả lại sản phẩm đã mua tại Fahasa.com trong vòng 30 ngày kể từ khi nhận hàng với đa số sản phẩm khi thỏa mãn các điều kiện sau:

Sản phẩm không có dấu hiệu đã qua sử dụng, còn nguyên tem, mác hay niêm phong của nhà sản xuất.

Sản phẩm còn đầy đủ phụ kiện hoặc phiếu bảo hành cùng quà tặng kèm theo (nếu có).

Nếu là sản phẩm điện – điện tử thì chưa bị kích hoạt, chưa có sao ghi dữ liệu vào thiết bị.

3. Điều kiện đổi trả
Fahasa.com hỗ trợ đổi/ trả sản phẩm cho quý khách nếu:

Sản phẩm còn nguyên bao bì như hiện trạng ban đầu.

Sản phầm còn đầy đủ phụ kiện, quà tặng khuyến mãi kèm theo.

Hóa đơn GTGT (nếu có).

Cung cấp đầy đủ thông tin đối chứng theo yêu cầu (điều 4).

4. Quy trình đổi trả
Quý khách vui lòng thông tin đơn hàng cần hỗ trợ đổi trả theo Hotline 1900636467 hoặc email về địa chỉ: cskh@fahasa.com.vn với tiêu đề “Đổi Trả Đơn Hàng " Mã đơn hàng".

Quý khách cần cung cấp đính kèm thêm các bằng chứng để đối chiếu/ khiếu nại sau:

+ Video clip mở kiện hàng từ lúc bắt đầu khui ngoại quan đến kiểm tra sản phẩm bên trong thùng hàng.

+ Hình chụp tem kiện hàng có thể hiện mã đơn hàng.

+ Hình chụp tình trạng ngoại quan (băng keo, seal, hình dạng thùng hàng, bao bì), đặc biệt các vị trí nghi ngờ có tác động đến sản phẩm (móp méo, ướt, rách...)

+ Hình chụp tình trạng sản phẩm bên trong, nêu rõ lỗi kỹ thuật nếu có.


Chính sách sẽ được áp dụng và có hiệu lực từ ngày01/08/2022


ƯU ĐÃI LIÊN QUAN
</pre>
    </div>
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
            <a class="item__icon" style="font-size:40px;" > <i class="fa-brands fa-facebook"></i> </a>
                <a class="item__icon" style="font-size:40px;">  <i class="fa-brands fa-youtube"></i> </a>
                <a class="item__icon" style="font-size:40px;">  <i class="fa-brands fa-square-instagram"></i>  </a>
                <a class="item__icon" style="font-size:40px;">   <i class="fa-brands fa-twitter"></i>  </a>
                <a class="item__icon" style="font-size:40px;">   <i class="fa-brands fa-telegram"></i>  </a>
                <img src="./public/images/ggPlay.png" alt="" class="img-fluid item__dowloadApp">
            <img src="./public/images/Download_on_the_App_Store_Badge.svg.png" alt="" class="img-fluid item__dowloadAppstore">
            </div>
                <div class="col-md-8 right__footer">
                    <div class="row">
                        <div class="col-md-4 ">
                            <h5 >Dịch vụ</h5>
                            <a href="" class="item__footerRight" >Điều khoản sử dụng</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight" >Chính sách bảo mật thông tin cá nhân</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight" >Chính sách bảo mật thanh toán</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight" >Giới thiệu Daisuki</a>
                        </div>
                        <div class="col-md-4">
                            <h5 >Hỗ trợ</h5>
                            <a href="" class="item__footerRight" >Chính sách đổi trả-hoàn tiền</a>
                            <br>
                            <br>
                            
                            <a href="" class="item__footerRight" >Chính sách bảo hành - bồi toàn</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight" >Chính sách vận chuyển </a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight" >Chính sách khách sỉ</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight" >Chính sách thanh toán và xuất HĐ</a>
                        </div>
                        
                        <div class="col-md-4">
                            <h5 >Tài khoản của tôi</h5>
                            <a href="account.php?id=1" class="item__footerRight" >Đăng nhập/Tạo tài khoản mới</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight" >Thay đổi địa chỉ khách hàng</a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight" >Chi tiết tài khoản </a>
                            <br>
                            <br>
                            <a href="" class="item__footerRight" >Lịch sử mua hàng</a>
                            
                        </div>
                        
                    </div>
                    <h5 style=" margin-top: 20px;">Liên hệ </h5>
                    <a class="item__lienhe"><i class="fa-solid fa-location-dot"></i>14/6,Linh Trung ,Thủ Đức.</a>
                    <a class="item__lienhe"> <i class="fa-solid fa-envelope"></i>daisuki@gmail.com  </a> 
                    <a class="item__lienhe">  <i class="fa-solid fa-phone"></i> 0985663329</a>
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