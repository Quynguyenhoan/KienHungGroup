
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Latest compiled and minified CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
      <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
      <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
</head>
<body>
<?php
$news_table = 'news';
$news_category_table = 'news_category';
$id = $_GET['sid'];
$editnews = ("SELECT * FROM $news_table WHERE id = '$id'");
require_once 'ketnoi.php';
// Thực hiện truy vấn SQL
$query = "SELECT * FROM news_category";
$result = mysqli_query($conn, $query);
$result = mysqli_query($conn, $editnews);
$row2 = mysqli_fetch_assoc($result);
?>
<button onclick="window.location.href = 'http://localhost/kienhunggroup/demowordpress/wp-admin/admin.php?page=news-management';" class="btn btn-outline-warning">Quay lại</button>
<h2 style="text-align :center"> Chỉnh sửa tin tức</h2>
    <hr>
<form id="edit-news-form" action="SuaNews.php" method="post">
<input type="hidden" name="id" id="edit-news-id" value="<?php echo $row2['Id'] ?>">
                <div class="mb-3 mt-3">
                <label for="edit-news-title" name="titleNewsSua">Tiêu đề:</label>
                <input type="text" name="title" id="edit-news-title" class="form-control" value="<?php echo $row2['Title'] ?>">
                </div>
                <div class="mb-3 mt-3">
                <label for="edit-news-alias">Alias:</label>
                <input type="text" name="alias" id="edit-news-alias" class="form-control" value="<?php echo $row2['Alias'] ?>">
                </div>
                <div class="mb-3 mt-3">
                <label for="edit-news-description">Mô tả:</label>
                <input name="description" id="edit-news-description" class="form-control"  value="<?php echo $row2['News_Description'] ?>">
                </div>
                <div class="mb-3 mt-3">
                <label for="edit-news-detail">Chi tiết:</label>
                <textarea name="detail" rows="10" id="detail"><?php echo $row2['Detail']; ?></textarea>

</div>

<div class="mb-3 mt-3">
    <label for="edit-news-image">Hình ảnh:</label>
    <input type="hidden" id="news-image-url" class="form-control" name="edit-news-image" value="<?php echo $row2['News_image'] ?>" />
    <button id="upload-image-button" class="button">Chọn hình ảnh</button>
    <img id="selected-image" src="<?php echo $row2['News_image']; ?>" style="display: <?php echo ($row2['News_image'] != '') ? 'block' : 'none'; ?>; width: 50px; height: 50px;" />
</div>
<div class="mb-3 mt-3">
<label for="news_category_id">Thể loại:</label>
<select id="news-category" name="news_category_id" class="form-control" >
    <!-- Populate dropdown with category options -->
    <?php
    $categoy_query = "SELECT * FROM news_category";
    $categoy_result = mysqli_query($conn, $categoy_query);    
    if ($categoy_result && mysqli_num_rows($categoy_result) > 0) {
        $categoy = mysqli_fetch_all($categoy_result, MYSQLI_ASSOC);
        foreach ($categoy as $cate) {
            echo '<option value="' . $cate['Id'] . '">' . $cate['category_title'] . '</option>';
        }
    } else {
        echo '<option value="">Không có danh mục nào</option>';
    }
    
    ?>
</select>

                </div>
                <div class="mb-3 mt-3">
                <label for="edit-news-is-active">Hiển thị:</label>
                <input type="checkbox" name="is_active" id="add-news-is-active" value="1" <?php if ($row2['IsActive'] == 1) echo 'checked'; ?>><br>
                </div>
                <div class="mb-3 mt-3">
                <label for="edit-news-modified-by">Được sửa đổi bởi:</label>
                <input type="text" name="modified_by" id="edit-news-modified-by" class="form-control" value="<?php echo $row2['Modifiedby'] ?>">
                </div>
                <button type="submit" class="btn btn-primary">Sửa tin tức</button>
              </form>
<!-- ############################################ -->

    <!-- ckedit -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script>
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#detail'), {
                // Configuration options
                ckfinder: {
                    // Thay đổi đường dẫn CKFinder theo đường dẫn của bạn
                    uploadUrl: '/kienhunggroup/demowordpress/wp-content/plugins/Quanlytintuc/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
                }
            })
            .then(detail => {
                console.log('CKEditor initialized with CKFinder');
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });
    </script>

<script>
jQuery(document).ready(function ($) {
    $('#upload-image-button').click(function (e) {
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
                    $('#news-image-url').val(file.getUrl());
                    $('#selected-image').attr('src', file.getUrl()).show();
                });
            }
        });
    });
});
</script>
<script src="/kienhunggroup/demowordpress/wp-content/plugins/Quanlytintuc/Quanlytintuc/ckfinder/ckfinder.js"></script>

</body>
</html>