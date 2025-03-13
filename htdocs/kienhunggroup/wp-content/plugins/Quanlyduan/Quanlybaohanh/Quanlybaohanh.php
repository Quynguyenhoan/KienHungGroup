<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
      <!--  -->
      <!-- data table -->
      <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
      <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
      <!--  -->
</head>
<body>
<?php 

global $wpdb;
$baohanh_table = 'baohanh';
$baohanh_category_table = 'project';
$baohanh_data = $wpdb->get_results(
 "SELECT n.*
FROM $baohanh_table AS n;
" );
$categoy = $wpdb->get_results("SELECT * FROM $baohanh_category_table");
if ($wpdb->last_error) {
 echo "Lỗi: " . $wpdb->last_error;
};
?>

<h2>Bảng bảo hành</h2>
<div class="wrap">
    <button id="add-baohanh-btn" for="control-modal" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#baohanhmodal">Thêm bảo hành</button>
      <!-- Thêm nút "Xóa hàng loạt" -->
<button id="delete-selected-baohanh-btn" class="btn btn-danger">Xóa hàng loạt</button>
    <table class="wp-list-table widefat fixed striped" id="baohanh_table">
        <thead>
            <tr>
            <th><input type="checkbox" id="select-all-baohanh-checkbox"></th>
                <th>Tiêu đề</th>
                <th>Dự án bảo hành</th>
                <th>Người tạo</th>
                <th>Thời gian tạo</th>
                <th>Thời gian bảo hành</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($baohanh_data as $baohanh): ?>
                <tr>
                <td><input type="checkbox" class="delete-checkbox-baohanh"></td>
                    <td><?= $baohanh->Title ?></td>
                    <td>
                    <?php
$category_title = '';
foreach ($categoy as $cate) {
    if ($cate->Id == $baohanh->ProjectId) {
        $category_title = $cate->TenDuAn;
        break;
    }
}
echo $category_title;
?>

</td>
                    <td><?= $baohanh->CreatedBy ?></td>
                    <td><?= $baohanh->CreatedDate ?></td>
                    <td>
    <?php
    // Tính toán số ngày còn lại của dự án bảo hành
    $createdDate = strtotime($baohanh->CreatedDate); // Chuyển đổi thời gian tạo thành số giây
    $warrantyPeriod = $baohanh->ThoiGianBaoHanh; // Thời gian bảo hành của dự án
    $currentDate = time(); // Lấy thời gian hiện tại
    $endDate = strtotime("+$warrantyPeriod months", $createdDate); // Tính toán ngày kết thúc bảo hành
    $remainingDays = ceil(($endDate - $currentDate) / (60 * 60 * 24)); // Tính toán số ngày còn lại và làm tròn lên
    echo $remainingDays . ' ngày';
    ?>
</td>

                    <td>
                    <a href="<?php echo plugin_dir_url(__FILE__) . 'editvalue.php?sid=' . $baohanh->Id ?>" class="btn btn-primary edit-baohanh-btn">
    Sửa
</a>

                        <a onclick="return confirm('Bạn có muốn xóa không !')" href="<?php echo plugin_dir_url(__FILE__) . 'Xoa.php?sid=' . $baohanh->Id; ?>" class="delete-baohanh-btn btn btn-dark" data-id="<?= $baohanh->Id ?>">Xóa</a>
                    </td>


                    <!-- ################################################################## -->


                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="modal" id="baohanhmodal">
   <div class="modal-dialog modal-xl">
   <div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
    <h4 class="modal-title">Thêm mới bảo hành</h4>
    <button
     type="button"
     class="btn-close"
     data-bs-dismiss="modal"
    ></button>
    </div>
  
    <div class="modal-body">
    <form method="POST" action="<?php echo plugin_dir_url(__FILE__) . 'Them.php'; ?>">
    <div class="mb-3 mt-3">
        <label for="baohanh-title">Tiêu đề:</label>
        <input type="text" id="baohanh-title" name="baohanh_title" class="form-control" /><br />
    </div>

    <div class="mb-3 mt-3">
        <label for="baohanh-mota">Mô tả:</label>
        <?php
        // Lấy nội dung hiện tại của trình soạn thảo
        $content = ''; // Khởi tạo nội dung trống
        if (isset($_POST['baohanh_mota'])) {
            $content = wp_unslash($_POST['baohanh_mota']); // Lấy nội dung đã nhập từ biểu mẫu
        }

        // Tạo trình soạn thảo văn bản
        wp_editor($content, 'baohanh-mota', array(
            'textarea_name' => 'baohanh_mota', // Tên của trường văn bản
            'textarea_rows' => 150, // Số hàng của trình soạn thảo
            'teeny' => false, // Sử dụng chế độ Teeny (true/false)
            'media_buttons' => true, // Hiển thị nút phương tiện (true/false)
            'tinymce' => true, // Sử dụng TinyMCE (true/false)
        ));
        ?>
    </div>

    <label for="baohanh-category">Dự án hỗ trợ:</label>
    <select id="baohanh-category" name="baohanh_category_id">
        <?php
            // Duyệt qua $categoy và hiển thị các danh mục
            foreach ($categoy as $cate) {
                // Hiển thị thẻ <option> cho mỗi danh mục
                echo '<option value="' . $cate->Id . '">' . $cate->TenDuAn . '</option>';
            }
        ?>
    </select>

    <div class="mb-3 mt-3">
        <label for="baohanh-created-by">Thời gian bảo hành:</label>
        <input type="number" id="baohanh-time-baohanh" name="baohanh_time_baohanh" class="form-control" value="24"/><br />
    </div>

    <div class="mb-3 mt-3">
        <label for="baohanh-created-by">Được tạo bởi:</label>
        <input type="text" id="baohanh-created-by" name="baohanh_created_by" class="form-control" /><br />
    </div>

    <input type="submit" value="Thêm bảo hành mới" class="btn btn-success" />
</form>
<script>

$('#baohanh_table').dataTable({
            paging: false,
            scrollCollapse: true,
            scrollY: '300px'
        });

       // Chọn tất cả
       $(document).ready(function () {
            $('#select-all-baohanh-checkbox').change(function () {
                if ($(this).prop('checked')) {
                    $('.delete-checkbox-baohanh').prop('checked', true);
                } else {
                    $('.delete-checkbox-baohanh').prop('checked', false);
                }
            });

            $('.delete-checkbox-baohanh').change(function () {
                if ($('.delete-checkbox-baohanh:not(:checked)').length > 0) {
                    $('#select-all-baohanh-checkbox').prop('checked', false);
                } else {
                    $('#select-all-baohanh-checkbox').prop('checked', true);
                }
            });
        });

        // Xóa hàng loạt
        jQuery(document).ready(function ($) {
            $('#delete-selected-baohanh-btn').click(function () {
                var selectedIds = [];
                $('.delete-checkbox-baohanh:checked').each(function () {
                    selectedIds.push($(this).closest('tr').find('.delete-baohanh-btn').data('id'));
                });
                $.ajax({
                    url: '<?= plugin_dir_url(__FILE__) . "xoahangloat.php"; ?>',
                    type: 'POST',
                    data: { ids: selectedIds },
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        alert('Lỗi xóa hàng loạt: ' + error);
                    }
                });
            });
        });
</script>
</body>
</html>