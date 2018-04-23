<?php

$videoImage = get_field('video_content_image');	
$url = $videoImage ['sizes']['regular'];

?>

<img src="<?php echo esc_url( $url ); ?>" alt="">

