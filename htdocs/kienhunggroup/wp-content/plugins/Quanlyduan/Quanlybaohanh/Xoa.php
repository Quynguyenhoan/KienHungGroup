<?php 
// Kiểm tra xem có tham số sid được truyền vào không
if (isset($_GET['sid'])) {
    // Lấy giá trị của sid từ tham số truyền vào
    $sid = $_GET['sid'];

    // Thực hiện quá trình xóa dữ liệu có sid tương ứng ở đây
    require_once  'ketnoi.php';
    $baohanh_cate = 'baohanh';
    $xoabaohanh = "DELETE FROM $baohanh_cate WHERE id=$sid ";

    if (mysqli_query($conn, $xoabaohanh)) {
        echo '<script>alert("Xóa thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
    } else {
        $error = mysqli_error($conn);
        echo '<script>alert("Lỗi: ' . $error . '");</script>';
    }
} else {
    // Nếu không có tham số sid, hiển thị thông báo lỗi
    echo "Không tìm thấy sid để xóa!";
}
?>
