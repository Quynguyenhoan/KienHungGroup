<?php
// Kết nối cơ sở dữ liệu
global $wpdb;

// Ngày bắt đầu và kết thúc của tháng hiện tại
$start_date = date('Y-m-01');
$end_date = date('Y-m-t');

// Truy vấn số lượng khách hàng trong tháng hiện tại
$total_customers_month = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM customer WHERE DATE(CreatedDate) BETWEEN %s AND %s",
    $start_date, $end_date
));
?>


<div class="statistics-row">
    <div class="statistics-box">
        <h5>Tổng số khách hàng trong tháng này</h5>
        <p><?php echo $total_customers_month; ?></p>
    </div>
</div>
