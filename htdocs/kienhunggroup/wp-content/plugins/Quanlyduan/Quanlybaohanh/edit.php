<?php 
// Include file kết nối database
require_once 'ketnoi.php';
            // Lấy dữ liệu từ biểu mẫu
            $baohanh_id = $_POST['baohanh_id'];
            $baohanh_edit_title = $_POST['baohanh_edit_title'];
            $baohanh_edit_timebaohanh = $_POST['baohanh_edit_timebaohanh'];
            $baohanh_edit_description = $_POST['baohanh_edit_description'];
            $baohanh_category_id = $_POST['baohanh_category_id'];
            $baohanh_edit_created_by = $_POST['baohanh_edit_created_by'];

            // Thực hiện truy vấn SQL để cập nhật dữ liệu dự án
            $baohanh_update_query = "UPDATE baohanh SET 
            Title = '$baohanh_edit_title', 
            ThoiGianBaoHanh = '$baohanh_edit_timebaohanh', 
            MoTa = '$baohanh_edit_description', 
            ProjectId = '$baohanh_category_id', 
            Modifiedby = '$baohanh_edit_created_by' 
            WHERE Id = '$baohanh_id'";

            // Thực thi truy vấn cập nhật
            if (mysqli_query($conn, $baohanh_update_query)) {
                echo '<script>alert("Cập nhật bảo hành thành công!"); window.location.href = "http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management";</script>';
            } else {
                echo '<script>alert("Lỗi: ' . mysqli_error($conn) . '");</script>';
            }
?>
