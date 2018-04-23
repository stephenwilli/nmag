<?php
/**
 * Custom Slider
 * Page Composer Section
 *
 * @package SimpleMag
 * @since   SimpleMag 2.0
**/


/**
 * Section styling based on field selection:
 * White, Black or Tint
**/
$section_style = get_sub_field( 'custom_slider_style' );

if ( $section_style == 'custom_bg_white' ) :
    $section_style_class = 'content-over-image-white';
elseif ( $section_style == 'custom_bg_black' ) :
     $section_style_class = 'content-over-image-black';
else :
    $section_style_class = 'content-over-image-tint';
endif;

// Full Width option is selected
$full_width_slider = get_sub_field ( 'custom_slider_type' ) == 'custom_slider_full';

// With two posts option is selected
$with_two_posts = get_sub_field ( 'custom_slider_type' ) == 'custom_slider_with_two';
?>

<?php if ( $with_two_posts ) : ?>
<div class="slider-latest">
    <div class="grids">
<?php endif; ?>

    <?php if( have_rows( 'custom_add_new_slide' ) ) : ?>

            <?php if ( $with_two_posts ) : ?>
            <div class="grid-8 columns column-1">
            <?php endif; ?>

                <div class="global-sliders content-over-image posts-slider <?php echo sanitize_html_class( $section_style_class ); ?>">

                    <?php while( have_rows( 'custom_add_new_slide' ) ) : the_row(); ?>

                        <div>

                            <?php
                            if ( get_sub_field( 'custom_slide_image' ) ) {

                                // Get image size from the image upload
                                $attachment_id = get_sub_field( 'custom_slide_image' );

                                // If Full Width option selected load original image size
                                if ( $full_width_slider ) {
                                    $slide_image_size = '';
                                } else {
                                    $slide_image_size = 'big-size';
                                }

                                // Get image src
                                $custom_slide_image_src = wp_get_attachment_image_src( $attachment_id, $slide_image_size );

                                // Set image src as a background
                                $custom_slide_bg_image = 'style="background-image:url(' . esc_url( $custom_slide_image_src[0] ) . ');"';
                            ?>

                                <?php
                                /**
                                 * Slider "Full Width" option is slected
                                 * Slide image is being added as a background
                                **/
                                if ( $full_width_slider ) : ?>
                                    <div class="entry-image full-width-slider-image" <?php echo isset( $custom_slide_bg_image ) ? $custom_slide_bg_image : ''; ?>></div>
                                <?php
                                /**
                                 * Slider "Regular" option is slected
                                 * Slide image is being added as an image tag
                                **/
                                else :
                                ?>
                                    <figure class="entry-image">
                                        <img src="<?php echo esc_url( $custom_slide_image_src[0] ); ?>" alt="<?php the_sub_field( 'custom_slide_title' ); ?>" />
                                    </figure>
                                <?php endif ?>

                            <?php } else { ?>

                                <img class="alter" src="<?php echo get_template_directory_uri(); ?>/images/pixel.gif" alt="<?php the_sub_field( 'custom_slide_title' ); ?>" />

                            <?php } ?>

                            <header class="entry-header <?php echo sanitize_html_class( $section_style_class ); ?>">
                                <?php if ( get_sub_field( 'custom_slide_url' ) ) { ?>
                                    <a class="entry-link" href="<?php the_sub_field( 'custom_slide_url' ); ?>"></a>
                                <?php } ?>
                                <div class="inner">
                                    <div class="inner-cell">
                                        <div class="entry-frame">
                                            <h2 class="entry-title">
                                                 <a href="<?php the_sub_field( 'custom_slide_url' ); ?>"><?php the_sub_field( 'custom_slide_title' ); ?></a>
                                            </h2>
                                            <?php if ( get_sub_field( 'custom_button_text' ) ) { ?>
                                                <a class="read-more" href="<?php the_sub_field( 'custom_slide_url' ); ?>"><?php the_sub_field( 'custom_button_text' ); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </header>

                        </div><!-- Slide -->

                    <?php endwhile; ?>

                 </div>

            <?php if ( $with_two_posts ) : ?>
            </div><!-- Grid 8 -->
            <?php endif; ?>

    <?php endif; ?>



    <?php if ( $with_two_posts ) : ?>

        <?php if( have_rows( 'custom_add_post' ) ) : ?>

            <div class="grid-4 columns column-2 entries">

                <?php while( have_rows( 'custom_add_post' ) ) : the_row(); ?>

                    <article class="post-item content-over-image content-over-image-tint">
                        <?php if ( get_sub_field( 'custom_post_link' ) ) { ?>
                        <a class="entry-link" href="<?php the_sub_field( 'custom_post_link' ); ?>"></a>
                        <?php } ?>

                        <figure class="entry-image">
                            <?php
                            $custom_img = get_sub_field( 'custom_post_image' );

                            if ( ! empty( $custom_img ) ) {

                                $alt = $custom_img['alt'];
                                $size = 'rectangle-size';
                                $src = $custom_img['sizes'][$size];
                                $width = $custom_img['sizes'][$size . '-width'];
                                $height = $custom_img['sizes'][$size . '-height'];

                                echo '<img src="' . esc_url( $src ) .'" alt="' . esc_attr( $alt ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" />';

                            } else {
                                echo '<img class="alter" src="' . get_template_directory_uri() . '/images/pixel.gif" />';
                            }
                            ?>
                        </figure>

                        <header class="entry-header">
                            <div class="inner">
                                <div class="inner-cell">
                                    <div class="entry-frame">
                                        <h2 class="entry-title">
                                            <?php the_sub_field( 'custom_post_title' ); ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </article><!-- Custom Post -->

                <?php endwhile; ?>

            </div><!-- Grid 4 -->

        <?php endif; ?>

    </div><!-- .grids -->
</div><!-- .slider-latest -->

<?php endif; // if with two posts option is selected ?>
