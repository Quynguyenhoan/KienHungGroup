<?php
// Kết nối đến cơ sở dữ liệu
require_once 'ketnoi.php';

// Kiểm tra xem dữ liệu POST đã được gửi đi chưa và các trường cần thiết có tồn tại không
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['projectId']) && isset($_POST['edit-project-image'])) {
    // Sử dụng hàm mysqli_real_escape_string để tránh lỗi SQL injection
    $projectId = mysqli_real_escape_string($conn, $_POST['projectId']);
    $project_image_n_list = mysqli_real_escape_string($conn, $_POST['edit-project-image']);

    // Chia các URL ảnh thành một mảng
    $imageUrls = explode(',', $project_image_n_list);

    // Xóa các hình ảnh đã thêm trước đó cùng Project_id
    $deleteQuery = "DELETE FROM project_image WHERE Project_id = '$projectId'";
    mysqli_query($conn, $deleteQuery);

    // Thêm từng URL ảnh vào cơ sở dữ liệu
    foreach ($imageUrls as $imageUrl) {
        $insertQuery = "INSERT INTO project_image (Project_id, Project_Image_n) VALUES ('$projectId', '$imageUrl')";
        mysqli_query($conn, $insertQuery);
    }

    // Kiểm tra xem truy vấn INSERT có thực hiện thành công hay không
    if (mysqli_affected_rows($conn) > 0) {
        echo '<script>alert("Thêm hình ảnh thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
    } else {
        echo "Lỗi khi thêm hình ảnh: " . mysqli_error($conn);
    }

    // Đóng kết nối
    mysqli_close($conn);
} else {
    echo "Dữ liệu không hợp lệ.";
}

?>
