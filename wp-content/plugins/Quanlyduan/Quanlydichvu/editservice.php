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
    <title>Sửa dịch vụ</title>
    <style>
        /* Tăng kích thước chi tiết */
        #edit_service_description_ifr {
            height: 500px !important; /* Điều chỉnh chiều cao của trình soạn thảo */
        }
    </style>
</head>
<body>
    <?php
    $service = 'service';
    $id = $_GET['sid'];
    $editservice = ("SELECT * FROM $service WHERE id = '$id'");
    require_once 'ketnoi.php';
    // Thực hiện truy vấn SQL
    $query = "SELECT * FROM  $service  ";
    $result = mysqli_query($conn, $query);
    $result = mysqli_query($conn, $editservice);
    $row2 = mysqli_fetch_assoc($result);
    ?>

    <button onclick="window.location.href = 'http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=project-management';" class="btn btn-outline-warning">Quay lại</button>
    <hr>
    <h2 style="text-align: center;">Chỉnh sửa dịch vụ</h2>
    <form method="POST" action="edit.php">
        <input type="hidden" name="edit_service_id" value="<?php echo $row2['Id']; ?>">
        <div class="mb-3">
            <label for="edit_service-title">Tiêu đề:</label>
            <input type="text" id="edit_service-title" class="form-control" name="edit_service_title" value="<?php echo $row2['Title']; ?>">
        </div>
        <div class="mb-3">
            <label for="edit_service-description">Mô tả:</label>
            <textarea id="edit_service_description_ifr" class="form-control" name="edit_service_description"><?php echo $row2['service_Description']; ?></textarea>
        </div>

        <div class="mb-3 mt-3">
    <label for="edit-service-image">Hình ảnh:</label>
    <input type="hidden" id="service-Image-url" class="form-control" name="edit-service-image" value="<?php echo $row2['Image_URL'] ?>" />
    <button id="upload-svimage-button" class="button">Chọn hình ảnh</button>
    <img id="selected-serviceimage" src="<?php echo $row2['Image_URL']; ?>" style="display: <?php echo ($row2['Image_URL'] != '') ? 'block' : 'none'; ?>; width: 50px; height: 50px;" />
</div>

        <div class="mb-3">
            <label for="edit_service-created-by">Người sửa:</label>
            <input type="text" id="edit_service-created-by" class="form-control" name="edit_service_created_by" value="<?php echo $row2['Modifiedby']; ?>">
        </div>

        <div class="mb-3">
            <input type="submit" value="Lưu chỉnh sửa" class="btn btn-primary">
        </div>
    </form>
      <!-- ckedit -->
    
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script>
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#edit_service_description_ifr'), {
                // Configuration options
                ckfinder: {
                    // Thay đổi đường dẫn CKFinder theo đường dẫn của bạn
                    uploadUrl: '/kienhunggroup/demowordpress/wp-content/plugins/Quanlyduan/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
                }
            })
            .then(edit_service_description_ifr => {
                console.log('CKEditor initialized with CKFinder');
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    </script>
<!-- ckfinder -->
<script>
jQuery(document).ready(function ($) {
    $('#upload-svimage-button').click(function (e) {
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
                    $('#service-Image-url').val(file.getUrl());
                    $('#selected-serviceimage').attr('src', file.getUrl()).show();
                });
            }
        });
    });
});
</script>
<script src="/kienhunggroup/demowordpress/wp-content/plugins/Quanlyduan/public/ckfinder/ckfinder.js"></script>

</body>
</html>