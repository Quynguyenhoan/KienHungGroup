<?php 
// Kiểm tra xem có tham số sid được truyền vào không
if (isset($_GET['sid'])) {
    // Lấy giá trị của sid từ tham số truyền vào
    $sid = $_GET['sid'];

    // Thực hiện quá trình xóa dữ liệu có sid tương ứng ở đây
    require_once  'ketnoi.php';
    $news_cate = 'news_category';
    $xoanews = "DELETE FROM $news_cate WHERE id=$sid ";

    if (mysqli_query($conn, $xoanews)) {
        echo '<script>alert("Xóa thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=news-management";</script>';
    } else {
        $error = mysqli_error($conn);
        echo '<script>alert("Lỗi: ' . $error . '");</script>';
    }
} else {
    // Nếu không có tham số sid, hiển thị thông báo lỗi
    echo "Không tìm thấy sid để xóa!";
}
?>
