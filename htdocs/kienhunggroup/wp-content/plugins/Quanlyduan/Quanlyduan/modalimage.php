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
<script src="/kienhunggroup/demowordpress/wp-content/plugins/Quanlyduan/public/ckfinder/ckfinder.js"></script>
</head>
<body>
<?php
// Kết nối đến cơ sở dữ liệu
require_once 'ketnoi.php';
$project_table = 'project';
$project_image_table = "project_image";
$id = $_POST['projectId'];

// Truy vấn dữ liệu từ bảng project_image cho dự án hiện tại
$editproject = "SELECT * FROM $project_image_table WHERE Project_id = '$id'";
$imageResult = mysqli_query($conn, $editproject);

// Kiểm tra xem câu truy vấn trả về ít nhất một hàng dữ liệu
if(mysqli_num_rows($imageResult) > 0) {
    // Khai báo một mảng để lưu trữ tất cả các hình ảnh
    $images = array();

    // Lặp qua tất cả các hàng dữ liệu và lưu trữ hình ảnh vào mảng
    while($imageRow = mysqli_fetch_assoc($imageResult)) {
        $images[] = $imageRow['Project_Image_n'];
    }
} else {
    // Xử lý trường hợp không có hình ảnh nào được tìm thấy
    $images = array(); // Có thể không cần thiết trong trường hợp này, tùy thuộc vào logic ứng dụng của bạn
} 

?>
<div class="modal" id="imagemodalpro">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Quản lý hình ảnh dự án </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
    <form method="post" action="/kienhunggroup/demowordpress/wp-content/plugins/Quanlyduan/Quanlyduan/imagefinal.php" enctype="multipart/form-data">
        <div class="selected-images-container">
            <?php foreach ($images as $imageItem): ?>
                <img src="<?= $imageItem ?>" alt="Project Image" width="100" height="100">
            <?php endforeach; ?>
        </div>
        <input type="hidden" name="projectId" value="<?= $id ?>">
        <div class="mb-3 mt-3">
            <label for="edit-project-image">Hình ảnh:</label>
            <input type="hidden" id="project-imagein-url" class="form-control" name="edit-project-image" value="<?php echo isset($images[0]) ? $images[0] : ''; ?>" />     
            <button id="upload-imagenpro-button" class="button">Chọn hình ảnh</button>
        </div>
        <input type="submit" value="Thêm hình ảnh dự án" class="btn btn-success" />
    </form>
</div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal"> X
</button>
            </div>
        </div>
    </div>
</div>
<script> 

$('#upload-imagenpro-button').click(function (e) {
    e.preventDefault();
    // Mở CKFinder
    CKFinder.modal({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
    var files = evt.data.files; // Lấy danh sách các file đã chọn
    var imageUrls = [];
    files.forEach(function (file) {
        // Lấy đường dẫn của từng file đã chọn và thêm vào mảng imageUrls
        imageUrls.push(file.getUrl());
    });

    // Gán các đường dẫn ảnh vào trường ẩn #project-imagein-url
    $('#project-imagein-url').val(imageUrls.join(','));

    // Hiển thị tất cả các hình ảnh đã chọn
    showSelectedImages(imageUrls);
});

        }
    });
});
// Hàm hiển thị các hình ảnh đã chọn
function showSelectedImages(imageUrls) {
    var container = $('.selected-images-container');
    container.empty(); // Xóa các hình ảnh hiện tại trong container
    // Thêm các hình ảnh mới vào container
    for (var i = 0; i < imageUrls.length; i++) {
        var imageUrl = imageUrls[i];
        container.append('<img src="' + imageUrl + '" alt="Project Image" width="100" height="100">');
    }
}

</script>
</body>
</html>
