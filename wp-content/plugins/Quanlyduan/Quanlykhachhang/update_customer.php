<?php
// Kết nối CSDL
require_once 'ketnoi.php';

// Lấy dữ liệu từ form
$id = $_POST['id'];
$name = $_POST['name'];
$address = $_POST['address'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$description = $_POST['description'];
$customer_modified_by = $_POST['Customer_modified_by'];

// Cập nhật thông tin khách hàng vào CSDL
$update_customer_query = "UPDATE customer SET 
                        Customer_Name = '$name', 
                        Customer_Address = '$address', 
                        Customer_Email = '$email', 
                        Customer_Phone = '$phone', 
                        Customer_description = '$description', 
                        Modifiedby = '$customer_modified_by'
                        WHERE Id = '$id'";

if (mysqli_query($conn, $update_customer_query)) {
    // Xóa tất cả các dự án đã được chọn của khách hàng trong bảng liên kết customer_project
    $delete_customer_projects_query = "DELETE FROM customer_project WHERE MaKhachHang = '$id'";
    mysqli_query($conn, $delete_customer_projects_query);

    // Thêm lại các dự án đã được chọn vào bảng liên kết customer_project
    if (isset($_POST['customer_projects'])) {
        $customer_projects = $_POST['customer_projects'];
        foreach ($customer_projects as $project_id) {
            $insert_customer_project_query = "INSERT INTO customer_project (MaKhachHang, MaDuAn) VALUES ('$id', '$project_id')";
            mysqli_query($conn, $insert_customer_project_query);
        }
    }

    // Chuyển hướng người dùng sau khi cập nhật thành công
    echo '<script>alert("Cập nhật khách hàng thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
    exit();
} else {
    echo "Lỗi: " . mysqli_error($conn);
}
?>
