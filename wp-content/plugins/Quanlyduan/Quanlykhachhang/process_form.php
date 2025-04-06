<?php
require_once 'ketnoi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Kiểm tra giá trị và thiết lập các giá trị mặc định cho các trường cần thiết
    $address = null;
    $phone = null;
    $description = $message;
    $createdBy = null; // Hoặc lấy thông tin người dùng từ WordPress nếu có
    $createdDate = date('Y-m-d H:i:s');
    $modifiedDate = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO customer (Customer_Name, Customer_Address, Customer_Email, Customer_Phone, Customer_description, Customer_IsRead, IsFromContact, CreatedBy, CreatedDate, ModifiedDate) VALUES (?, ?, ?, ?, ?, 0, 1, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $address, $email, $phone, $description, $createdBy, $createdDate, $modifiedDate);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>
