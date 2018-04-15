<?php
/**
 * The template for displaying the footer.
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.1
**/
global $ti_option;
?>

        <footer id="footer" class="no-print animated" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

        	<?php if ( $ti_option['footer_image_ad']['url'] == true || ! empty ( $ti_option['footer_code_ad'] ) ) { ?>
            <div class="advertisement">
                <div class="wrapper">
        			<?php
                    $footer_ad = $ti_option['footer_image_ad'];
                    // Image Ad
                    if ( $footer_ad['url'] == true ) { ?>
                        <a href="<?php echo $footer_ad['url']; ?>" rel="nofollow" target="_blank">
                            <img src="<?php echo $footer_ad['url']; ?>" width="<?php echo $footer_ad['width']; ?>" height="<?php echo $footer_ad['height']; ?>" alt="<?php _e( 'Advertisement', 'themetext' ); ?>" />
                        </a>
                    <?php 
        			// Code Ad
                    } elseif( $ti_option['footer_code_ad'] == true ) {
                        echo $ti_option['footer_code_ad'];
                    } ?>
                </div>
            </div><!-- .advertisment -->
            <?php } ?>

            <?php get_sidebar( 'footer' ); // Output the footer sidebars ?>

            <div class="copyright">
                <div class="wrapper">
                	<div class="grids">
                        <div class="grid-10">
                        </div>
                        <div class="grid-2">
                            <a href="#" class="back-top"><?php _e( 'Back to top', 'themetext' ); ?> <i class="icomoon-chevron-up"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
        </footer><!-- #footer -->
    </div><!-- .site-content -->
</section><!-- #site -->
<?php wp_footer(); ?>
</body>
</html>