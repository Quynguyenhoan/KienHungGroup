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
</head>
<body>
<?php 
    global $wpdb;
    // Fetch project category data
    $category_table = 'project_category';
    $category_project = $wpdb->get_results("SELECT * FROM $category_table");
    if ($wpdb->last_error) {
        echo "Lỗi: " . $wpdb->last_error;
        return;
    }
?>
<!-- ######################################################################################################################################## -->
<h2>Danh mục dự án</h2>
<div class="wrap">
    <button class="btn btn-primary" id="add-cateproject-btn" class="button button-primary" data-bs-toggle="modal" data-bs-target="#catepro">Thêm danh mục dự án</button>
    <!-- Thêm nút "Xóa hàng loạt" -->
<button id="delete-selected-cateproject-btn" class="btn btn-danger">Xóa hàng loạt</button>

    <table id="cateproject" class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
            <th><input type="checkbox" id="select-all-checkbox"></th>
            <th>Icon</th>
                <th>Tiêu đề</th>
                <th>Alias</th>
                <th>Mô tả</th>
                <th>Danh mục cha</th>
                <th>Người tạo</th>
                <th>Ngày tạo ra</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($category_project as $category): ?>
                <tr>
                <td><input type="checkbox" class="delete-checkbox" data-id="<?= $category->Id ?>"></td>
                <td><img src="<?= $category->Icon ?>" alt="Icon" style="width: 50px;"></td>
                    <td><?php echo $category->Title; ?></td>
                    <td><?php echo $category->Alias; ?></td>
                    <td><?php echo $category->Cate_Project_Description; ?></td>
                    <td>
    <?php
    $parent_category_title = ''; // Khởi tạo biến để lưu tên danh mục cha
    foreach ($category_project as $cate) {
        if ($category->parent_category_id == $cate->Id) {
            $parent_category_title = $cate->Title; // Lưu tên danh mục cha nếu ID khớp
            break; // Thoát khỏi vòng lặp sau khi tìm thấy tên danh mục cha
        }
    }
    echo $parent_category_title; // Hiển thị tên danh mục cha
    ?>
</td>

                    <td><?php echo $category->CreatedBy; ?></td>
                    <td><?php echo $category->CreatedDate; ?></td>
                    <td>
                        <a href="<?php echo plugin_dir_url(__FILE__) . 'editvalue.php?sid=' . $category->Id ?>" class="btn btn-primary edit-project-btn">  Sửa</a>
                        <a onclick="return confirm('Bạn có muốn xóa không !')" href="<?php echo plugin_dir_url(__FILE__) . 'Xoa.php?sid=' . $category->Id; ?>" class="delete-project-btn btn btn-dark" data-id="<?= $category->Id ?>">Xóa</a>                    
                    </td>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<!-- ########################################################################################### -->
<div class="modal" id="catepro">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Thêm danh mục dự án</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <!-- ############################################################################### -->
        <form method="POST" action="<?php echo plugin_dir_url(__FILE__) . 'Them.php'; ?>">
    <div class="mb-3 mt-3">
        <label for="cateproject-title">Tiêu đề:</label>
        <input type="text" id="cateproject-title" name="cateproject_title" class="form-control" /><br />
    </div>

    <div class="mb-3 mt-3">
        <label for="project-alias">Alias:</label>
        <input type="text" id="cateproject-alias" name="cateproject_alias" class="form-control" /><br />
    </div>
    <div class="mb-3 mt-3">
    <label for="projectcate-icon">Icon:</label>
    <input type="hidden" id="projectcate-icon-url" name="projectcate_icon" />
    <button id="upload-icon-button" class="button">Chọn Icon</button>
    <img id="selected-icon" src="" style="display: none; width: 50px; height: 50px;" />
