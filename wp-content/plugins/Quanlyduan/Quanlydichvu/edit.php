<?php
// Kiểm tra xem có dữ liệu gửi từ form không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem có dữ liệu id và dữ liệu là số không
    if (isset($_POST['edit_service_id']) && is_numeric($_POST['edit_service_id'])) {
        // Lấy dữ liệu từ form
        $edit_service_id = $_POST['edit_service_id'];
        $edit_service_title = $_POST['edit_service_title'];
        $edit_service_description = $_POST['edit_service_description'];
        $edit_service_image = $_POST['edit-service-image'];
        $edit_service_created_by = $_POST['edit_service_created_by'];

        // Xử lý lưu dữ liệu vào cơ sở dữ liệu
        require_once 'ketnoi.php'; // Kết nối đến cơ sở dữ liệu
        $query = "UPDATE service SET Title = ?, service_Description = ?, Image_URL = ?, ModifiedBy = ? WHERE Id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssssi', $edit_service_title, $edit_service_description, $edit_service_image, $edit_service_created_by, $edit_service_id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo '<script>alert("Sửa dịch vụ thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
        } else {
            echo "Có lỗi xảy ra trong quá trình cập nhật dữ liệu!";
        }

        // Đóng câu lệnh và kết nối
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo "Dữ liệu không hợp lệ!";
    }
}
?>
