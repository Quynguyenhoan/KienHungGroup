<?php
// Kết nối cơ sở dữ liệu
require_once 'ketnoi.php';

// Kiểm tra xem có dữ liệu được gửi từ form không
if(isset($_GET['Customer_id'])) {
    // Lấy giá trị của Customer_id từ URL
    $Customer_id = $_GET['Customer_id'];

    // Truy vấn để lấy giá trị hiện tại của Customer_IsRead
    $query = "SELECT Customer_IsRead FROM customer WHERE Id = $Customer_id";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_status = $row['Customer_IsRead'];

        // Đảo ngược giá trị của Customer_IsRead
        $customer_status = ($current_status == 0) ? 1 : 0;

        // Cập nhật giá trị mới của Customer_IsRead vào cơ sở dữ liệu
        $updatequery = "UPDATE customer SET Customer_IsRead = $customer_status WHERE Id = $Customer_id";
        $update_result = mysqli_query($conn, $updatequery);

        // Kiểm tra xem truy vấn đã thực hiện thành công hay không
        if ($update_result === false) {
            // Nếu có lỗi xảy ra, in ra thông báo lỗi và dừng chương trình
            echo "Lỗi MySQL: " . mysqli_error($conn);
            exit;
        }

        // Kiểm tra xem trạng thái đã được cập nhật thành công hay không
        if (mysqli_affected_rows($conn) > 0) {
            // Cập nhật thành công, điều hướng trở lại trang quản lý tin tức
            header("Location: http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management");
            exit();
        } else {
            // Cập nhật thất bại, hiển thị thông báo lỗi
            echo '<script>alert("Lỗi khi cập nhật trạng thái!"); window.history.back();</script>';
        }
    } else {
        // Không tìm thấy khách hàng, hiển thị thông báo lỗi
        echo '<script>alert("Không tìm thấy khách hàng!"); window.history.back();</script>';
    }
} else {
    // Không có dữ liệu được gửi từ form, hiển thị thông báo lỗi
    echo '<script>alert("Dữ liệu không hợp lệ!"); window.history.back();</script>';
}
?>