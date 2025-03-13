<?php 
// Kiểm tra xem có dữ liệu được gửi từ form hay không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $alias = $_POST['alias'];
    $description = $_POST['description'];
    $modified_by = $_POST['modified_by'];
    $parent_category_id = $_POST['edit_parent_category_id'];
    $icon = $_POST['edit-projectcate-icon'];
    // Thực hiện kết nối đến cơ sở dữ liệu
    require_once 'ketnoi.php';

    // Câu lệnh SQL để cập nhật dữ liệu
    $edit_query = "UPDATE project_category SET 
    Title = '$title', 
    Alias = '$alias', 
    Cate_Project_Description = '$description', 
    Icon = '$icon',
    ModifiedBy = '$modified_by', 
    ModifiedDate = NOW()";

    // Nếu $parent_category_id không rỗng, thêm nó vào câu lệnh SQL
    if (empty($parent_category_id)) {
        $edit_query .= ", parent_category_id = NULL";
    } else {
        $edit_query .= ", parent_category_id = '$parent_category_id'";
    }

    $edit_query .= " WHERE Id = '$id'";

    // Thực thi câu lệnh SQL
    if (mysqli_query($conn, $edit_query)) {
        // Nếu cập nhật thành công, hiển thị thông báo và chuyển hướng người dùng trở lại trang quản lý tin tức
        echo '<script>alert("Sửa danh mục dự án thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
    } else {
        // Nếu có lỗi xảy ra, hiển thị thông báo lỗi
        $error = mysqli_error($conn);
        echo '<script>alert("Lỗi: ' . $error . '");</script>';
    }
}
?>