<?php
require_once 'ketnoi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $customerId = $_POST['customer_id'];
    
    // Chuyển đổi giá trị trạng thái thành giá trị cần lưu trữ trong cơ sở dữ liệu
    $statusValue = (int)$status;

    // Kiểm tra nếu giá trị hợp lệ
    if ($statusValue >= 1 && $statusValue <= 4) {
        // Cập nhật cơ sở dữ liệu
        $query = "UPDATE customer SET IsFromContact = ? WHERE Id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $statusValue, $customerId);
        
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
        
        $stmt->close();
    } else {
        echo 'invalid value';
    }
}
?>
