<?php
/*
Template Name: chi tiết tin tức
*/
get_header();
?>
<?php
global $wpdb;
$news_table = 'news';
$news_category_table = 'news_category';

// Lấy dữ liệu tin tức từ cơ sở dữ liệu
$news_id = isset($_GET['news_id']) ? intval($_GET['news_id']) : 0; // ID của tin tức
$query = $wpdb->prepare("SELECT n.*, nc.category_title, nc.Icon FROM $news_table AS n INNER JOIN $news_category_table AS nc ON n.News_Category_id = nc.Id WHERE n.Id = %d", $news_id);
$news_data = $wpdb->get_row($query);

if (!$news_data) {
    echo "Không tìm thấy tin tức!";
    exit;
}

// Lấy tin tức ngẫu nhiên
$random_news = $wpdb->get_results("SELECT Id, Title, News_image FROM $news_table ORDER BY RAND() LIMIT 5");
?>
<head>
<style>
.article-inner, .form-container, .random-news-container {
  margin-bottom: 20px;
}
.image_single {
  max-width: 800px; /* Giới hạn kích thước chiều rộng */
  height: auto;
  margin: 0 auto;
}
.entry-header-text-top {
  position: relative;
  padding: 20px;
}
.entry-header-text-top .overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Điều chỉnh độ mờ tối ở đây */
  z-index: 1;
}
.entry-header-text-top .icon-wrapper {
  background-image: url('<?php echo $news_data->Icon; ?>');
  background-size: cover;
  background-position: center center;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  filter: brightness(1); /* Điều chỉnh độ sáng ở đây */
}
.entry-header-text-top h6,
.entry-header-text-top h1,
.entry-header-text-top .entry-divider {
  position: relative;
  z-index: 2;
  color: white;
}
.entry-category {
  color: white;
}
.entry-category:hover{
  color: coral;
}
.font-bold {
  color: #CDA460;
  font-size: x-large;
  font-weight: 500;
text-transform: uppercase;
}
</style>
</head>
<body>
<section id="breadcrumb" style="border-top: 1px solid #ececec;">
    <div class="container">
        <div class="row font-samiBold">
            <div class="col-md-12 col-xs-12 breadcrumb-submenu">
                <nav id="secondary-menu" class="nav">
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="banner-blog-detail">
</section>
<header class="entry-header">
  <div class="entry-header-text entry-header-text-top text-center">
    <div class="icon-wrapper"></div>
    <div class="overlay"></div>
    <h6 class="entry-category is-xsmall">
      <a class="entry-category" href="/kienhunggroup/demowordpress/danh-muc-tin-tuc/?category_id=<?php echo $news_data->News_Category_id; ?>" rel="category tag">
        <?php echo $news_data->category_title; ?></a>
    </h6>
    <h1 class="entry-title"><?php echo $news_data->Title; ?></h1>
    <div class="entry-divider is-divider small"></div>
  </div>
  <div class="entry-image relative">
    <div class="image_single mx-auto d-block">
      <img class="pt-4" src="<?php echo $news_data->News_image; ?>" class="wp-post-image" alt="<?php echo $news_data->Title; ?>" decoding="async" />
    </div>
  </div>
</header>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-sm-12 article-inner">
      <article id="post-<?php echo $news_data->Id; ?>" class="post-<?php echo $news_data->Id; ?> post type-post status-publish format-standard has-post-thumbnail hentry category-<?php echo sanitize_title($news_data->category_title); ?> tag-brooklyn tag-fashion tag-style-2 tag-women-3">
        <div class="entry-content single-page">
          <?php echo $news_data->Detail; ?>
        </div>
      </article>
    </div>
    <div class="col-md-4 col-sm-12">
      <div class="form-container">
        <div class="talk-to-design">
          <div class="title font-bold pt-3 pb-2">
            LIÊN HỆ VỚI CHÚNG TÔI
          </div>
          <div class="form">
    <form id="bookingForm">
        <input type="hidden" name="action" value="submit_booking_form">
        <input type="hidden" name="display_position" class="display_position" value="blog_detail">
        <div class="form-group">
            <input type="text" class="form-control name-booking" name="customer_name" placeholder="Họ & Tên của bạn" required>
            <div class="error nameError"></div>
        </div>
        <div class="form-group">
            <input type="email" class="form-control email-booking" name="customer_email" placeholder="Email của bạn" required>
            <div class="error emailError"></div>
        </div>
        <div class="form-group">
            <input type="text" class="form-control phone-booking" name="customer_phone" placeholder="Số điện thoại của bạn" required>
            <div class="error phoneError"></div>
        </div>
        <div class="form-group">
            <textarea class="form-control message-booking" name="customer_description" rows="3" placeholder="Lời nhắn của bạn" required></textarea>
        </div>
        <div class="form-group">
            <button class="btn-primary btn-tu-van btn-booking-talk font-samiBold" type="submit">Đặt lịch tư vấn</button>
        </div>
    </form>
    <div id="thankYouMessage" style="display:none;">
        <h3>Cảm ơn bạn đã đặt lịch tư vấn!</h3>
        <div id="fireworks"></div>
    </div>
</div>

        </div>
      </div>
      <div class="random-news-container">
        <h4 class="font-bold">Tin tức ngẫu nhiên</h4>
        <?php foreach ($random_news as $news) : ?>
        <div class="random-news-item">
          <div class="thumbnail">
            <a class="blog_link" href="/kienhunggroup/demowordpress/chi-tiet-tin-tuc/?news_id=<?php echo $news->Id; ?>">
              <img src="<?php echo $news->News_image; ?>" alt="<?php echo $news->Title; ?>">
            </a>
          </div>
          <div class="information">
            <div class="name-post">
              <a class="blog_link" href="/kienhunggroup/demowordpress/chi-tiet-tin-tuc/?news_id=<?php echo $news->Id; ?>">
                <?php echo $news->Title; ?>
              </a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<scrip src="https://cdnjs.cloudflare.com/ajax/libs/fireworks-js/2.3.4/fireworks.min.js"></script>

<script>
    jQuery(document).ready(function($) {
        $('#bookingForm').on('submit', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
                data: formData,
                success: function(response) {
                    if (response == 'success') {
                        $('#bookingForm').hide();
                        $('#thankYouMessage').show();
                        // Fireworks effect
                        const container = document.getElementById('fireworks');
                        const fireworks = new Fireworks.default(container, { /* options */ });
                        fireworks.start();

                        setTimeout(function() {
                            location.reload();
                        }, 50000); // 5 seconds delay before reloading the page
                    } else {
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                    }
                }
            });
        });
    });


</script>
<?php
get_footer();
?>
</body>
