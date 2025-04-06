<?php 
// Kiểm tra xem có tham số sid được truyền vào không
if (isset($_GET['sid'])) {
    // Lấy giá trị của sid từ tham số truyền vào
    $sid = $_GET['sid'];

    // Kết nối đến cơ sở dữ liệu
    require_once 'ketnoi.php';

    // Chuẩn bị câu lệnh SQL để xóa dịch vụ có id tương ứng
    $sql = "DELETE FROM service WHERE Id = ?";

    // Sử dụng câu lệnh truy vấn được tham số hóa để tránh tấn công SQL Injection
    $stmt = mysqli_prepare($conn, $sql);

    // Gán giá trị cho tham số
    mysqli_stmt_bind_param($stmt, 'i', $sid);

    // Thực thi truy vấn và kiểm tra kết quả
    if (mysqli_stmt_execute($stmt)) {
        // Nếu thành công, hiển thị thông báo và điều hướng về trang quản lý dịch vụ
        echo '<script>alert("Xóa dịch vụ thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
    } else {
        // Nếu thất bại, hiển thị thông báo lỗi
        echo '<script>alert("Lỗi khi xóa dịch vụ: ' . mysqli_error($conn) . '"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
    }

    // Đóng câu lệnh và kết nối
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Nếu không có tham số sid, hiển thị thông báo lỗi
    echo "Không tìm thấy dịch vụ để xóa!";
}
?>
