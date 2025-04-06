<?php
// Kết nối cơ sở dữ liệu
global $wpdb;
if (!$wpdb) {
    die("Lỗi: Đối tượng cơ sở dữ liệu WordPress không được khởi tạo.");
}
// Nhận dữ liệu từ form
$Title = $_POST['news_title'];
$Alias = $_POST['news_alias'];
$Description = $_POST['news_description'];
$Detail = $_POST['news_detail'];
$Image = $_POST['news_image'];
$Category_id = $_POST['news_category_id'];
$Created_by = $_POST['news_created_by'];

$news_table = 'news';
$category_table = 'news_category';
// Sử dụng chuẩn bị câu lệnh với tham số hóa
$themsql = $wpdb->prepare(
    "INSERT INTO $news_table (news_title, news_alias, news_description, news_detail, news_image, news_category_id, news_created_by) 
    VALUES ('$Title', '$Alias', '$Description', '$Detail', '$Image',  '$Category_id', '$Created_by')"
);

// Thực thi câu lệnh thêm
$wpdb->query($themsql);

// Kiểm tra lỗi
if ($wpdb->last_error) {
    echo "Lỗi: " . $wpdb->last_error;
} else {
    echo "Thêm thành công!";
}
?>
