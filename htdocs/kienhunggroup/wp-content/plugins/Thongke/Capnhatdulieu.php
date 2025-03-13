<?php
// Đảm bảo mã chỉ chạy khi được gọi từ WordPress
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('run_daily_statistics_update')) {
    function run_daily_statistics_update() {
        global $wpdb;

        // Ngày hiện tại
        $current_date = date("Y-m-d");

        // Truy vấn để đếm số lượng dự án hoàn thành
        $projects_completed = $wpdb->get_var("SELECT COUNT(*) FROM project WHERE PaymentStatus = 'Hoàn thành'");

        // Truy vấn để đếm số lượng dự án đang bảo hành
        $projects_under_warranty = $wpdb->get_var("SELECT COUNT(*) FROM baohanh");

        // Truy vấn để đếm tổng số khách hàng
        $total_customers = $wpdb->get_var("SELECT COUNT(*) FROM customer");

        // Truy vấn để đếm tổng số dịch vụ
        $total_services = $wpdb->get_var("SELECT COUNT(*) FROM service");

        // Truy vấn để đếm tổng số tin tức
        $total_news = $wpdb->get_var("SELECT COUNT(*) FROM news");

        // Chèn dữ liệu thống kê vào bảng wordpress_statistics
        $table_name = 'wordpress_statistics';

        // Kiểm tra tính hợp lệ của dữ liệu
        if (
            $projects_completed !== null && 
            $projects_under_warranty !== null && 
            $total_customers !== null && 
            $total_services !== null && 
            $total_news !== null
        ) {
            $data = array(
                'Date' => $current_date,
                'Projects_Completed' => $projects_completed,
                'Projects_Under_Warranty' => $projects_under_warranty,
                'Total_Customers' => $total_customers,
                'Total_Services' => $total_services,
                'Total_News' => $total_news
            );

            $format = array('%s', '%d', '%d', '%d', '%d', '%d');

            $inserted = $wpdb->insert($table_name, $data, $format);

            if ($inserted) {
                error_log("Cập nhật thống kê thành công vào ngày $current_date");
            } else {
                error_log("Lỗi cập nhật thống kê: " . $wpdb->last_error);
            }
        } else {
            error_log("Dữ liệu không hợp lệ: Có một hoặc nhiều trường có giá trị NULL.");
        }
    }
}
?>
