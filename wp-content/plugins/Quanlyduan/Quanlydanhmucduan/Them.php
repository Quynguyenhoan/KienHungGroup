<?php
// Nhận dữ liệu từ form
$Title = $_POST['cateproject_title'];
$Alias = $_POST['cateproject_alias'];
$Description = $_POST['cateproject-des'];
$Created_by = $_POST['projectcate_created_by'];
$parent_category_id = $_POST['parent_category_id'];
$icon = $_POST['projectcate_icon'];
if (empty($parent_category_id)) {
    $parent_category_id = NULL;
}

// Kết nối cơ sở dữ liệu
require_once 'ketnoi.php';
$category_table = 'project_category';

// Sử dụng chuẩn bị câu lệnh với tham số hóa
$themcate = "INSERT INTO $category_table (Title, Alias, Cate_Project_Description, Icon, CreatedBy, parent_category_id) 
    VALUES (?, ?, ?, ?, ?, ?)";

// Chuẩn bị câu lệnh SQL
$stmt = mysqli_prepare($conn, $themcate);

// Gán giá trị cho các tham số
mysqli_stmt_bind_param($stmt, 'sssssi', $Title, $Alias, $Description, $icon, $Created_by, $parent_category_id);

// Thực hiện truy vấn và kiểm tra kết quả
if (mysqli_stmt_execute($stmt)) {
    // Truy vấn thành công, hiển thị thông báo và điều hướng trở lại trang quản lý tin tức
    echo '<script>alert("Thêm danh mục dự án thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
} else {
    // Truy vấn thất bại, hiển thị thông báo lỗi
    $error = mysqli_error($conn);
    echo '<script>alert("Lỗi: ' . $error . '");</script>';
}

// Đóng câu lệnh và kết nối
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>