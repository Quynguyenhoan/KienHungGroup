<?php
/*Sale price by devvn - levantoan.com*/
function devvn_price_html($product, $is_variation = false){
    ob_start();
 
    if($product->is_on_sale()):
    ?>
    <style>
        .devvn_single_price {
            background-color: #199bc42e;
            border: 1px dashed #199bc4;
            padding: 10px;
            border-radius: 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            margin: 0 0 10px;
            color: #000;
        }
 
        .devvn_single_price span.devvn_price .amount {
            font-size: 14px;
            font-weight: 700;
            color: #ff3a3a;
        }
 
        .devvn_single_price span.devvn_price del .amount, .devvn_single_price span.devvn_price del {
            font-size: 14px;
            color: #333;
            font-weight: 400;
        }
      .onsale {
        visibility: hidden;
      }
      .badge-container
{
display:none;
}
    </style>
    <?php
    endif;
 
    if($product->is_on_sale() && ($is_variation || $product->is_type('simple') || $product->is_type('external'))) {
        $sale_price = $product->get_sale_price();
        $regular_price = $product->get_regular_price();
        if($regular_price) {
            $sale = round(((floatval($regular_price) - floatval($sale_price)) / floatval($regular_price)) * 100);
            $sale_amout = $regular_price - $sale_price;
            ?>
            <div class="devvn_single_price">
                <div>
                    <span class="label">Giá:</span>
                    <span class="devvn_price"><?php echo wc_price($sale_price); ?></span>
                </div>
                <div>
                    <span class="label">Thị trường:</span>
                    <span class="devvn_price"><del><?php echo wc_price($regular_price); ?></del></span>
                </div>
                <div>
                    <span class="label">Tiết kiệm:</span>
                    <span class="devvn_price sale_amount"> <?php echo wc_price($sale_amout); ?> (<?php echo $sale; ?>%)</span>
                </div>
            </div>
            <?php
        }
    }elseif($product->is_on_sale() && $product->is_type('variable')){
        $prices = $product->get_variation_prices( true );
        if ( empty( $prices['price'] ) ) {
            $price = apply_filters( 'woocommerce_variable_empty_price_html', '', $product );
        } else {
            $min_price     = current( $prices['price'] );
            $max_price     = end( $prices['price'] );
            $min_reg_price = current( $prices['regular_price'] );
            $max_reg_price = end( $prices['regular_price'] );
 
            if ( $min_price !== $max_price ) {
                $price = wc_format_price_range( $min_price, $max_price ) . $product->get_price_suffix();
            } elseif ( $product->is_on_sale() && $min_reg_price === $max_reg_price ) {
                $sale = round(((floatval($max_reg_price) - floatval($min_price)) / floatval($max_reg_price)) * 100);
                $sale_amout = $max_reg_price - $min_price;
                ?>
                <div class="devvn_single_price">
                    <div>
                        <span class="label">Giá:</span>
                        <span class="devvn_price"><?php echo wc_price($min_price); ?></span>
                    </div>
                    <div>
                        <span class="label">Thị trường:</span>
                        <span class="devvn_price"><del><?php echo wc_price($max_reg_price); ?></del></span>
                    </div>
                    <div>
                        <span class="label">Tiết kiệm:</span>
                        <span class="devvn_price sale_amount"> <?php echo wc_price($sale_amout); ?> (<?php echo $sale; ?>%)</span>
                    </div>
                </div>
                <?php
            } else {
                $price = wc_price( $min_price ) . $product->get_price_suffix();
            }
        }
        echo $price;
 
    }else{ ?>
        <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) );?>"><?php echo $product->get_price_html(); ?></p>
    <?php }
    return ob_get_clean();
}
function woocommerce_template_single_price(){
    global $product;
    echo devvn_price_html($product);
}
 
add_filter('woocommerce_available_variation','devvn_woocommerce_available_variation', 10, 3);
function devvn_woocommerce_available_variation($args, $thisC, $variation){
    $old_price_html = $args['price_html'];
    if($old_price_html){
        $args['price_html'] = devvn_price_html($variation, true);
    }
    return $args;
}
// Bỏ Quick view
function my_custom_translations( $strings ) {

    $text = array(
    
    'Quick View' => 'Xem nhanh'
    
    );
    
    $strings = str_ireplace( array_keys( $text ), $text, $strings );
    
    return $strings;
    
    }
    
    add_filter( 'gettext', 'my_custom_translations', 20 );
