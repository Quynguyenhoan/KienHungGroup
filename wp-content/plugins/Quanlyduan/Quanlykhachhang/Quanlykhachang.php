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

      </style>
</head>
<body>
<?php 

global $wpdb;
$customer_table = 'customer';
$project_table = 'project';
$customer_data = $wpdb->get_results(
 "SELECT n.*
FROM $customer_table AS n;
" );
$project_data = $wpdb->get_results(
    "SELECT *
    FROM $project_table"
);
if ($wpdb->last_error) {
 echo "Lỗi: " . $wpdb->last_error;
};
  
?>

<h2>Bảng khách hàng</h2>
<div class="wrap">
    <button id="add-Customer-btn" for="control-modal" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mycustomerthem">Thêm khách hàng</button>
      <!-- Thêm nút "Xóa hàng loạt" -->
<button id="delete-selected-customer-btn" class="btn btn-danger ">Xóa hàng loạt</button>
    <table class="wp-list-table widefat fixed striped" id="example">
        <thead>
            <tr>
            <th><input type="checkbox" id="select-all-checkbox2"></th>
                <th>Tên</th>
                <th>Địa chỉ</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Đã đọc</th>
                <th>Tình trạng</th>
                <th>Tham gia dự án</th>
                <th>Người tạo</th>
                <th>Thời gian tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($customer_data as $customer): ?>
    <?php
    $customer_projects = $wpdb->get_results(
        "SELECT project.*
        FROM customer_project
        INNER JOIN $project_table ON customer_project.MaDuAn = $project_table.Id
        WHERE customer_project.MaKhachHang = {$customer->Id}"
    );
    ?>
                <tr>
                <td><input type="checkbox" class="delete-checkbox-customer"></td>
                    <td><?= $customer->Customer_Name ?></td>
                    <td><?= $customer->Customer_Address	?></td>
                    <td><?= $customer->Customer_Email	?></td>
                    <td><?= $customer->Customer_Phone ?></td>
                    <td>
    <?php
    // Lấy đường dẫn đến file active.php trong plugin
    $plugin_dir_url = plugin_dir_url(__FILE__);

    // Kiểm tra giá trị của Customer_IsRead và tạo liên kết tương ứng
    if ($customer->Customer_IsRead == 0) {
        echo '<a class="btn btn-dark" href="' . $plugin_dir_url . 'active1.php?Customer_id=' . $customer->Id . '">X </a>';
    } elseif ($customer->Customer_IsRead == 1) {
        echo '<a class="btn btn-primary" class="btn btn-dark"href="' . $plugin_dir_url . 'active1.php?Customer_id=' . $customer->Id . '">✓</a>';
    } else {
        echo "Giá trị không hợp lệ";
    }
    ?>
</td>

<td>
<select class="customer-status" data-id="<?= $customer->Id ?>" style="width: 90px;">
                        <option value="1" <?= $customer->IsFromContact == 1 ? 'selected' : '' ?>>Tư vấn</option>
                        <option value="2" <?= $customer->IsFromContact == 2 ? 'selected' : '' ?>>Người quen</option>
                        <option value="3" <?= $customer->IsFromContact == 3 ? 'selected' : '' ?>>Khách hàng tiềm năng</option>
                        <option value="4" <?= $customer->IsFromContact == 4 ? 'selected' : '' ?>>Người tham gia dự án</option>
                    </select>
</td>
<td>
    <?php
    foreach ($customer_projects as $project) {
        echo $project->TenDuAn . '<br>';
    }
    ?>
</td>

                    <td><?= $customer->CreatedBy ?></td>
                    <td><?= $customer->CreatedDate ?></td>
                    <td>
                    <a href="<?php echo plugin_dir_url(__FILE__) . 'editvalue.php?sid=' . $customer->Id ?>" class="btn btn-primary edit-Customer-btn">
    Sửa
</a>


                        <a onclick="return confirm('Bạn có muốn xóa không !')" href="<?php echo plugin_dir_url(__FILE__) . 'Xoa.php?sid=' . $customer->Id; ?>" class="delete-Customer-btn btn btn-dark" data-id="<?= $customer->Id ?>">Xóa</a>                    </td>


                    <!-- ################################################################## -->


                </tr>
                <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ############################################################################ -->

<div class="modal" id="mycustomerthem">
   <div class="modal-dialog modal-xl">
   <div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
    <h4 class="modal-title">Thêm mới khách hàng</h4>
    <button
     type="button"
     class="btn-close"
     data-bs-dismiss="modal"
    ></button>
    </div>
  
    <div class="modal-body">
    <form method="POST" action="<?php echo plugin_dir_url(__FILE__) . 'Them.php'; ?>">
    <div class="mb-3 mt-3">
        <label for="Customer_Name">Tên:</label>
        <input type="text" id="Customer_Name" name="Name_customer" class="form-control" /><br />
    </div>
    <div class="mb-3 mt-3">
        <label for="Customer_address">Địa chỉ:</label>
        <input type="text" id="Customer_address" name="Customer_address" class="form-control" /><br />
    </div>
    <div class="mb-3 mt-3">
        <label for="Customer-Email">Email:</label>
        <input type="email" id="Customer-Email" name="Customer_Email" class="form-control" /><br />
    </div>
    <div class="mb-3 mt-3">
        <label for="Customer-Phone">Số điện thoại:</label>
        <input type="number" id="Customer-Phone" name="Customer_Phone" class="form-control" /><br />
    </div>

    <div class="mb-3 mt-3">
        <label for="Customer-description">Mô tả:</label>
        <textarea id="Customer-description" name="Customer_description" class="form-control"></textarea><br />
    </div>

    <div class="mb-3 mt-3">
    <label for="add-Customer-is-read">Đã xem:</label><br>
    <input type="checkbox" name="add_Customer_is_read" id="add_Customer_is_read"><br>
</div>

<div class="mb-3 mt-3">
    <label for="customer-status">Tình trạng :</label><br>
    <select name="customer_status" id="customer-status">
        <option value="nguoi_quen">Người quen</option>
        <option value="khach_hang_tiem_nang">Khách hàng tiềm năng</option>
        <option value="nguoi_tham_gia_du_an">Người tham gia dự án</option>
    </select>
</div>

    <div class="mb-3 mt-3">
    <label for="customer-projects">Dự án:</label><br>
    <select multiple id="customer-projects" name="customer_projects[]" class="form-control">
        <?php foreach ($project_data as $project): ?>
            <option value="<?= $project->Id ?>"><?= $project->TenDuAn ?></option>
        <?php endforeach; ?>
    </select>
</div>
    <div class="mb-3 mt-3">
        <label for="Customer-created-by">Được tạo bởi:</label>
        <input type="text" id="Customer-created-by" name="Customer_created_by" class="form-control" /><br />
    </div>

    <input type="submit" value="Thêm khách hàng mới" class="btn btn-success" />
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
            title: 'Chọn Tên',
            multiple: false
        }).open().on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#selected-image').attr('src', image_url).show();
            $('#Customer-image-url').val(image_url);
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
    $('#select-all-checkbox2').change(function() {
        // Nếu checkbox "Chọn tất cả" được chọn
        if ($(this).prop('checked')) {
            // Chọn tất cả các checkbox hàng
            $('.delete-checkbox-customer').prop('checked', true);
        } else {
            // Bỏ chọn tất cả các checkbox hàng
            $('.delete-checkbox-customer').prop('checked', false);
        }
    });

    // Sự kiện khi các checkbox hàng được thay đổi trạng thái
    $('.delete-checkbox-customer').change(function() {
        // Nếu có ít nhất một checkbox hàng không được chọn
        if ($('.delete-checkbox-customer:not(:checked)').length > 0) {
            // Bỏ chọn checkbox "Chọn tất cả"
            $('#select-all-checkbox2').prop('checked', false);
        } else {
            // Nếu tất cả các checkbox hàng được chọn
            // Chọn cả checkbox "Chọn tất cả"
            $('#select-all-checkbox2').prop('checked', true);
        }
    });
});

//  xóa hàng loạt
jQuery(document).ready(function ($) {
    $('#delete-selected-customer-btn').click(function () {
    var selectedIds = []; // Mảng chứa ID của các danh mục được chọn
    $('.delete-checkbox-customer:checked').each(function () {
        selectedIds.push($(this).closest('tr').find('.delete-Customer-btn').data('id')); // Thêm ID vào mảng
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
//  Tình trạng khách hàng 
$(document).ready(function() {
    $('.customer-status').change(function() {
        var status = $(this).val();
        var customerId = $(this).data('id');
        
        $.ajax({
            url: '<?php echo $plugin_dir_url; ?>active2.php',
            type: 'POST',
            data: {
                status: status,
                customer_id: customerId
            },
            success: function(response) {
                alert('Trạng thái đã được cập nhật!');
                // Bạn có thể thêm mã để thay đổi giao diện tùy theo phản hồi từ server
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra: ' + error);
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