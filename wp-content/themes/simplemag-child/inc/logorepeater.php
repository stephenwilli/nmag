<div class="partner-logos">
  <?php
    if ( have_rows('partner_logos') ): while( have_rows('partner_logos') ): the_row();
    $partnerImage = get_sub_field('partner_image'); 
    $url = $partnerImage ['sizes']['regular'];
  ?> 
    <div class="grid-2">
        <a href="<?php the_sub_field('partner_link'); ?>" target="_blank"><img src="<?php echo esc_url( $url ); ?>" alt="">
    </div>
  <?php endwhile; endif; ?>
</div>
