<div class="grids entries">
<?php
if ( have_rows('sponsor_logos') ): while( have_rows('sponsor_logos') ): the_row();
$sponsorImage = get_sub_field('logo_image'); 
$url = $sponsorImage ['sizes']['regular'];
?> 
    <article class="post type-post status-publish format-standard has-post-thumbnail hentry grid-4 feature-post">
      <figure class="entry-image inview">
        <a href="<?php the_sub_field('sponsor_link'); ?>" target="_blank"><img src="<?php echo esc_url( $url ); ?>" alt="">
      </figure>
    </article>

<?php endwhile; endif; ?>
</div>
