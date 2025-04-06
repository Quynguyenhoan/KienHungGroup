<?php 
// Kết nối cơ sở dữ liệu
require_once 'ketnoi.php';

// Lấy dữ liệu từ form và thoát ký tự đặc biệt
$project_id = mysqli_real_escape_string($conn, $_POST['project_id']);
$project_title = mysqli_real_escape_string($conn, $_POST['project_edit_title']);
$project_alias = mysqli_real_escape_string($conn, $_POST['project_edit_alias']);
$project_diachi = mysqli_real_escape_string($conn, $_POST['project_edit_diachi']);
$project_datenews = mysqli_real_escape_string($conn, $_POST['project_edit_dateproject']);
$project_dateend = mysqli_real_escape_string($conn, $_POST['project_edit_dateend']);
$project_description = mysqli_real_escape_string($conn, $_POST['project_edit_description']);
$project_image = mysqli_real_escape_string($conn, $_POST['project_edit_image']);
$project_category_id = mysqli_real_escape_string($conn, $_POST['project_category_id']);
$payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);
$total_amount = mysqli_real_escape_string($conn, $_POST['total_edit_amount']);
$project_created_by = mysqli_real_escape_string($conn, $_POST['project_edit_created_by']);

// Thực hiện câu lệnh SQL UPDATE
$sua_project = "UPDATE project 
            SET TenDuAn = '$project_title', 
                Alias = '$project_alias', 
                DiaChi = '$project_diachi', 
                NgayBatDau = '$project_datenews', 
                NgayKetThuc = '$project_dateend', 
                Project_Description = '$project_description', 
                project_image_c = '$project_image', 
                ProjectCategory_id = '$project_category_id', 
                PaymentStatus = '$payment_status', 
                TotalAmount = '$total_amount', 
                ModifiedBy = '$project_created_by' 
            WHERE Id = $project_id";

// Thực thi câu lệnh UPDATE
if (mysqli_query($conn, $sua_project)) {
    // Nếu UPDATE thành công, hiển thị thông báo và điều hướng về trang quản lý dự án
    echo '<script>alert("Cập nhật dự án thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
} else {
    // Nếu UPDATE thất bại, hiển thị thông báo lỗi
    echo '<script>alert("Lỗi: ' . mysqli_error($conn) . '");</script>';
}

// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>
