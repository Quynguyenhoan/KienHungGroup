
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
      <style>
/* Tăng kích thước chi tiết */
#service_description_ifr {
    height: 500px !important; /* Điều chỉnh chiều cao của trình soạn thảo */
}

      </style>
</head>
<body>
<?php 

global $wpdb;
$service_table = 'service';
$service_data = $wpdb->get_results(
 "SELECT n.*
FROM $service_table AS n;
" );
if ($wpdb->last_error) {
 echo "Lỗi: " . $wpdb->last_error;
};

?>
<h2>Bảng dịch vụ</h2>
<div class="wrap">
    <button id="add-service-btn" for="control-modal" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#servicedv">Thêm dịch vụ</button>
      <!-- Thêm nút "Xóa hàng loạt" -->
<button id="delete-selected-service-btn" class="delete-service-btn btn btn-danger">Xóa hàng loạt</button>
    <table class="wp-list-table widefat fixed striped" id="service">
        <thead>
            <tr>
            <th><input type="checkbox" id="select-serviece-checkbox"></th>
                <th>Hình ảnh</th>
                <th>Tiêu đề</th>
                <th>Người tạo</th>
                <th>Thời gian tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($service_data as $service): ?>
                <tr>
                <td><input type="checkbox" class="delete-svc-checkbox"></td>
                    <td><img src="<?= $service->Image_URL ?>" alt="Hình ảnh" style="width: 50px;"></td>
                    <td><?= $service->Title ?></td>
                    <td><?= $service->CreatedBy ?></td>
                    <td><?= $service->CreatedDate ?></td>
                    <td>
                    <a href="<?php echo plugin_dir_url(__FILE__) . 'editservice.php?sid=' . $service->Id ?>" class="btn btn-primary edit-service-btn">
    Sửa
</a>
                        <a onclick="return confirm('Bạn có muốn xóa không !')" href="<?php echo plugin_dir_url(__FILE__) . 'Xoa.php?sid=' . $service->Id; ?>" class="delete-service-btn btn btn-dark" data-id="<?= $service->Id ?>">Xóa</a>                    </td>
     
                    <!-- ################################################################## -->
                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ############################################################################ -->

<div class="modal" id="servicedv">
   <div class="modal-dialog modal-xl">
   <div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
    <h4 class="modal-title">Thêm mới dịch vụ</h4>
    <button
     type="button"
     class="btn-close"
     data-bs-dismiss="modal"
    ></button>
    </div>
  
    <div class="modal-body">
    <form method="POST" action="<?php echo plugin_dir_url(__FILE__) . 'Them.php'; ?>">
    <div class="mb-3 mt-3">
        <label for="service-title">Tiêu đề:</label>
        <input type="text" id="service-title" name="service_title" class="form-control" /><br />
    </div>

    <div class="mb-3 mt-3">
        <label for="service_description">Mô tả:</label>
        <?php
        // Lấy nội dung hiện tại của trình soạn thảo
        $content = ''; // Khởi tạo nội dung trống
        if (isset($_POST['service_description'])) {
            $content = wp_unslash($_POST['service_description']); // Lấy nội dung đã nhập từ biểu mẫu
        }

        // Tạo trình soạn thảo văn bản
        wp_editor($content, 'service_description', array(
            'textarea_name' => 'service_description', // Tên của trường văn bản
            'textarea_rows' => 150, // Số hàng của trình soạn thảo
            'teeny' => false, // Sử dụng chế độ Teeny (true/false)
            'media_buttons' => true, // Hiển thị nút phương tiện (true/false)
            'tinymce' => true, // Sử dụng TinyMCE (true/false)
        ));
        ?>
    </div>

    <div class="mb-3 mt-3">
    <label for="service-image">Hình ảnh:</label>
    <input type="hidden" id="service-image-url" name="service_image" />
    <button id="upload-imagesvc-button" class="button">Chọn hình ảnh</button>
    <img id="selected-image" src="" style="display: none; width: 50px; height: 50px;" />
</div>

    <div class="mb-3 mt-3">
        <label for="service-created-by">Được tạo bởi:</label>
        <input type="text" id="service-created-by" name="service_created_by" class="form-control" /><br />
    </div>

    <input type="submit" value="Thêm dịch vụ mới" class="btn btn-success" />
</form>
<!-- ############################################################################## -->
<script>
    jQuery(document).ready(function ($) {
        // Xử lý sự kiện khi nhấp vào nút "Upload Image"
        $('#upload-imagesvc-button').click(function () {
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
    $('#upload-imagesvc-button').click(function(e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Chọn hình ảnh',
            multiple: false
        }).open().on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#selected-image').attr('src', image_url).show();
            $('#service-image-url').val(image_url);
        });
    });
});
new DataTable('#service', {
    paging: false,
    scrollCollapse: true,
    scrollY: '300px'
});
    // Chọn tất cả 
$(document).ready(function() {
    // Sự kiện khi checkbox "Chọn tất cả" được thay đổi trạng thái
    $('#select-serviece-checkbox').change(function() {
        // Nếu checkbox "Chọn tất cả" được chọn
        if ($(this).prop('checked')) {
            // Chọn tất cả các checkbox hàng
            $('.delete-svc-checkbox').prop('checked', true);
        } else {
            // Bỏ chọn tất cả các checkbox hàng
            $('.delete-svc-checkbox').prop('checked', false);
        }
    });

    // Sự kiện khi các checkbox hàng được thay đổi trạng thái
    $('.delete-svc-checkbox').change(function() {
        // Nếu có ít nhất một checkbox hàng không được chọn
        if ($('.delete-svc-checkbox:not(:checked)').length > 0) {
            // Bỏ chọn checkbox "Chọn tất cả"
            $('#select-serviece-checkbox').prop('checked', false);
        } else {
            // Nếu tất cả các checkbox hàng được chọn
            // Chọn cả checkbox "Chọn tất cả"
            $('#select-serviece-checkbox').prop('checked', true);
        }
    });
});

//  xóa hàng loạt
jQuery(document).ready(function ($) {
    $('#delete-selected-service-btn').click(function () {
    var selectedIds = []; // Mảng chứa ID của các danh mục được chọn
    $('.delete-svc-checkbox:checked').each(function () {
        selectedIds.push($(this).closest('tr').find('.delete-service-btn').data('id')); // Thêm ID vào mảng
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
<!-- ######################################################################### -->
</div> 
  
  <div class="modal-footer">
  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
   X
  </button>
  </div>
 </div>
 </div>
</div>

</div>
</body>
</html>