<?php
/* Template Name: Chi tiết dự án*/

get_header();

if (!isset($_GET['project_id'])) {
    echo '<p>Không tìm thấy dự án. Vui lòng kiểm tra lại.</p>';
    get_footer();
    exit;
}

global $wpdb;
$project_id = intval($_GET['project_id']);

// Lấy thông tin dự án từ bảng project
$project_table = 'project';
$project = $wpdb->get_row($wpdb->prepare("SELECT * FROM $project_table WHERE Id = %d", $project_id));

if (!$project) {
    echo '<p>Không tìm thấy dự án. Vui lòng kiểm tra lại.</p>';
    get_footer();
    exit;
}

// Lấy hình ảnh của dự án từ bảng project_image
$project_image_table ='project_image';
$project_images = $wpdb->get_results($wpdb->prepare("SELECT * FROM $project_image_table WHERE Project_id = %d", $project_id));

// Lấy hai dự án ngẫu nhiên
$random_projects = $wpdb->get_results("SELECT * FROM $project_table WHERE Id != $project_id ORDER BY RAND() LIMIT 2");

// Lấy hai tin tức ngẫu nhiên
$news_table = 'news';
$random_news = $wpdb->get_results("SELECT * FROM $news_table ORDER BY RAND() LIMIT 2");
?>

<style>
.carousel-item img {
    width: 100%;
    height: 400px; /* Set the desired height */
    object-fit: cover; /* Ensures the image covers the area without distortion */
}

.random-projects-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    margin-bottom: 60px;
}

.random-projects-navigation .btn {
    width: 45%;
}

.random-news {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.random-news .news-item {
    width: 45%;
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}
/* Danh mục dự án */
        a{
            text-decoration: none;
        }
       .col-inner a {
            text-decoration: none;
        }

.hover-1 img {
    width: 105%;
    position: absolute;
    top: 0;
    left: -5%;
    transition: all 0.3s;
    border-radius: 10px;
}


.hover-1 .hover-overlay {
    background: rgba(0, 0, 0, 0.5);
    transition: opacity 0.4s;
}

.hover-1:hover .hover-1-content {
    bottom: 2rem;
}

.hover-1:hover .hover-1-description {
    opacity: 1;
    transform: none;
}

.hover-1:hover img {
    left: 0;
}

.hover-1:hover .hover-overlay {
    opacity: 0;
}

.hover {
    overflow: hidden;
    position: relative;
    padding-bottom: 60%;
}

.hover-overlay {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 90;
    transition: all 0.4s;
}

.hover img {
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    transition: all 0.3s;
    border-radius: 10px;
}

.hover-1-content {
    position: absolute;
    bottom: 0;
    left: 0;
    z-index: 99;
    transition: all 0.4s;
    padding: 0 5px; /* Thêm khoảng cách giữa nội dung và ảnh */
    color: #fff; /* Màu chữ sáng */
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); /* Hiệu ứng bóng chữ */
}
 
    .hover-1-title {
    font-size: 1.5em;
    font-weight: bold;
    color: #fff; /* Màu chữ sáng */
    text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); /* Hiệu ứng bóng chữ */
}
</style>

<div class="project-details container">
    <?php if (!empty($project_images)) : ?>
        <div id="projectCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($project_images as $index => $image) : ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="<?php echo $image->Project_Image_n; ?>" alt="Project Image">
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#projectCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Trước</span>
            </a>
            <a class="carousel-control-next" href="#projectCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Sau</span>
            </a>
        </div>
    <?php else : ?>
        <p>Không có hình ảnh cho dự án này.</p>
    <?php endif; ?>
    <h2><?php echo htmlspecialchars($project->TenDuAn); ?></h2>
    <p><?php echo nl2br($project->Project_Description); ?></p>

    <!-- Nút chuyển dự án ngẫu nhiên -->
    <?php if (count($random_projects) == 2) : ?>
        <div class="random-projects-navigation">
            <a href="/kienhunggroup/demowordpress/chi-tiet-du-an/?project_id=<?php echo $random_projects[0]->Id; ?>" class="btn btn-outline-warning">
                &larr; <?php echo htmlspecialchars($random_projects[0]->TenDuAn); ?>
            </a>
            <a href="/kienhunggroup/demowordpress/chi-tiet-du-an/?project_id=<?php echo $random_projects[1]->Id; ?>" class="btn btn-outline-warning">
                <?php echo htmlspecialchars($random_projects[1]->TenDuAn); ?> &rarr;
            </a>
        </div>
    <?php endif; ?>

    <!-- Carousel hiển thị dự án cùng danh mục -->
    <?php
    $related_projects = $wpdb->get_results($wpdb->prepare("SELECT * FROM $project_table WHERE ProjectCategory_id = %d AND Id != %d", $project->ProjectCategory_id, $project->Id));
    if ($related_projects) :
    ?>
        <div class="container section-title-container">
            <h3 class="section-title section-title-center">
                <b></b><span class="section-title-main" style="font-size:undefined%;">Dự án cùng danh mục</span><b></b>
            </h3>
        </div>

        <div class="row large-columns-4 medium-columns-3 small-columns-1 slider row-slider slider-nav-reveal slider-nav-light slider-nav-push" data-flickity-options='{"imagesLoaded": true, "groupCells": "100%", "dragThreshold" : 5, "cellAlign": "left","wrapAround": true,"prevNextButtons": true,"percentPosition": true,"pageDots": false, "rightToLeft": false, "autoPlay" : 3000}'>
            <?php foreach ($related_projects as $related_project) : ?>
                <div class="col post-item">
                    <div class="col-inner">
                        <a href="/kienhunggroup/demowordpress/chi-tiet-du-an/?project_id=<?php echo $related_project->Id; ?>" class="plain project-link">
                            <div class="hover hover-1 text-white rounded">
                                <img src="<?php echo $related_project->project_image_c; ?>" alt="<?php echo $related_project->TenDuAn; ?>">
                                <div class="hover-overlay"></div>
                                <div class="hover-1-content px-5 py-4">
                                    <h3 class="hover-1-title text-uppercase font-weight-bold mb-0">
                                        <span class="font-weight-light"><?php echo $related_project->TenDuAn; ?></span>
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();
?>
