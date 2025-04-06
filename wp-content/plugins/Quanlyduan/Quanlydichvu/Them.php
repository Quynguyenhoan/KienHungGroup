<?php
// Kết nối đến cơ sở dữ liệu
require_once 'ketnoi.php';

// Nhận dữ liệu từ form
$service_title = $_POST['service_title'];
$service_description = $_POST['service_description'];
$service_image = $_POST['service_image'];
$service_created_by = $_POST['service_created_by'];

// Xử lý dữ liệu trước khi thêm vào cơ sở dữ liệu (ví dụ: kiểm tra tính hợp lệ)
$service = 'service';
// Chuẩn bị câu lệnh SQL để thêm dịch vụ mới
$sql = "INSERT INTO $service  (Title, service_Description, Image_URL, CreatedBy) 
        VALUES (?, ?, ?, ?)";

// Sử dụng câu lệnh truy vấn được tham số hóa để tránh tấn công SQL Injection
$stmt = mysqli_prepare($conn, $sql);

// Gán giá trị cho các tham số
mysqli_stmt_bind_param($stmt, 'ssss', $service_title, $service_description, $service_image, $service_created_by);

// Thực thi truy vấn và kiểm tra kết quả
if (mysqli_stmt_execute($stmt)) {
    // Nếu thành công, hiển thị thông báo và điều hướng về trang quản lý dịch vụ
    echo '<script>alert("Thêm dịch vụ thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
} else {
    // Nếu thất bại, hiển thị thông báo lỗi
    echo '<script>alert("Lỗi khi thêm dịch vụ: ' . mysqli_error($conn) . '"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
}

// Đóng câu lệnh và kết nối
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
