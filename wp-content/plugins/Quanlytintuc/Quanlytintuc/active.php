<?php
// Kết nối cơ sở dữ liệu
require_once 'ketnoi.php';

// Kiểm tra xem có dữ liệu được gửi từ form không
if(isset($_GET['news_id'])) {
    // Lấy giá trị của news_id từ URL
    $news_id = $_GET['news_id'];

    // Truy vấn để lấy giá trị hiện tại của IsActive
    $query = "SELECT IsActive FROM news WHERE Id = '$news_id'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_status = $row['IsActive'];

        // Đảo ngược giá trị của IsActive
        $new_status = ($current_status == 0) ? 1 : 0;

        // Cập nhật giá trị mới của IsActive vào cơ sở dữ liệu
        $update_query = "UPDATE news SET IsActive = '$new_status' WHERE Id = '$news_id'";
        $update_result = mysqli_query($conn, $update_query);

        if($update_result) {
            // Cập nhật thành công, điều hướng trở lại trang quản lý tin tức
            header("Location: http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=news-management");
            exit();
        } else {
            // Cập nhật thất bại, hiển thị thông báo lỗi
            echo '<script>alert("Lỗi khi cập nhật trạng thái!"); window.history.back();</script>';
        }
    } else {
        // Không tìm thấy tin tức, hiển thị thông báo lỗi
        echo '<script>alert("Không tìm thấy tin tức!"); window.history.back();</script>';
    }
} else {
    // Không có dữ liệu được gửi từ form, hiển thị thông báo lỗi
    echo '<script>alert("Dữ liệu không hợp lệ!"); window.history.back();</script>';
}
?>
