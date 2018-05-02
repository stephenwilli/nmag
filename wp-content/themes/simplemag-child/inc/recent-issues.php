<?php 
include locate_template( 'composer/assets/section-colors.php' );
?>

<section class="home-section penta-box category-posts<?php echo $section_bg . '' . $section_text. '' . $section_links; ?>">  
    
    <div class="wrapper">
        
        <header class="section-header">
          <div class="section-title title-with-sep">
              <h2 class="title">Latest Issues</h2>
          </div>
        </header>

        <div class="grids entries">

            <?php

            $ti_cat_posts = new WP_Query(
                array(
                    'posts_per_page' => 3,
                    'category_name' => 'open-the-mag',
                    'no_found_rows' => true,
                )
            );


            if ( $ti_cat_posts->have_posts() ) : while ( $ti_cat_posts->have_posts() ) : $ti_cat_posts->the_post();?>
              
              <div class="grid-4">
                  <article <?php post_class(); ?>>
                      <figure class="entry-image">
                        <a href="<?php the_permalink(); ?>">
                          <?php the_post_thumbnail( 'medium' ); ?>
                        </a>
                      </figure>

                      <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                      </header>

                      <div class="entry-summary">
                          <?php the_excerpt(); ?>
                      </div>

                  </article></div>

                <?php endwhile;
                wp_reset_postdata();
            endif; 
            ?>

        </div>
    
    </div><!-- .wrapper -->
    
</section><!-- Latest By Category: <?php echo get_category( $cat_id )->name; ?> -->