<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

global $ti_option, $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Stick/Unstick Product Details
if ( $ti_option['smwc_product_page_slider'] == 'images_list' ) {
    $sticky_product_details = ' sticky-product-details';
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<?php
/**
 * Displays the product title Full Width
**/
if ( $ti_option['smwc_single_title_position'] == 'fullwidth' ) {
?>

<header class="wrapper entry-header page-header">
    <div class="page-title title-with-sep single-title single-title-full">
        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
    </div>
</header>
<?php } ?>

<article id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="grids single-product-columns">

        <div class="grid-7 column-1">
            <div class="single-product-image">

			<?php
				/**
				 * woocommerce_before_single_product_summary hook.
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
			?>

	        </div>
	    </div><!-- .column-1 -->

        <div class="grid-5 column-2<?php echo isset( $sticky_product_details ) ? $sticky_product_details : ''; ?>">
            <div class="single-product-details">

            <?php woocommerce_show_product_sale_flash(); ?>

            <?php
            /**
             * Displays the product title Above The Content
            **/
            if ( $ti_option['smwc_single_title_position'] == 'abovecontent' ) :
            ?>
            <div class="page-title single-title above-content-title">
                <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
            </div>
            <?php endif ?>

			<?php
				/**
				 * woocommerce_single_product_summary hook.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>

            </div><!-- .single-product-details -->
        </div><!-- .column-2 -->

    </div><!-- .grids -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		//do_action( 'woocommerce_after_single_product_summary' );
		woocommerce_output_product_data_tabs();
	?>

    <div class="tab-box related-posts-tabs">

        <ul class="tab-box-button clearfix">

            <li><a href="#related-posts"><?php _e( 'Related Products', 'woocommerce' ); ?></a></li>

            <?php // Hide the button if there no upsells products
            $upsells = $product->get_upsell_ids();

            if (count($upsells) > 0) { ?>
                <li><a href="#upsell-posts"><?php _e( 'You may be interested in&hellip;', 'woocommerce' ); ?></a></li>
            <?php } ?>

        </ul>

        <div class="tab-box-content">
            <div id="related-posts">
                <?php woocommerce_output_related_products(); ?>
            </div>
            <div id="upsell-posts">
                <?php woocommerce_upsell_display(); ?>
            </div>
        </div>

    </div>

    <?php //get_template_part( 'woocommerce/inc/product', 'nav' ); ?>

</article><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
