<?php
/**
 * Page loader.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

$color = get_theme_mod('site_loader_color');
$bg_color = get_theme_mod('site_loader_bg');

if(empty($bg_color) && $color == 'dark'){
	$bg_color = get_theme_mod('color_primary', Flatsome_Default::COLOR_PRIMARY );
} else if(empty($bg_color)){
	$bg_color = '#fff';
}

?>
<div class="page-loader fixed fill z-top-3 <?php if($color == 'dark') echo 'nav-dark dark'; ?>">
	<div class="page-loader-inner x50 y50 md-y50 md-x50 lg-y50 lg-x50 absolute">
		<div class="page-loader-logo" style="padding-bottom: 30px;">
	    	<?php get_template_part('template-parts/header/partials/element','logo'); ?>
	    </div>
		<div class="page-loader-quote"><span id="quote"></span></div>
		<div class="page-loader-spin"><div class="loading-spin"></div></div>
	</div>
	<style>
		.page-loader{opacity: 0; transition: opacity .3s; transition-delay: .3s;
			background-color: <?php echo $bg_color; ?>;
		}
		.loading-site .page-loader{opacity: .98;}
		.page-loader-logo{max-width: <?php echo get_theme_mod('logo_width', 200); ?>px; animation: pageLoadZoom 1.3s ease-out; -webkit-animation: pageLoadZoom 1.3s ease-out;}
		.page-loader-quote { font-size: 24px; font-weight: bold; color: #333; text-align: center; padding-top: 20px; }
		.page-loader-spin{animation: pageLoadZoomSpin 1.3s ease-out;}
		.page-loader-spin .loading-spin{width: 40px; height: 40px; }
		@keyframes pageLoadZoom {
		    0%   {opacity:0; transform: translateY(30px);}
		    100% {opacity:1; transform: translateY(0);}
		}
		@keyframes pageLoadZoomSpin {
		    0%   {opacity:0; transform: translateY(60px);}
		    100% {opacity:1; transform: translateY(0);}
		}
	</style>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Danh sách các câu châm ngôn
    const quotes = [
        "Tô điểm thế giới bên trong ngôi nhà của bạn",
        "Kiểu dáng làm cho đôi mắt của bạn lấp lánh",
        "Đó là sự khác biệt, là duy nhất",
        "Tạo không gian, có thể sống được",
        "Đột phá ý tưởng - Tạo nên đẳng cấp",
        "Khi muốn thay đổi suy nghĩ, hãy thử thay đổi không gian sống",
        "Tạo nên không gian tuyệt đẹp trong tổ ấm của bạn",
        "Nghệ thuật và chất lượng góp phần tạo nên không gian lý tưởng",
        "Mở cánh cửa của sự đẹp trong mỗi không gian",
        "Tạo nên không gian sống độc đáo - Nơi bạn thể hiện chính mình",
        "Giải pháp mà bạn đã mơ ước",
        "Đổi mới bạn, đổi mới ngôi nhà của bạn",
        "Suy nghĩ, Thiết kế, Xây dựng",
        "Nội thất tạo ra cảm giác ấm cúng và thoải mái",
        "Đưa bạn tới một không gian sống tuyệt vời",
    ];

    // Chọn ngẫu nhiên một câu châm ngôn
    const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];

    // Hiển thị câu châm ngôn ngẫu nhiên
    document.getElementById("quote").textContent = randomQuote;

    // Khi trang web đã tải xong, xóa lớp "loading-site" khỏi body và ẩn câu châm ngôn động
    document.body.classList.remove("loading-site");
    document.querySelector('.page-loader').style.display = 'none';
});
</script>
