<?php
// Kiểm tra xem có dữ liệu POST gửi lên từ trang danh sách dự án không
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ids"]) && !empty($_POST["ids"])) {
    // Include file kết nối database
    require_once 'ketnoi.php';

    // Lấy danh sách các ID từ dữ liệu POST
    $ids = $_POST["ids"];

    // Chuyển danh sách ID thành chuỗi phân cách bằng dấu phẩy để sử dụng trong truy vấn SQL
    $id_list = implode(",", $ids);

    // Truy vấn SQL để xóa các dòng có ID nằm trong danh sách đã chọn
    $delete_query = "DELETE FROM project WHERE Id IN ($id_list)";

    // Thực thi truy vấn xóa
    if (mysqli_query($conn, $delete_query)) {
        // Nếu xóa thành công, trả về thông báo thành công
        echo "Xóa thành công " . count($ids) . " dự án.";
    } else {
        // Nếu có lỗi xảy ra trong quá trình xóa, trả về thông báo lỗi
        echo "Lỗi: " . mysqli_error($conn);
    }

    // Đóng kết nối database
    mysqli_close($conn);
} else {
    // Nếu không có dữ liệu POST hoặc danh sách ID trống, trả về thông báo lỗi
    echo "Chờ trong giây lát.";
}
?>