//Remove Sale Label on Products

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
// Tắt thông báo "Cảm ơn bạn đã khởi tạo WordPress"
remove_action('welcome_panel', 'wp_welcome_panel');
add_filter('woocommerce_cart_needs_shipping_address', '__return_false');
add_filter('woocommerce_checkout_fields', 'vutruso_remove_shipping_address');

function vutruso_remove_shipping_address($fields) {
    unset($fields['shipping']);
    return $fields;
}
// Tạo shortcode để chèn mã PHP tùy chỉnh
function my_custom_php_shortcode() {
    ob_start();
    // Thêm mã PHP tùy chỉnh của bạn ở đây
    echo 'Đây là nội dung PHP tùy chỉnh của tôi!';
    return ob_get_clean();
}
add_shortcode('custom_php', 'my_custom_php_shortcode');
// LOAd web

function handle_booking_form_submission() {
    if (isset($_POST['customer_name'], $_POST['customer_email'], $_POST['customer_phone'], $_POST['customer_description'])) {
        global $wpdb;

        $table_name = 'customer';
        $customer_name = sanitize_text_field($_POST['customer_name']);
        $customer_email = sanitize_email($_POST['customer_email']);
        $customer_phone = sanitize_text_field($_POST['customer_phone']);
        $customer_description = sanitize_textarea_field($_POST['customer_description']);

        $data = array(
            'Customer_Name' => $customer_name,
            'Customer_Email' => $customer_email,
            'Customer_Phone' => $customer_phone,
            'Customer_description' => $customer_description,
            'Customer_IsRead' => 0,
            'IsFromContact' => 1,
            'CreatedBy' => 'system',
            'Modifiedby' => 'system',
            'CreatedDate' => current_time('mysql'),
            'ModifiedDate' => current_time('mysql')
        );

        $format = array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%s',
            '%s',
            '%s',
            '%s'
        );

        $wpdb->insert($table_name, $data, $format);

        echo 'success';
        wp_die();
    } else {
        echo 'error';
        wp_die();
    }
}
add_action('wp_ajax_nopriv_submit_booking_form', 'handle_booking_form_submission');
add_action('wp_ajax_submit_booking_form', 'handle_booking_form_submission');

// Danh mục dự án
function display_project_categories() {
    global $wpdb;

    // Lấy danh sách danh mục từ bảng project_category
    $project_category_table = 'project_category';
    $categories = $wpdb->get_results("SELECT * FROM $project_category_table WHERE parent_category_id IS NOT NULL");

    // Kiểm tra lỗi
    if ($wpdb->last_error) {
        return "Lỗi: " . $wpdb->last_error;
    }

    ob_start();
    ?>
    <div class="project-categories">
    <div class="container section-title-container" ><h3 class="section-title section-title-center"><b></b><span class="section-title-main" >Danh mục dự án</span><b></b></h3></div>
        <ul id="project-category-list">
            <?php foreach ($categories as $category) : ?>
                <li class="project-category-item" data-category-id="<?php echo $category->Id; ?>">
                    <a href="#"><?php echo $category->Title; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="container">
        <h5 class="section-title section-title-center">
            <b></b><span class="section-title-main" style="font-size:undefined%;">Danh sách Dự án</span><b></b>
        </h5>
    </div>

    <div id="row-project" class="row row-cols-1 row-cols-sm-2 row-cols-lg-2 g-3">
        <?php
        $project_table ='project';
        $project_data = $wpdb->get_results("SELECT * FROM $project_table");

        if ($wpdb->last_error) {
            echo "Lỗi: " . $wpdb->last_error;
        }

        foreach ($project_data as $project) :
        ?>
        <div class="col post-item project-item" data-category="<?php echo $project->ProjectCategory_id; ?>">
            <div class="col-inner">
                <a href="/kienhunggroup/demowordpress/chi-tiet-du-an/?project_id=<?php echo $project->Id; ?>" class="plain project-link">
                    <div class="hover hover-1 text-white rounded">
                        <img src="<?php echo $project->project_image_c; ?>" alt="<?php echo $project->TenDuAn; ?>">
                        <div class="hover-overlay"></div>
                        <div class="hover-1-content px-5 py-4">
                            <h3 class="hover-1-title text-uppercase font-weight-bold mb-0">
                                <span class="font-weight-light"><?php echo $project->TenDuAn; ?></span>
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <style>
    /* CSS của bạn ở đây */
    .project-categories {
        text-align: center;
        margin-bottom: 20px;
    }

    #project-category-list {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 0;
        list-style: none;
    }

    .project-category-item {
        background-color: #FBAE3C;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .project-category-item a {
        color: white;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    .project-category-item:hover {
        background-color: #F1C378;
    }

    .project-category-item a:hover {
        color: #FFD966;
    }

    .project-category-item a.active {
        background-color: #F1C378;
        color: #FFD966;
    }

    /* Additional CSS for project layout */
    .col-inner {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        padding: 10px;
    }

    .hover-1 img {
        width: 105%;
        position: absolute;
        top: 0;
        left: -5%;
        transition: all 0.3s;
        border-radius: 10px;
    }

    .hover-1-content {
        position: absolute;
        bottom: 0;
        left: 0;
        z-index: 99;
        transition: all 0.4s;
        padding: 0 5px;
    }

    .hover-1 .hover-overlay {
        background: rgba(0, 0, 0, 0.5);
        transition: opacity 0.5s;
    }

    .hover-1:hover .hover-1-content {
        bottom: 2rem;
    }

    .hover-1:hover .hover-1-description {
        opacity: 0.6s;
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

    .hover-content {
        position: relative;
        z-index: 99;
    }

    .hover-1-content {
        position: absolute;
        bottom: 0;
        left: 0;
        z-index: 99;
        transition: all 0.4s;
        padding: 0 5px;
    }
    .hover-1-content .font-weight-light {
    color: #FFFFFF; 
}

</style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryItems = document.querySelectorAll('.project-category-item');
        const projectItems = document.querySelectorAll('.project-item');

        categoryItems.forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const categoryId = this.getAttribute('data-category-id');

                // Ẩn tất cả các dự án
                projectItems.forEach(project => {
                    project.classList.add('hidden');
                });

                // Hiển thị các dự án thuộc danh mục được chọn
                const selectedProjects = document.querySelectorAll('.project-item[data-category="' + categoryId + '"]');
                selectedProjects.forEach(project => {
                    project.classList.remove('hidden');
                });
            });
        });
    });
    </script>

    <?php
    return ob_get_clean();
}