</div>

    <div class="mb-3 mt-3">
        <label for="cateproject-des">Mô tả:</label>
        <?php
        // Lấy nội dung hiện tại của trình soạn thảo
        $content = ''; // Khởi tạo nội dung trống
        if (isset($_POST['cateproject-des'])) {
            $content = wp_unslash($_POST['cateproject-des']); // Lấy nội dung đã nhập từ biểu mẫu
        }

        // Tạo trình soạn thảo văn bản
        wp_editor($content, 'cateproject-des', array(
            'textarea_name' => 'cateproject-des', // Tên của trường văn bản
            'textarea_rows' => 10, // Số hàng của trình soạn thảo
            'teeny' => false, // Sử dụng chế độ Teeny (true/false)
            'media_buttons' => true, // Hiển thị nút phương tiện (true/false)
            'tinymce' => true, // Sử dụng TinyMCE (true/false)
        ));
        ?>
    </div>

    <div class="mb-3 mt-3">
    <label for="parent_category_id">Danh mục cha:</label>
    <select name="parent_category_id" id="parent_category_id" class="form-control">
        <option value="">-- Không có danh mục cha --</option>
        <?php foreach ($category_project as $cate): ?>
            <option value="<?php echo $cate->Id; ?>"><?php echo $cate->Title; ?></option>
        <?php endforeach; ?>
    </select>
</div>

    <div class="mb-3 mt-3">
        <label for="projectcate-created-by">Được tạo bởi:</label>
        <input type="text" id="cate-created-by" name="projectcate_created_by" class="form-control" /><br />
    </div>

    <input type="submit" value="Thêm danh mục dự án" class="btn btn-success" />
</form>
        <!-- ############################################################################### -->
      </div>
      <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
     X
    </button>
    </div>
    </div>
  </div>
</div>
<!-- ########################################################################################## -->
    <script>

jQuery(document).ready(function ($) {
        // Xử lý sự kiện khi nhấp vào nút "Upload Image"
        $('#upload-icon-button').click(function () {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            wp.media.editor.send.attachment = function (props, attachment) {
                $(button).prev().val(attachment.url);
                wp.media.editor.send.attachment = send_attachment_bkp;
            };
            wp.media.editor.open(button);
            return false;
        });
    });
    jQuery(document).ready(function($){
    $('#upload-icon-button').click(function(e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Chọn hình ảnh',
            multiple: false
        }).open().on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#selected-icon').attr('src', image_url).show();
            $('#projectcate-icon-url').val(image_url);
        });
    });
});

new DataTable('#cateproject', {
    paging: false,
    scrollCollapse: true,
    scrollY: '300px'
});

// Chọn tất cả 
$(document).ready(function() {
    // Sự kiện khi checkbox "Chọn tất cả" được thay đổi trạng thái
    $('#select-all-checkbox').change(function() {
        // Nếu checkbox "Chọn tất cả" được chọn
        if ($(this).prop('checked')) {
            // Chọn tất cả các checkbox hàng
            $('.delete-checkbox').prop('checked', true);
        } else {
            // Bỏ chọn tất cả các checkbox hàng
            $('.delete-checkbox').prop('checked', false);
        }
    });

    // Sự kiện khi các checkbox hàng được thay đổi trạng thái
    $('.delete-checkbox').change(function() {
        // Nếu có ít nhất một checkbox hàng không được chọn
        if ($('.delete-checkbox:not(:checked)').length > 0) {
            // Bỏ chọn checkbox "Chọn tất cả"
            $('#select-all-checkbox').prop('checked', false);
        } else {
            // Nếu tất cả các checkbox hàng được chọn
            // Chọn cả checkbox "Chọn tất cả"
            $('#select-all-checkbox').prop('checked', true);
        }
    });
});

//  xóa hàng loạt
jQuery(document).ready(function ($) {
    $('#delete-selected-cateproject-btn').click(function () {
    var selectedIds = []; // Mảng chứa ID của các danh mục được chọn
    $('.delete-checkbox:checked').each(function () {
        selectedIds.push($(this).closest('tr').find('.delete-project-btn').data('id')); // Thêm ID vào mảng
    });
            // Gửi yêu cầu AJAX đến xoahangloat.php với danh sách các ID được chọn
            $.ajax({
                url: '<?php echo plugin_dir_url(__FILE__) . "xoahangloat.php"; ?>',
                type: 'POST',
                data: {ids: selectedIds},
                success: function (response) {
                    // Xử lý phản hồi từ xoahangloat.php (nếu cần)
                    alert(response);
                    // Tải lại trang sau khi xóa thành công
                    location.reload();
                },
                error: function (xhr, status, error) {
                    // Xử lý lỗi (nếu có)
                    alert('Lỗi xóa hàng loạt: ' + error);
                }
            });
        });
    });

</script>
</div>
</body>
</html>