<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php basic</title>
</head>

<body>
    <h1>Làm quen với PHP</h1>
    <!-- Cách tạo php -->
    <?php
    //echo "xin chào";
    // - Làm quen với biến
    //  $fullname = "Nguyễn Q"; // fullname ở đây là biến , và Nguyễn Q là kiểu dữ liệu chuỗi
    //echo $fullname;
    //- phép toán nối chuỗi
    // cách 1 : echo "Xin chào , {$fullname} !"; khuyến khích
    // cách 2 : echo "Xin chào".$fullname;
    // - phép toán ( có thể là nhiều thứ)
    //  $a =10;
    //  $b = 20;
    //  echo $a + $b
    // Cấu trúc If - else
    //    $is_login = true;
    //    if($is_login == true){
    //       echo "Chúc mừng bạn đã đăng nhập thành công";
    //    }else{
    //     echo "Bạn vui lòng xem lại ";
    //    }
    // - Vòng lập
    // $n = 1000;
    // $sum =0;
    // for($i=1; $i<=$n;$i++){
    //     if($i%2!=0){
    //         $sum = $sum + $i;
    //     }
    // echo $i."<br>";
    // }
    // echo $sum;
    // - Hàm
    // function total_odd($n){
    //     $sum = 0;
    // for($i=1; $i<=$n;$i++){
    //     if($i%2!=0){
    //         $sum = $sum + $i;
    //     }
    //     // echo $i."<br>";
    // }
    // return $sum;
    // }
    //- Post , Get
    // $username = $_POST['username'];
    // $password = $_POST['password'];
    // echo "xin chào ".$username."-----".$password;
    // <form class="mb-3" action="basic.php" method="post">
    //     <label for="" class="form-label">Tên</label>
    //     <input type="email" class="form-control" name="username" id="" placeholder="abc@mail.com" />
    //     <label for="" class="form-label">Mật khẩu</label>
    //     <input type="password" class="form-control" name="password" />
    //     <button type="submit" class="btn btn-primary">
    //         Đăng nhập
    //     </button>

    // </form>
// - Làm quen với mảng
$stuednt_1 = "Cương";
$student_2 = "Hằng";
$students = array('Cương','Hằng');
// // print_r($students);
// //- để nạp thêm cái mới
$students[] = "Anh";
// // - để truy xuất dữ liệu của Cương 
// print_r($students[0]);
// Vòng lặp mảng
foreach($students as $item){
    echo $item.'<br>';
}
?>
</body>

</html>