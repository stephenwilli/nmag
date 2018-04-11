<?php
/**
 * The template for displaying the footer.
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.0
**/

/* The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if (   ! is_active_sidebar( 'sidebar-3' ) // Footer Area One
	&& ! is_active_sidebar( 'sidebar-4' ) // Footer Area Two
	&& ! is_active_sidebar( 'sidebar-5' ) // Footer Area Three
    && ! is_active_sidebar( 'sidebar-full-width' ) // Full Width Footer
)
	return;
// If we get this far, we have widgets. Let do this.


global $ti_option;


/**
 * Footer full width sidebar
 * can be used to display Instagram feeds
**/
if ( is_active_sidebar( 'sidebar-full-width' ) ) : ?>
    <div class="full-width-sidebar">
        <?php
        if ( $ti_option['full_width_widget'] == 1 ) :
            dynamic_sidebar( 'sidebar-full-width' );
        else :
        ?>
            <div class="wrapper">
                <?php dynamic_sidebar( 'sidebar-full-width' ); ?>
            </div>
        <?php
        endif; 
        ?>
    </div><!-- Full Width Sidebar -->
<?php endif; ?>


<?php 
/**
 * Top Border for footer if bg is white
**/
$footer_bg = $ti_option['footer_color'];
$footer_border = $ti_option['footer_border']['border-top'];

if ( $footer_bg == '#ffffff' && $footer_border != '0px' ) :
    $top_border = sanitize_html_class( 'footer-border-top' );
elseif ( $footer_bg == '#ffffff' && $footer_border == '0px' ) :
    $top_border = sanitize_html_class( 'footer-border-top-gray' );
else :
    $top_border = '';
endif;
?>

<div class="footer-sidebar <?php echo $top_border; ?>">
    <div id="supplementary" class="wrapper clearfix columns<?php ti_footer_sidebar_class(); ?>">
        <?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
        <div class="widget-area widget-area-1" role="complementary">
            <?php dynamic_sidebar( 'sidebar-3' ); ?>
        </div><!-- #first .widget-area -->
        <?php endif; ?>
    
        <?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
        <div class="widget-area widget-area-2" role="complementary">
            <?php dynamic_sidebar( 'sidebar-4' ); ?>
        </div><!-- #second .widget-area -->
        <?php endif; ?>
    
        <?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
        <div class="widget-area widget-area-3" role="complementary">
            <?php dynamic_sidebar( 'sidebar-5' ); ?>
        </div><!-- #third .widget-area -->
        <?php endif; ?>
    </div><!-- #supplementary -->
</div>