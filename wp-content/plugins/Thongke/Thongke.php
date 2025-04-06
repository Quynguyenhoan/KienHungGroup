<?php
/*
Plugin Name: Thongke
Description: Plugin dùng để Thongke cho Kien Hung group
Author: Quy
Version: 1.00
*/

// Đảm bảo mã chỉ chạy khi được gọi từ WordPress
if (!defined('ABSPATH')) {
    exit;
}

// Thêm hook để thực thi chức năng plugin
add_action('admin_menu', 'Thongke_management_menu');

// Chức năng tạo mục menu quản lý thống kê
function Thongke_management_menu() {
    add_menu_page('Thống kê', 'Thống kê', 'manage_options', 'Thongke-management', 'Thongke_management_page');
}

// Thêm hook để đặt lịch cập nhật dữ liệu thống kê hàng ngày
add_action('wp_loaded', 'schedule_daily_statistics_update');

if (!function_exists('schedule_daily_statistics_update')) {
    function schedule_daily_statistics_update() {
        // Kiểm tra xem công việc đã được lên lịch chưa để tránh lên lịch nhiều lần
        if (!wp_next_scheduled('update_daily_statistics')) {
            // Lên lịch cho công việc được gọi update_daily_statistics chạy mỗi ngày lúc 00:00
            wp_schedule_event(strtotime('midnight'), 'daily', 'update_daily_statistics');
            error_log("Đã lên lịch cập nhật thống kê hàng ngày.");
        }
    }
}

// Bao gồm file email thông báo
require_once plugin_dir_path(__FILE__) . 'email_notifications.php';

// Thêm hook để chạy cập nhật dữ liệu thống kê hàng ngày
add_action('update_daily_statistics', 'update_daily_statistics_callback');

if (!function_exists('update_daily_statistics_callback')) {
    function update_daily_statistics_callback() {
        require_once plugin_dir_path(__FILE__) . 'Capnhatdulieu.php';
        run_daily_statistics_update();
    }
}

// Hiển thị thống kê
add_action('admin_enqueue_scripts', 'Thongke_enqueue_styles');

function Thongke_enqueue_styles() {
    wp_enqueue_style('thongke-styles', plugins_url('thongke.css', __FILE__));
}

// Thêm Bootstrap vào WordPress
function enqueue_bootstrap() {
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

// Chức năng hiển thị trang quản lý thống kê
function Thongke_management_page() {
    echo "<h2>Thống kê các bảng</h2>";
    // Bao gồm file thống kê các bảng
    require_once plugin_dir_path(__FILE__) . 'Thongkecacbang/thongkecacbang.php';

    echo "<h2>Thống kê hàng tháng</h2>";
    // Bao gồm file thống kê hàng tháng
    require_once plugin_dir_path(__FILE__) . 'Thongketheothang/thongkehangthang.php';
}
?>
