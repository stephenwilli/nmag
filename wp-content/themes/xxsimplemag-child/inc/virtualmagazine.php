<?php

$coverImage = get_field('magazine_cover');	
$url = $coverImage ['sizes']['regular'];

?>

<img src="<?php echo esc_url( $url ); ?>" alt="">

