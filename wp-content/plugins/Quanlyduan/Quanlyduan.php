<?php
/*
Plugin Name: Quanlyduan
Description: Plugin helps manage Project for Kien Hung group
Author: Quy
Version: 1.00
*/

// Bao gồm các tệp WordPress cần thiết
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

// Thêm hook để thực thi chức năng plugin
add_action('admin_menu', 'Quanlyduanfun');

// Chức năng tạo mục menu quản lý tin tức
function Quanlyduanfun() {
    add_menu_page('Quản lý dự án', 'Quản lý dự án', 'manage_options', 'project-management', 'project_management_page');
}

// Chức năng hiển thị trang quản lý tin tức
function project_management_page() {
    // Kết nối cơ sở dữ liệu
    global $wpdb;
    echo"<h2>Quản lý dịch vụ</h2>";
    require_once 'Quanlydichvu/Quanlydichvu.php';
    echo"<br>";
    echo"<h2>Quản lý danh mục dự án</h2>";
    require_once 'Quanlydanhmucduan/Quanlydanhmucduan.php';
    echo"<br>";
    echo"<h2>Quản lý dự án</h2>";
    require_once 'Quanlyduan/Quanlyduan.php';
    echo"<br>";
    echo"<h2>Quản lý khách hàng </h2>";
    require_once 'Quanlykhachhang/Quanlykhachang.php';
    echo"<br>";
    echo"<h2>Quản lý bảo hành</h2>";
    require_once 'Quanlybaohanh/Quanlybaohanh.php';
    echo"<br>";

}
?>
