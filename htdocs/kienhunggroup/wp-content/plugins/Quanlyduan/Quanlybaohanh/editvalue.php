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
    $baohanh_id = $_GET['sid'];
    $baohanh_table = 'baohanh';
    $baohanh_category_table = 'project';
    $baohanh_edit =("SELECT * FROM $baohanh_table WHERE Id ='$baohanh_id'");
    $baohanh_cate = ("SELECT * FROM $baohanh_category_table");
    $result = mysqli_query($conn, $baohanh_edit);
$procate = mysqli_query($conn, $baohanh_cate);
$procaterow = mysqli_fetch_assoc($procate);
$baohanh_data = mysqli_fetch_assoc($result);
        // Nếu dự án tồn tại, hiển thị form sửa thông tin
        ?>
            <div class="container">
            <button onclick="window.location.href = 'http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=baohanh-management';" class="btn btn-outline-warning">Quay lại</button>
<h2 style="text-align :center"> Sửa bảo hành</h2>
    <hr>
                <form method="POST" action="edit.php">
                    <input type="hidden" name="baohanh_id" value="<?php echo $baohanh_data['Id'] ?>">
                    <div class="mb-3">
                        <label for="baohanh-title" class="form-label">Tiêu đề:</label>
                        <input type="text" id="baohanh-edit-title" name="baohanh_edit_title" class="form-control" value="<?php echo $baohanh_data['Title'] ?>">
                    </div>

                    <div class="mb-3">
                        <label for="baohanh-timebaohanh" class="form-label">Thời gian bảo hành:</label>
                        <input type="number" id="baohanh-edit-timebaohanh" name="baohanh_edit_timebaohanh" class="form-control" value="<?php echo $baohanh_data['ThoiGianBaoHanh']  ?>">
                    </div>

                    <div class="mb-3">
                        <label for="baohanh-description" class="form-label">Mô tả:</label>
                        <textarea id="baohanh-edit-description" name="baohanh_edit_description" class="form-control"><?php echo $baohanh_data['MoTa']  ?></textarea>
                    </div>

                    <div class="mb-3">
                    <label for="baohanh-category">Dự án hỗ trợ:</label>
                        <select id="baohanh-category" name="baohanh_category_id">
                        <?php // Lấy danh sách thể loại
$category_query = "SELECT * FROM $baohanh_category_table";
$category_result = mysqli_query($conn, $category_query);
$categories = mysqli_fetch_all($category_result, MYSQLI_ASSOC); ?>
                        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['Id'] ?>" <?php if ($category['Id'] == $baohanh_data['Id']) echo 'selected'; ?>><?= $category['TenDuAn'] ?></option>
        <?php endforeach; ?>
                        </select>
                    </div>

                        <div class="mb-3 mt-3">
                            <label for="baohanh-created-by">Được sửa đổi bởi:</label>
                            <input type="text" id="baohanh-edit-created-by" name="baohanh_edit_created_by" class="form-control" value="<?php  echo $baohanh_data['Modifiedby'] ?>" /><br />
                        </div>

                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
                
            </div>
            <script> 
           // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#baohanh-edit-description'), {
                // Configuration options
                ckfinder: {
                    // Thay đổi đường dẫn CKFinder theo đường dẫn của bạn
                    uploadUrl: '/kienhunggroup/demowordpress/wp-content/plugins/Quanlyduan/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
                }
            })
            .then(baohanh_edit_description => {
                console.log('CKEditor initialized with CKFinder');
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });

            // ckfinder 
            jQuery(document).ready(function ($) {
    $('#upload-baohanh-image-button').click(function (e) {
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
                    $('#baohanh-edit-image-url').val(file.getUrl());
                    $('#selected-editimage').attr('src', file.getUrl()).show();
                });
            }
        });
    });
});
 </script>
        </body>

        </html>
