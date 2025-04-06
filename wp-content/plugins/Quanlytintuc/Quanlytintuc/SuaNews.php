<?php 
// Kết nối cơ sở dữ liệu
require_once 'ketnoi.php';

// Lấy dữ liệu từ form
$id = $_POST['id'];
$title = $_POST['title'];
$alias = $_POST['alias'];
$description = $_POST['description'];
$detail = $_POST['detail'];
$image = $_POST['edit-news-image'];
$category_id = $_POST['news_category_id'];
$is_active = isset($_POST['is_active']) ? 1 : 0; // Kiểm tra xem checkbox được chọn hay không
$modified_by = $_POST['modified_by'];

// Thực hiện câu lệnh SQL UPDATE
$suanews = "UPDATE news 
            SET Title = '$title', 
                Alias = '$alias', 
                News_Description = '$description', 
                Detail = '$detail', 
                News_image = '$image', 
                News_Category_id = '$category_id', 
                IsActive = '$is_active', 
                ModifiedBy = '$modified_by' 
            WHERE Id = $id";

// Thực thi câu lệnh UPDATE
if (mysqli_query($conn, $suanews)) {
    // Nếu UPDATE thành công, hiển thị thông báo và điều hướng về trang quản lý tin tức
    echo '<script>alert("Cập nhật tin tức thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=news-management";</script>';
} else {
    // Nếu UPDATE thất bại, hiển thị thông báo lỗi
    echo '<script>alert("Lỗi: ' . mysqli_error($conn) . '");</script>';
}

// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>