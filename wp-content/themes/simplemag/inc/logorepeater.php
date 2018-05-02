
<?php
if ( have_rows('sponsor_logos') ) : while( have_rows('sponsor_logos') ) : the_row();
  $sponsorImage = get_sub_field('logo_image'); 
  $url = $sponsorImage['sizes']['regular'];
  ?> 
    <article class="grid-2">
        <a href="<?php the_sub_field('sponsor_link'); ?>" target="_blank"><img src="<?php echo esc_url( $url ); ?>" alt=""></a>
    </article>
<?php endwhile; endif; ?>
