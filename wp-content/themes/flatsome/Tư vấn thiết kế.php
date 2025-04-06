<?php
/*
Template Name: Dịch vụ
*/

get_header(); // Gọi header của theme

global $wpdb; // Sử dụng biến $wpdb toàn cục của WordPress để truy vấn cơ sở dữ liệu

// Lấy tiêu đề trang hiện tại
$page_title = get_the_title();

// Truy vấn dịch vụ dựa trên tiêu đề trang
$service = $wpdb->get_row($wpdb->prepare("SELECT * FROM service WHERE Title = %s", $page_title));

if ($service) {
    ?>
    <div class="page-title blog-featured-title featured-title no-overflow">
        <div class="page-title-bg fill">
            <div class="title-bg fill bg-fill bg-top" style="background-image: url('<?php echo esc_url($service->Image_URL); ?>');" data-parallax-fade="true" data-parallax="-2" data-parallax-background data-parallax-container=".page-title"></div>
            <div class="title-overlay fill" style="background-color: rgba(0,0,0,.5)"></div>
        </div>

        <div class="page-title-inner container flex-row dark is-large" style="min-height: 300px">
            <div class="flex-col flex-center text-center">
                <h1 class="entry-title"><?php echo esc_html($service->Title); ?></h1>
                <div class="entry-divider is-divider small"></div>
            </div>
        </div>
    </div>

    <main id="main">
        <div id="content" class="blog-wrapper blog-single page-wrapper">
            <div class="row align-center">
                <div class="large-10 col">
                    <article id="post-<?php echo esc_attr($service->Id); ?>" class="post-<?php echo esc_attr($service->Id); ?> post type-post status-publish format-standard has-post-thumbnail hentry category-mau">
                        <div class="article-inner">
                            <div class=" single-page">
                                <p><?php echo $service->service_Description; ?></p>
                                <div class="blog-share text-center">
                                    <div class="is-divider medium"></div>
                                    <div class="social-icons share-icons share-row relative"></div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </main>
    <?php
} else {
    echo "<p>Không có dịch vụ nào.</p>";
}

get_footer(); // Gọi footer của theme
?>
