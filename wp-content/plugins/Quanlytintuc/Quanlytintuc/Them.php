<?php
// Nhận dữ liệu từ form
$Title = $_POST['news_title'];
$Alias = $_POST['news_alias'];
$Description = $_POST['news_description'];
$Detail = $_POST['news_detail'];
$Image = $_POST['news_image'];
$Category_id = $_POST['news_category_id'];
$Created_by = $_POST['news_created_by'];
$IsActive = isset($_POST['is_active']) ? 1 : 0; // Đặt IsActive thành 1 nếu được chọn, ngược lại đặt thành 0

// Kết nối cơ sở dữ liệu
require_once 'ketnoi.php';
$news_table = 'news';

// Sử dụng câu lệnh truy vấn được tham số hóa
$themnews = "INSERT INTO $news_table (Title, Alias, News_Description, Detail, News_image, News_Category_id, IsActive, CreatedBy) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// Sử dụng prepare statement để thực thi truy vấn --- KHAC BIET
$stmt = $conn->prepare($themnews);
$stmt->bind_param("sssssiss", $Title, $Alias, $Description, $Detail, $Image, $Category_id, $IsActive, $Created_by);

// Thực thi truy vấn và kiểm tra kết quả
if ($stmt->execute()) {
    // Truy vấn thành công, hiển thị thông báo và điều hướng trở lại trang đã thêm
    echo '<script>alert("Thêm thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=news-management";</script>';
} else {
    // Truy vấn thất bại, hiển thị thông báo lỗi và giữ người dùng ở trang hiện tại
    $error = $conn->error;
    echo '<script>alert("Lỗi: ' . $error . '");</script>';
}
?>
