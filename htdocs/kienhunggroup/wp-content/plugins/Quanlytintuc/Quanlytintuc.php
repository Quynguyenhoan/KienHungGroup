<?php
/*
Plugin Name: Quanlytintuc
Description: Plugin helps manage news for Kien Hung group
Author: Quy
Version: 1.00
*/

// Bao gồm các tệp WordPress cần thiết
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

// Thêm hook để thực thi chức năng plugin
add_action('admin_menu', 'news_management_menu');

// Chức năng tạo mục menu quản lý tin tức
function news_management_menu() {
    add_menu_page('Quản lý tin tức', 'Quản lý tin tức', 'manage_options', 'news-management', 'news_management_page');
}

// Chức năng hiển thị trang quản lý tin tức
function news_management_page() {
    // Kết nối cơ sở dữ liệu
    global $wpdb;
    echo "<h2>Quản lý danh mục tin tức</h2>";
    // Bao gồm file quản lý danh mục tin tức từ thư mục Quanlydanhmuctintuc
    require_once 'Quanlydanhmuctintuc/Quanlydanhmuc.php';
    // ############################################################
    echo "<h2>Quản lý tin tức</h2>";
    // Bao gồm file quản lý tin tức từ thư mục Quanlytintuc
    require_once 'Quanlytintuc/Quanlytintuc.php';
    echo'<br>';
}
?>
