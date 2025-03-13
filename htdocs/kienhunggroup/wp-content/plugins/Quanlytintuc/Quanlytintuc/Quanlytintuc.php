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
      <style>
/* Tăng kích thước chi tiết */
#news-detail_ifr {
    height: 500px !important; /* Điều chỉnh chiều cao của trình soạn thảo */
}


      </style>
</head>
<body>
<?php 

global $wpdb;
$news_table = 'news';
$news_category_table = 'news_category';
$news_data = $wpdb->get_results(
 "SELECT n.*
FROM $news_table AS n;
" );
$categoy = $wpdb->get_results("SELECT * FROM $news_category_table");
if ($wpdb->last_error) {
 echo "Lỗi: " . $wpdb->last_error;
};

?>
<h2>Bảng tin tức</h2>
<div class="wrap">
    <button id="add-news-btn" for="control-modal" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal1">Thêm tin tức</button>
      <!-- Thêm nút "Xóa hàng loạt" -->
<button id="delete-selected-cateproject-btn" class="btn btn-danger">Xóa hàng loạt</button>
    <table class="wp-list-table widefat fixed striped" id="example">
        <thead>
            <tr>
            <th><input type="checkbox" id="select-all-checkbox"></th>
                <th>Hình ảnh</th>
                <th>Tiêu đề</th>
                <th>Alias</th>
                <th>Mô tả</th>
                <th>Loại tin tức</th>
                <th>Người tạo</th>
                <th>Thời gian tạo</th>
                <th>Hành động</th>
                <th>Hiển thị</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($news_data as $news): ?>
                <tr>
                <td><input type="checkbox" class="delete-checkbox" data-id="<?= $category->Id ?>"></td>
                    <td><img src="<?= $news->News_image ?>" alt="Hình ảnh" style="width: 50px;"></td>
                    <td><?= $news->Title ?></td>
                    <td><?= $news->Alias ?></td>
                    <td><?= $news->News_Description ?></td>
                    <td>
                    <?php
$category_title = '';
foreach ($categoy as $cate) {
    if ($cate->Id == $news->News_Category_id) {
        $category_title = $cate->category_title;
        break;
    }
}
echo $category_title;
?>

</td>
                    <td><?= $news->CreatedBy ?></td>
                    <td><?= $news->CreatedDate ?></td>
                    <td>
                    <a href="<?php echo plugin_dir_url(__FILE__) . 'editnews.php?sid=' . $news->Id ?>" class="btn btn-primary edit-news-btn">
    Sửa
</a>


                        <a onclick="return confirm('Bạn có muốn xóa không !')" href="<?php echo plugin_dir_url(__FILE__) . 'Xoa.php?sid=' . $news->Id; ?>" class="delete-news-btn btn btn-dark" data-id="<?= $news->Id ?>">Xóa</a>                    </td>
                        <td>
    <?php
    // Lấy đường dẫn đến file active.php trong plugin
    $plugin_dir_url = plugin_dir_url(__FILE__);

    // Kiểm tra giá trị của IsActive và tạo liên kết tương ứng
    if ($news->IsActive == 0) {
        echo '<a class="btn btn-dark" href="' . $plugin_dir_url . 'active.php?news_id=' . $news->Id . '">X </a>';
    } elseif ($news->IsActive == 1) {
        echo '<a class="btn btn-primary" class="btn btn-dark"href="' . $plugin_dir_url . 'active.php?news_id=' . $news->Id . '">✓</a>';
    } else {
        echo "Giá trị không hợp lệ";
    }
    ?>
</td>


                    <!-- ################################################################## -->


                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ############################################################################ -->

<div class="modal" id="myModal1">
   <div class="modal-dialog modal-xl">
   <div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
    <h4 class="modal-title">Thêm mới tin tức</h4>
    <button
     type="button"
     class="btn-close"
     data-bs-dismiss="modal"
    ></button>
    </div>
  
    <div class="modal-body">
    <form method="POST" action="<?php echo plugin_dir_url(__FILE__) . 'Them.php'; ?>">
    <div class="mb-3 mt-3">
        <label for="news-title">Tiêu đề:</label>
        <input type="text" id="news-title" name="news_title" class="form-control" /><br />
    </div>

    <div class="mb-3 mt-3">
        <label for="news-alias">Alias:</label>
        <input type="text" id="news-alias" name="news_alias" class="form-control" /><br />
    </div>

    <div class="mb-3 mt-3">
        <label for="news-description">Mô tả:</label>
        <textarea id="news-description" name="news_description" class="form-control"></textarea><br />
    </div>

    <div class="mb-3 mt-3">
        <label for="news-detail">Chi tiết:</label>
        <?php
        // Lấy nội dung hiện tại của trình soạn thảo
        $content = ''; // Khởi tạo nội dung trống
        if (isset($_POST['news_detail'])) {
            $content = wp_unslash($_POST['news_detail']); // Lấy nội dung đã nhập từ biểu mẫu
        }

        // Tạo trình soạn thảo văn bản
        wp_editor($content, 'news-detail', array(
            'textarea_name' => 'news_detail', // Tên của trường văn bản
            'textarea_rows' => 150, // Số hàng của trình soạn thảo
            'teeny' => false, // Sử dụng chế độ Teeny (true/false)
            'media_buttons' => true, // Hiển thị nút phương tiện (true/false)
            'tinymce' => true, // Sử dụng TinyMCE (true/false)
        ));
        ?>
    </div>

    <div class="mb-3 mt-3">
    <label for="news-image">Hình ảnh:</label>
    <input type="hidden" id="news-image-url" name="news_image" />
    <button id="upload-image-button" class="button">Chọn hình ảnh</button>
    <img id="selected-image" src="" style="display: none; width: 50px; height: 50px;" />
</div>


    <div class="mb-3 mt-3">
        <label for="add-news-is-active">Hiển thị:</label><br>
        <input type="checkbox" name="is_active" id="add-news-is-active"><br>
    </div>

    <label for="news-category">Thể loại:</label>
    <select id="news-category" name="news_category_id">
        <?php
            // Duyệt qua $categoy và hiển thị các danh mục
            foreach ($categoy as $cate) {
                // Hiển thị thẻ <option> cho mỗi danh mục
                echo '<option value="' . $cate->Id . '">' . $cate->category_title . '</option>';
            }
        ?>
    </select>

    <div class="mb-3 mt-3">
        <label for="news-created-by">Được tạo bởi:</label>
        <input type="text" id="news-created-by" name="news_created_by" class="form-control" /><br />
    </div>

    <input type="submit" value="Thêm tin tức mới" class="btn btn-success" />
</form>
<!-- ############################################################################## -->
<script>
    jQuery(document).ready(function ($) {
        // Xử lý sự kiện khi nhấp vào nút "Upload Image"
        $('#upload_image_button').click(function () {
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
    $('#upload-image-button').click(function(e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Chọn hình ảnh',
            multiple: false
        }).open().on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#selected-image').attr('src', image_url).show();
            $('#news-image-url').val(image_url);
        });
    });
});
new DataTable('#example', {
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