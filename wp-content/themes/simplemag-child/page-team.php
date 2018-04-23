<?php 
/**
 * Template Name: Team
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.2
**/ 
get_header();
global $ti_option; 
?>
	
	<section id="content" role="main" class="clearfix anmtd">

        <?php
        /**
         * If Featured Image is uploaded set it as a background
         * and change page title color to white
        **/
        if ( has_post_thumbnail() ) {
            $page_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
            $page_bg_image = 'style="background-image:url(' . esc_url( $page_image_url[0] ) . ');"';
            $title_with_bg = 'full-width-image content-over-image-tint page-title-bg';
        } else {
            $title_with_bg = 'wrapper title-with-sep';
        } ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="page-title <?php echo isset( $title_with_bg ) ? $title_with_bg : ''; ?>" <?php echo isset( $page_bg_image ) ? $page_bg_image : ''; ?>>
                <header class="entry-header page-header">  
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
            </div>
                
        	<div class="wrapper">
    			<?php
    			// Enable/Disable sidebar based on the field selection
    			if ( ! get_field( 'page_sidebar' ) || get_field( 'page_sidebar' ) == 'page_sidebar_on' ) :
    			?>
                <div class="grids">
                    <div class="grid-8 column-1">
                <?php endif; ?>
                    
                    <?php if ( have_posts()) : while (have_posts() ) : the_post(); ?>
						
						<?php
						// Output the main editor content
						the_content(); ?>
						
						<?php if(get_field('team_member')) : while(has_sub_field('team_member')): ?>
								<div class="team-member">
										<img src="<?php the_sub_field('team_member_photo'); ?>" alt="" />
										<h2><?php the_sub_field('team_member_name'); ?></h2>
										<h4><em><?php the_sub_field('team_member_title'); ?></em></h4>
										<p><a class="team-contact" href="mailto:<?php the_sub_field('team_member_contact'); ?>"><span class="fa fa-fw fa-envelope"></span>Contact</a></p>
										<p><?php the_sub_field('team_member_bio'); ?> </p>
										
								</div>
								<hr class="team-break">
								
						<?php endwhile; endif;?>

                    
                    <?php endwhile; endif; ?>
            		
                    <?php 
    				// Enable/Disable comments
    				if ( $ti_option['site_page_comments'] == 1 ) {
    					comments_template();
    				}
    				?>
                    
    				<?php
    				// Enable/Disable sidebar based on the field selection
    				if ( ! get_field( 'page_sidebar' ) || get_field( 'page_sidebar' ) == 'page_sidebar_on' ):
    				?>
                    </div><!-- .grid-8 -->
                
                    <?php get_sidebar(); ?>

                </div><!-- .grids -->
                <?php endif; ?>
            
            </div>

        </div>
    </section><!-- #content -->

<?php get_footer(); ?>