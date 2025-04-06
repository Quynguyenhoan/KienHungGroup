<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see              https://docs.woocommerce.com/document/template-structure/
 * @package          WooCommerce\Templates
 * @version          7.0.1
 * @flatsome-version 3.16.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="flex-row relative">
        <?php
        $placeholder = __( 'Search', 'woocommerce' ) . '&hellip;';
        if ( get_theme_mod( 'search_placeholder' ) ) {
            $placeholder = get_theme_mod( 'search_placeholder' );
        }
        ?>
        <div class="flex-col flex-grow">
            <label class="screen-reader-text" for="search-field"><?php esc_html_e( 'Search for:', 'woocommerce' ); ?></label>
            <input type="search" id="search-field" class="search-field mb-0" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
            <input type="hidden" name="post_type" value="product" />
        </div>
        <div class="flex-col">
            <button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>" class="ux-search-submit submit-button secondary button <?php if ( function_exists( 'wc_wp_theme_get_element_class_name' ) ) {
                echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) );
            } ?> icon mb-0" aria-label="<?php esc_attr_e( 'Submit', 'flatsome' ); ?>">
                <?php echo get_flatsome_icon( 'icon-search' ); ?>
            </button>
        </div>
    </div>
    <div class="live-search-results text-left z-top"></div>
</form>
