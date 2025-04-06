<?php
// Lấy dữ liệu từ form
$name = $_POST["Name_customer"];
$address = $_POST["Customer_address"];
$email = $_POST["Customer_Email"];
$phone = $_POST["Customer_Phone"];
$description = $_POST["Customer_description"];
$createdBy = $_POST["Customer_created_by"];

// Xử lý giá trị của checkbox IsRead
$is_read = isset($_POST['add_Customer_is_read']) ? 1 : 0;

// Xử lý giá trị của checkbox IsFromContact
$is_from_contact = isset($_POST['add_Customer_is_from_contact']) ? 1 : 0;

// Xử lý dự án được chọn
$customerProjects = isset($_POST["customer_projects"]) ? $_POST["customer_projects"] : array();

// Thêm khách hàng vào cơ sở dữ liệu
global $conn; // Sử dụng biến kết nối từ file ketnoi.php
require_once 'ketnoi.php';
$customer_table = 'customer';

// Sử dụng câu lệnh truy vấn được tham số hóa
$sql = "INSERT INTO $customer_table (Customer_Name, Customer_Address, Customer_Email, Customer_Phone, Customer_description, Customer_IsRead, IsFromContact, CreatedBy, CreatedDate) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

// Sử dụng prepare statement để thực thi truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssiis", $name, $address, $email, $phone, $description, $is_read, $is_from_contact, $createdBy);

// Thực thi truy vấn và kiểm tra kết quả
if ($stmt->execute()) {
    $customer_id = $conn->insert_id;
    foreach ($customerProjects as $project_id) {
        // Thêm dự án được chọn vào bảng liên kết customer_project
        $conn->query("INSERT INTO customer_project (MaKhachHang, MaDuAn) VALUES ('$customer_id', '$project_id')");
    }
    echo '<script>alert("Thêm thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
} else {
    echo "Lỗi: " . $conn->error;
}

?>
