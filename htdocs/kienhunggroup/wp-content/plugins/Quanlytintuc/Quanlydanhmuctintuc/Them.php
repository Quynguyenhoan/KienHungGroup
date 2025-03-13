<?php
// Nhận dữ liệu từ form
$Title = $_POST['catenews_title'];
$Alias = $_POST['catenews_alias'];
$Description = $_POST['catenews-des'];
$Created_by = $_POST['newscate_created_by'];
$Icon = $_POST['newscate_icon'];
$parent_category_id = $_POST['parent_category_id'];

// Kiểm tra xem parent_category_id có giá trị hay không
if (empty($parent_category_id)) {
    $parent_category_id = null; // Nếu không có giá trị, gán giá trị null
}

// Kết nối cơ sở dữ liệu
require_once 'ketnoi.php';
$category_table = 'news_category';

// Sử dụng chuẩn bị câu lệnh với tham số hóa
$themcate = "INSERT INTO $category_table (category_title, Alias, News_Category_Description, Icon, CreatedBy, parent_category_id) 
             VALUES (?, ?, ?, ?, ?, ?)";

// Chuẩn bị câu lệnh SQL
$stmt = mysqli_prepare($conn, $themcate);

// Gán giá trị cho các tham số
mysqli_stmt_bind_param($stmt, 'sssssi', $Title, $Alias, $Description, $Icon, $Created_by, $parent_category_id);

// Thực hiện truy vấn và kiểm tra kết quả
if (mysqli_stmt_execute($stmt)) {
    // Truy vấn thành công, hiển thị thông báo và điều hướng trở lại trang quản lý tin tức
    echo '<script>alert("Thêm danh mục tin tức thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=news-management";</script>';
} else {
    // Truy vấn thất bại, hiển thị thông báo lỗi
    $error = mysqli_error($conn);
    echo '<script>alert("Lỗi: ' . $error . '");</script>';
}

// Đóng câu lệnh và kết nối
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
