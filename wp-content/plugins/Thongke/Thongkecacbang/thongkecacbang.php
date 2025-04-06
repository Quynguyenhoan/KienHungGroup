<?php
// Kết nối cơ sở dữ liệu
global $wpdb;

// Truy vấn số lượng dự án hoàn thành
$projects_completed = $wpdb->get_var("SELECT COUNT(*) FROM project WHERE PaymentStatus = 'Hoàn thành'");

// Truy vấn số lượng dự án chưa hoàn thành
$projects_incompleted = $wpdb->get_var("SELECT COUNT(*) FROM project WHERE PaymentStatus = 'Chưa hoàn thành'");

// Truy vấn số lượng dự án đang chờ duyệt
$projects_timezone = $wpdb->get_var("SELECT COUNT(*) FROM project WHERE PaymentStatus = 'Đang chờ'");

// Truy vấn số lượng dự án đang bảo hành
$projects_under_warranty = $wpdb->get_var("SELECT COUNT(*) FROM baohanh");

// Truy vấn tổng số khách hàng
$total_customers = $wpdb->get_var("SELECT COUNT(*) FROM customer");

// Truy vấn tổng số dịch vụ
$total_services = $wpdb->get_var("SELECT COUNT(*) FROM service");

// Truy vấn tổng số tin tức
$total_news = $wpdb->get_var("SELECT COUNT(*) FROM news");

// Truy vấn số lượng tin tức theo danh mục
$news_by_category = $wpdb->get_results("SELECT news_category.category_title AS category_title, COUNT(*) AS count 
                                        FROM news 
                                        INNER JOIN news_category ON news.News_Category_id  = news_category.Id 
                                        GROUP BY news.News_Category_id ");

// Truy vấn số lượng dự án theo danh mục
$projects_by_category = $wpdb->get_results("SELECT project_category.Title AS category_title, COUNT(*) AS count 
                                            FROM project 
                                            INNER JOIN project_category ON project.ProjectCategory_id = project_category.Id 
                                            GROUP BY project.ProjectCategory_id");
?>



<div class="statistics-row">
    <div class="statistics-box">
        <h5>Dự án hoàn thành</h5>
        <p><?php echo $projects_completed; ?></p>
    </div>
    <div class="statistics-box">
        <h5>Dự án chưa hoàn thành</h5>
        <p><?php echo $projects_incompleted; ?></p>
    </div>
    <div class="statistics-box">
        <h5>Dự án đang chờ duyệt</h5>
        <p><?php echo $projects_timezone; ?></p>
    </div>
    <div class="statistics-box">
        <h5>Dự án đang bảo hành</h5>
        <p><?php echo $projects_under_warranty; ?></p>
    </div>
    <div class="statistics-box">
        <h5>Tổng số khách hàng</h5>
        <p><?php echo $total_customers; ?></p>
    </div>
    <div class="statistics-box">
        <h5>Tổng số dịch vụ</h5>
        <p><?php echo $total_services; ?></p>
    </div>
    <div class="statistics-box">
        <h5>Tổng số tin tức</h5>
        <p><?php echo $total_news; ?></p>
    </div>
</div>

<div class="statistics db">
    <h2>Số lượng tin tức theo danh mục</h2>
    <ul>
        <?php foreach ($news_by_category as $news) {
            echo "<li>{$news->category_title}: {$news->count}</li>";
        } ?>
    </ul>

    <h2>Số lượng dự án theo danh mục</h2>
    <ul>
        <?php foreach ($projects_by_category as $project) {
            echo "<li>{$project->category_title}: {$project->count}</li>";
        } ?>
    </ul>
</div>
