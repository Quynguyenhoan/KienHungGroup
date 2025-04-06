<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa danh mục tin tức</title>
      <!-- Latest compiled and minified CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>
    <?php
    $news_table = 'news';
    $news_category_table = 'news_category';
    $id = $_GET['sid'];
    $editnews = ("SELECT * FROM $news_category_table WHERE id = '$id'");
    require_once 'ketnoi.php';
    // Thực hiện truy vấn SQL
    $query = "SELECT * FROM  $news_category_table  ";
    $result = mysqli_query($conn, $query);
    $result = mysqli_query($conn, $editnews);
    $row2 = mysqli_fetch_assoc($result);
    ?>
    <button onclick="window.location.href = 'http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=news-management';" class="btn btn-outline-warning">Quay lại</button>
<h2 style="text-align :center"> Chỉnh sửa danh mục tin tức</h2>
    <hr>
<form id="edit-catenews-form" action="edit.php" method="post">
<input type="hidden" name="id" id="edit-news-id" value="<?php echo $row2['Id'] ?>">
                <div class="mb-3 mt-3">
                <label for="edit-news-title" name="titleNewsSua">Tiêu đề:</label>
                <input type="text" name="title" id="edit-catenews-title" class="form-control" value="<?php echo $row2['category_title'] ?>">
                </div>
                <div class="mb-3 mt-3">
                <label for="edit-news-alias">Alias:</label>
                <input type="text" name="alias" id="edit-catenews-alias" class="form-control" value="<?php echo $row2['Alias'] ?>">
                </div>
                <div class="mb-3 mt-3">
                <label for="edit-news-description">Mô tả:</label>
                <textarea name="description" rows="10" id="description"><?php echo $row2['News_Category_Description'] ?></textarea>
                </div>
                <div class="mb-3 mt-3">
    <label for="edit_parent_category_id">Danh mục cha:</label>
    <select name="edit_parent_category_id" class="form-control">
        <option value="">Không có danh mục cha</option>
        <?php
        // Thực hiện truy vấn SQL để lấy danh sách danh mục cha
        $query = "SELECT * FROM $news_category_table";
        $result = mysqli_query($conn, $query);
        $category_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Duyệt qua danh sách danh mục cha và hiển thị các tùy chọn
        foreach ($category_data as $cate) {
            // Kiểm tra xem danh mục cha hiện tại có phải là danh mục cha được chọn cho bản ghi đang được sửa hay không
            $selected = ($cate['Id'] == $row2['parent_category_id']) ? 'selected' : '';
            // Hiển thị thẻ <option> cho mỗi danh mục cha
            echo '<option value="' . $cate['Id'] . '" ' . $selected . '>' . $cate['category_title'] . '</option>';
        }
        ?>
    </select>
</div>

<div class="mb-3 mt-3">
    <label for="edit-newscate-icon">Icon:</label>
    <input type="hidden" id="newscate-icon-url" class="form-control" name="edit-newscate-icon" value="<?php echo $row2['Icon'] ?>" />
    <button id="upload-icon-button" class="button">Chọn hình ảnh</button>
    <img id="selected-icon" src="<?php echo $row2['Icon']; ?>" style="display: <?php echo ($row2['Icon'] != '') ? 'block' : 'none'; ?>; width: 50px; height: 50px;" />
</div>

                <div class="mb-3 mt-3">
                <label for="edit-catenews-modified-by">Được sửa đổi bởi:</label>
                <input type="text" name="modified_by" id="edit-catenews-modified-by" class="form-control" value="<?php echo $row2['Modifiedby'] ?>">
                </div>
                <button type="submit" class="btn btn-primary">Sửa danh mục tin tức</button>
              </form>
<!-- ############################################ -->

    <!-- ckedit -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

                 
                 <script>
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#description'), {
                // Configuration options
                ckfinder: {
                    // Thay đổi đường dẫn CKFinder theo đường dẫn của bạn
                    uploadUrl: '/kienhunggroup/demowordpress/wp-content/plugins/Quanlytintuc/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
                }
            })
            .then(description => {
                console.log('CKEditor initialized with CKFinder');
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    </script>

                <script>
jQuery(document).ready(function ($) {
    $('#upload-icon-button').click(function (e) {
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
                    $('#newscate-icon-url').val(file.getUrl());
                    $('#selected-icon').attr('src', file.getUrl()).show();
                });
            }
        });
    });
});
</script>
<script src="/kienhunggroup/demowordpress/wp-content/plugins/Quanlytintuc/public/ckfinder/ckfinder.js"></script>

</body>
</html>