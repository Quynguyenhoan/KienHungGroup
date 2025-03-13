<?php
/* Template Name: Danh Mục Tin Tức */

get_header();

global $wpdb;
$news_table = 'news';
$news_category_table = 'news_category';

// Lấy ID danh mục từ URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Truy vấn dữ liệu tin tức thuộc danh mục cụ thể
$query = $wpdb->prepare("SELECT * FROM $news_table WHERE News_Category_id = %d AND IsActive = 1", $category_id);
$news_data = $wpdb->get_results($query);

if ($wpdb->last_error) {
    echo "Lỗi: " . $wpdb->last_error;
}

// Lấy thông tin danh mục
$category_title_query = $wpdb->prepare("SELECT category_title, Icon FROM $news_category_table WHERE Id = %d", $category_id);
$category_info = $wpdb->get_row($category_title_query);
?>
<head>
<style>
    .news-category-page {
        padding: 20px;
    }

    .news-category-title-wrapper {
        text-align: center;
        margin-bottom: 30px;
        position: relative;
        padding: 20px;
    }

    .news-category-title-wrapper .icon-wrapper {
        background-image: url('<?php echo $category_info->Icon; ?>');
        background-position: center center;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        filter: brightness(0.8);
    }

    .news-category-title {
        font-size: 2.5em;
        font-weight: bold;
        color: #fff;
        position: relative;
        z-index: 1;
    }

    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .news-item {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        position: relative;
    }

    .news-item:hover {
        transform: translateY(-10px);
    }

    .news-item img {
        width: 100%;
        height: auto;
        display: block;
    }

    .news-item-content {
        padding: 15px;
    }

    .news-item-title {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: #333;
    }

    .news-item-description {
        font-size: 1em;
        color: #666;
        margin-bottom: 15px;
    }

    .news-item-date {
        font-size: 0.9em;
        color: #999;
    }

    .news-item-date span {
        display: block;
    }

    @media (max-width: 600px) {
        .news-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
</head>

<div class="news-category-page">
    <div class="news-category-title-wrapper">
        <div class="icon-wrapper"></div>
        <h1 class="news-category-title"><?php echo $category_info->category_title; ?></h1>
    </div>
    <div class="news-grid">
        <?php if (!empty($news_data)): ?>
            <?php foreach ($news_data as $news) : ?>
                <div class="news-item">
                    <a href="/kienhunggroup/demowordpress/chi-tiet-tin-tuc/?news_id=<?php echo $news->Id; ?>">
                        <img src="<?php echo $news->News_image; ?>" alt="<?php echo $news->Title; ?>">
                        <div class="news-item-content">
                            <h2 class="news-item-title"><?php echo $news->Title; ?></h2>
                            <p class="news-item-description"><?php echo wp_trim_words($news->News_Description, 20, '...'); ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có tin tức trong danh mục này.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