add_shortcode('project_categories', 'display_project_categories');

// Dự án nổi bật 
function hot_projects_shortcode() {
    global $wpdb;
    $project_table ='project';
    
    // Lấy thông tin các dự án nổi bật (IS_Hot = 1)
    $hot_projects = $wpdb->get_results("SELECT * FROM $project_table WHERE IS_Hot = 1");

    if (!$hot_projects) {
        return '<p>Không có dự án nổi bật.</p>';
    }

    ob_start();
    ?>
    <div class="container section-title-container">
        <h3 class="section-title section-title-center">
            <b></b><span class="section-title-main" style="font-size:undefined%;">Dự án nổi bật</span><b></b>
        </h3>
    </div>

    <div class="row large-columns-4 medium-columns-3 small-columns-1 slider row-slider slider-nav-reveal slider-nav-light slider-nav-push"  data-flickity-options='{"imagesLoaded": true, "groupCells": "100%", "dragThreshold" : 5, "cellAlign": "left","wrapAround": true,"prevNextButtons": true,"percentPosition": true,"pageDots": false, "rightToLeft": false, "autoPlay" : 3000}' >
        <?php foreach ($hot_projects as $project) : ?>
            <div class="col post-item" data-id="<?php echo $project->Id; ?>" data-title="<?php echo htmlspecialchars($project->TenDuAn); ?>" data-image="<?php echo $project->project_image_c; ?>" data-category="<?php echo $project->ProjectCategory_id; ?>" data-parent-category="<?php echo $project->parent_category_id; ?>" data-created-date="<?php echo $project->CreatedDate; ?>">
                <div class="col-inner">
                    <a href="/kienhunggroup/demowordpress/chi-tiet-du-an/?project_id=<?php echo $project->Id; ?>" class="plain project-link">
                        <div class="hover hover-1 text-white rounded">
                            <img src="<?php echo $project->project_image_c; ?>" alt="<?php echo $project->TenDuAn; ?>">
                            <div class="hover-overlay"></div>
                            <div class="hover-1-content px-5 py-4">
                                <h3 class="hover-1-title text-uppercase font-weight-bold mb-0">
                                    <span class="font-weight-light"><?php echo $project->TenDuAn; ?></span>
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('hot_projects', 'hot_projects_shortcode');
