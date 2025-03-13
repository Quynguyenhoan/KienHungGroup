<?php
// email_notifications.php

if (!defined('ABSPATH')) {
    exit;
}

// Kiểm tra và định nghĩa các hằng số debug nếu chúng chưa được định nghĩa
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}

if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}

if (!defined('WP_DEBUG_DISPLAY')) {
    define('WP_DEBUG_DISPLAY', false);
}

// Lên lịch công việc gửi email thống kê hàng tuần
add_action('wp_loaded', 'schedule_weekly_statistics_email');

if (!function_exists('schedule_weekly_statistics_email')) {
    function schedule_weekly_statistics_email() {
        if (!wp_next_scheduled('send_weekly_statistics_email')) {
            wp_schedule_event(strtotime('next Sunday'), 'weekly', 'send_weekly_statistics_email');
        }
    }
}

// Hook gửi email thống kê hàng tuần
add_action('send_weekly_statistics_email', 'send_weekly_statistics_email');

if (!function_exists('send_weekly_statistics_email')) {
    function send_weekly_statistics_email() {
        global $wpdb;
        $current_date = date("Y-m-d");
        $table_name='wordpress_statistics';

        // Truy vấn thống kê của tuần vừa qua
        $stats = $wpdb->get_results("
            SELECT * FROM $table_name
            WHERE Date >= DATE_SUB('$current_date', INTERVAL 1 WEEK)
            ORDER BY Date DESC
        ");

        // Gửi email thống kê hàng tuần
        $to = 'kienhunggroup12@gmail.com';  // Thay đổi địa chỉ email của bạn
        $subject = "Báo cáo thống kê hàng tuần";
        $body = "Dữ liệu thống kê cho tuần vừa qua:\n\n";

        foreach ($stats as $stat) {
            $body .= "Ngày: {$stat->Date}\n";
            $body .= "Dự án hoàn thành: {$stat->Projects_Completed}\n";
            $body .= "Dự án bảo hành: {$stat->Projects_Under_Warranty}\n";
            $body .= "Khách hàng: {$stat->Total_Customers}\n";
            $body .= "Dịch vụ: {$stat->Total_Services}\n";
            $body .= "Tin tức: {$stat->Total_News}\n\n";
        }

        $headers = array('Content-Type: text/plain; charset=UTF-8');

        if (wp_mail($to, $subject, $body, $headers)) {
            error_log('Email đã được gửi thành công.');
        } else {
            error_log('Lỗi khi gửi email.');
        }
    }
}
// Gửi email hàng tuần nếu dự án chưa hoàn thành > 5
add_action('send_weekly_statistics_email', 'send_unfinished_projects_alert');
if (!function_exists('send_unfinished_projects_alert')) {
    function send_unfinished_projects_alert() {
        global $wpdb;
        $unfinished_projects_count = $wpdb->get_var("SELECT COUNT(*) FROM project WHERE PaymentStatus='Chưa hoàn thành'");

        error_log('Số lượng dự án chưa hoàn thành: ' . $unfinished_projects_count);

        if ($unfinished_projects_count > 5) {
            $to = 'kienhunggroup12@gmail.com';  // Thay đổi địa chỉ email của bạn
            $subject = "Cảnh báo: Dự án chưa hoàn thành";
            $body = "Có $unfinished_projects_count dự án chưa hoàn thành. Vui lòng kiểm tra và thực hiện các biện pháp cần thiết.";
            $headers = array('Content-Type: text/plain; charset=UTF-8');

            if (wp_mail($to, $subject, $body, $headers)) {
                error_log('Email cảnh báo dự án chưa hoàn thành đã được gửi thành công.');
            } else {
                error_log('Lỗi khi gửi email cảnh báo dự án chưa hoàn thành.');
            }
        }
    }
}

?>
