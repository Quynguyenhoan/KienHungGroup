<?php
// Nhận dữ liệu từ form
$project_title = $_POST['project_title'];
$project_alias = $_POST['project_alias'];
$project_diachi = $_POST['project_diachi'];
$project_datenews = $_POST['project_datenews'];
$project_dateend = $_POST['project_dateend'];
$project_description = $_POST['project_description']; // Sửa đổi tên trường này
$project_image_c = $_POST['project_image_c'];
$project_category_id = $_POST['project_category_id'];
$payment_status = $_POST['payment_status'];
$total_amount = $_POST['total_amount'];
$project_created_by = $_POST['project_created_by'];
$IS_HOT = isset($_POST['IS_HOT']) ? 1 : 0;
// Kết nối cơ sở dữ liệu
require_once 'ketnoi.php';
$project_table = 'project';
// Sử dụng câu lệnh truy vấn được tham số hóa
$themproject = "INSERT INTO $project_table (TenDuAn, Alias, DiaChi, NgayBatDau, NgayKetThuc, IS_Hot, Project_Description, project_image_c, ProjectCategory_id, PaymentStatus, TotalAmount, CreatedBy, CreatedDate, ModifiedDate) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

$stmt = $conn->prepare($themproject);
$stmt->bind_param("ssssssssssss", $project_title, $project_alias, $project_diachi, $project_datenews, $project_dateend, $IS_HOT, $project_description, $project_image_c, $project_category_id, $payment_status, $total_amount, $project_created_by);

// Thực thi truy vấn và kiểm tra kết quả
if ($stmt->execute()) {
    // Truy vấn thành công, hiển thị thông báo và điều hướng trở lại trang đã thêm
    echo '<script>alert("Thêm dự án thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
} else {
    // Truy vấn thất bại, hiển thị thông báo lỗi và giữ người dùng ở trang hiện tại
    $error = $conn->error;
    echo '<script>alert("Lỗi: ' . $error . '");</script>';
}

?>
