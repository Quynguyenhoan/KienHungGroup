<?php
// Nhận dữ liệu từ form
$baohanh_title = $_POST['baohanh_title'];
$baohanh_mota = $_POST['baohanh_mota'];
$baohanh_category_id = $_POST['baohanh_category_id'];
$baohanh_created_by = $_POST['baohanh_created_by'];
$baohanh_thoigianbaohanh = $_POST['baohanh_time_baohanh'];
// Kết nối cơ sở dữ liệu
require_once 'ketnoi.php';

$baohanh_table = 'baohanh';

// Sử dụng câu lệnh truy vấn được tham số hóa
$thembaohanh = "INSERT INTO $baohanh_table (Title, ThoiGianBaoHanh, MoTa, ProjectId, CreatedBy, CreatedDate) 
    VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($thembaohanh);
$stmt->bind_param("sssss", $baohanh_title, $baohanh_thoigianbaohanh, $baohanh_mota, $baohanh_category_id, $baohanh_created_by);

// Thực thi truy vấn và kiểm tra kết quả
if ($stmt->execute()) {
    // Truy vấn thành công, hiển thị thông báo và điều hướng trở lại trang đã thêm
    echo '<script>alert("Thêm bảo hành thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
} else {
    // Truy vấn thất bại, hiển thị thông báo lỗi và giữ người dùng ở trang hiện tại
    $error = $conn->error;
    echo '<script>alert("Lỗi: ' . $error . '");</script>';
}
?>
