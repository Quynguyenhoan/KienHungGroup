<?php
// Kiểm tra xem có dữ liệu được gửi từ form hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $alias = $_POST['alias'];
    $description = $_POST['description'];
    $Icon = $_POST['edit-newscate-icon'];
    $modified_by = $_POST['modified_by'];
    // Kiểm tra nếu giá trị của select là rỗng, tức là người dùng đã chọn "Không có danh mục cha"
    // Trong trường hợp này, ta gán giá trị NULL cho parent_category_id
    $parent_category_id = !empty($_POST['edit_parent_category_id']) ? $_POST['edit_parent_category_id'] : "NULL";
    // Thực hiện kết nối đến cơ sở dữ liệu
    require_once 'ketnoi.php';

    // Câu lệnh SQL để cập nhật dữ liệu
    $edit_query = "UPDATE news_category SET 
    category_title = '$title', 
    Alias = '$alias', 
    News_Category_Description = '$description',
    Icon = '$Icon',
    Modifiedby = '$modified_by', 
    ModifiedDate = NOW(),
    parent_category_id = $parent_category_id 
    WHERE Id = '$id'";

    // Thực thi câu lệnh SQL
    if (mysqli_query($conn, $edit_query)) {
        // Nếu cập nhật thành công, hiển thị thông báo và chuyển hướng người dùng trở lại trang quản lý tin tức
        echo '<script>alert("Sửa danh mục tin tức thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=news-management";</script>';
    } else {
        // Nếu có lỗi xảy ra, hiển thị thông báo lỗi
        $error = mysqli_error($conn);
        echo '<script>alert("Lỗi: ' . $error . '");</script>';
    }
}
?>
