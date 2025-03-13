     <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Sửa dự án</title>
             
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Latest compiled and minified CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <!-- ckfinder -->
    <script src="/kienhunggroup/demowordpress/wp-content/plugins/Quanlyduan/public/ckfinder/ckfinder.js"></script>

        </head>

        <body>
        <?php

// Include file kết nối database
require_once 'ketnoi.php';
    // Lấy ID dự án từ URL
    $project_id = $_GET['sid'];
    $project_table = 'project';
    $project_category_table = 'project_category';
    $project_edit =("SELECT * FROM $project_table WHERE Id ='$project_id'");
    $project_cate = ("SELECT * FROM $project_category_table");
    $result = mysqli_query($conn, $project_edit);
$procate = mysqli_query($conn, $project_cate);
$procaterow = mysqli_fetch_assoc($procate);
$project_data = mysqli_fetch_assoc($result);
        // Nếu dự án tồn tại, hiển thị form sửa thông tin
        ?>
            <div class="container">
            <button onclick="window.location.href = 'http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management';" class="btn btn-outline-warning">Quay lại</button>
<h2 style="text-align :center"> Sửa dự án</h2>
    <hr>
                <form method="POST" action="edit.php">
                    <input type="hidden" name="project_id" value="<?php echo $project_data['Id'] ?>">
                    <div class="mb-3">
                        <label for="project-title" class="form-label">Tiêu đề:</label>
                        <input type="text" id="project-edit-title" name="project_edit_title" class="form-control" value="<?php echo $project_data['TenDuAn'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="project-alias" class="form-label">Alias:</label>
                        <input type="text" id="project-edit-alias" name="project_edit_alias" class="form-control" value="<?php echo $project_data['Alias']  ?>">
                    </div>

                    <div class="mb-3">
                        <label for="project-diachi" class="form-label">Địa chỉ:</label>
                        <input type="text" id="project-edit-diachi" name="project_edit_diachi" class="form-control" value="<?php echo $project_data['DiaChi']  ?>">
                    </div>

                    <div class="mb-3">
                        <label for="project-dateproject" class="form-label">Ngày bắt đầu:</label>
                        <input type="date" id="project-edit-dateproject" name="project_edit_dateproject" class="form-control" value="<?php echo $project_data['NgayBatDau'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="project-dateend" class="form-label">Ngày kết thúc:</label>
                        <input type="date" id="project-edit-dateend" name="project_edit_dateend" class="form-control" value="<?php echo $project_data['NgayKetThuc']  ?>">
                    </div>

                    <div class="mb-3">
                        <label for="project-description" class="form-label">Mô tả:</label>
                        <textarea id="project-edit-description" name="project_edit_description" class="form-control"><?php echo $project_data['Project_Description']  ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="project-image" class="form-label">Hình ảnh:</label>
                        <input type="hidden" id="project-edit-image-url" name="project_edit_image" class="form-control" value="<?php echo $project_data['project_image_c']  ?>">
                        <button id="upload-project-image-button" class="btn btn-primary">Chọn hình ảnh</button>
                        <img id="selected-editimage" src="<?php echo $project_data['project_image_c']  ?>" style="display: <?php echo $project_data['project_image_c']  ? 'block' : 'none'; ?>; width: 50px; height: 50px;" />
                    </div>
                    <div class="mb-3">
                    <label for="project-category">Thể loại:</label>
                        <select id="project-category" name="project_category_id">
                            
                        <?php // Lấy danh sách thể loại
$category_query = "SELECT * FROM $project_category_table";
$category_result = mysqli_query($conn, $category_query);
$categories = mysqli_fetch_all($category_result, MYSQLI_ASSOC); ?>
                        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['Id'] ?>" <?php if ($category['Id'] == $project_data['ProjectCategory_id']) echo 'selected'; ?>><?= $category['Title'] ?></option>
        <?php endforeach; ?>
                        </select>
                    </div>
                        <div class="mb-3">
    <label for="payment-status">Tình trạng thanh toán:</label>
    <select id="payment-status" name="payment_status" class="form-control">
        <?php 
// Lấy danh sách tình trạng thanh toán
$payment_statuses = array("Hoàn thành", "Chưa hoàn thành", "Đang chờ");
?>
     <?php foreach ($payment_statuses as $status): ?>
            <option value="<?= $status ?>" <?php if ($status == $project_data['PaymentStatus']) echo 'selected'; ?>><?= $status ?></option>
        <?php endforeach; ?>
    </select>
</div>

                    <div class="mb-3 mt-3">
                        <label for="total_amount">Tổng giá tiền:</label>
    <input type="text" id="total_edit_amount" name="total_edit_amount" value="<?php  echo $project_data['TotalAmount'] ?>">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="project-created-by">Được sửa đổi bởi:</label>
                            <input type="text" id="project-edit-created-by" name="project_edit_created_by" class="form-control" value="<?php  echo $project_data['ModifiedBy'] ?>" /><br />
                        </div>

                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
                
            </div>
            <script> 
           // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#project-edit-description'), {
                // Configuration options
                ckfinder: {
                    // Thay đổi đường dẫn CKFinder theo đường dẫn của bạn
                    uploadUrl: '/kienhunggroup/demowordpress/wp-content/plugins/Quanlyduan/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
                }
            })
            .then(project_edit_description => {
                console.log('CKEditor initialized with CKFinder');
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });

            // ckfinder 
            jQuery(document).ready(function ($) {
    $('#upload-project-image-button').click(function (e) {
        e.preventDefault();
        // Mở CKFinder
        CKFinder.modal({
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function (finder) {
                finder.on('files:choose', function (evt) {
                    var file = evt.data.files.first();
                    // Lấy đường dẫn của file đã chọn và cập nhật vào trường input và hiển thị ảnh
                    $('#project-edit-image-url').val(file.getUrl());
                    $('#selected-editimage').attr('src', file.getUrl()).show();
                });
            }
        });
    });
});

  // Tổng tiền 
  document.addEventListener("DOMContentLoaded", function() {
    // Lắng nghe sự kiện khi trường input total amount thay đổi
    document.getElementById("total_edit_amount").addEventListener("input", function() {
        // Lấy giá trị nhập vào từ trường input
        let input_value = this.value;

        // Loại bỏ tất cả các ký tự không phải số và dấu phẩy (phân cách hàng nghìn)
        let numeric_value = input_value.replace(/[^\d,]/g, '');

        // Chuyển đổi giá trị thành số thực
        let amount = parseFloat(numeric_value.replace(/,/g, ''));

        // Kiểm tra xem giá trị có hợp lệ không
        if (!isNaN(amount)) {
            // Định dạng số tiền với hàng nghìn phân cách bằng dấu chấm, không có số lẻ
            let formatted_string = numberWithCommas(amount.toFixed(0));

            // Hiển thị giá trị đã chuyển đổi lại trong trường input
            this.value = formatted_string;
        }
    });
});

// Hàm tự định nghĩa để thêm dấu chấm làm phân cách hàng nghìn
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
 </script>
        </body>

        </html>
