<?php
// Kết nối cơ sở dữ liệu
require_once 'ketnoi.php';

// Kiểm tra xem có dữ liệu được gửi từ form không
if(isset($_GET['project_id'])) {
    // Lấy giá trị của project_id từ URL
    $project_id = $_GET['project_id'];

    // Truy vấn để lấy giá trị hiện tại của IS_Hot
    $query = "SELECT IS_Hot FROM project WHERE Id = '$project_id'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $current_status = $row['IS_Hot'];

        // Đảo ngược giá trị của IS_Hot
        $project_status = ($current_status == 0) ? 1 : 0;

        // Cập nhật giá trị mới của IS_Hot vào cơ sở dữ liệu
        $update_query = "UPDATE project SET IS_Hot = '$project_status' WHERE Id = '$project_id'";
        $update_result = mysqli_query($conn, $update_query);

        if($update_result) {
            // Cập nhật thành công, điều hướng trở lại trang quản lý tin tức
            header("Location: http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management");
            exit();
        } else {
            // Cập nhật thất bại, hiển thị thông báo lỗi
            echo '<script>alert("Lỗi khi cập nhật trạng thái!"); window.history.back();</script>';
        }
    } else {
        // Không tìm thấy tin tức, hiển thị thông báo lỗi
        echo '<script>alert("Không tìm thấy dự án!"); window.history.back();</script>';
    }
} else {
    // Không có dữ liệu được gửi từ form, hiển thị thông báo lỗi
    echo '<script>alert("Dữ liệu không hợp lệ!"); window.history.back();</script>';
}
?>
