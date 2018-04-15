<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {

	wp_enqueue_script( 'fancybox', get_stylesheet_directory_uri() . '/js/vendor/fancybox/source/jquery.fancybox.pack.js',  array('jquery'), '',true );
	wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/main.js',  array('jquery'), '', true );
		wp_enqueue_script( 'jquery.cookie', get_stylesheet_directory_uri() . '/js/jquery.cookie.js',  array('jquery'), '', true );
    
    wp_enqueue_style( 'fontawesome.css', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
    wp_enqueue_style ( 'fancybox', get_stylesheet_directory_uri() . '/js/vendor/fancybox/source/jquery.fancybox.css', array(), '', 'all' )	;
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

//Gets post cat slug and looks for single-[cat slug].php and applies it
add_filter('single_template', create_function(
	'$the_template',
	'foreach( (array) get_the_category() as $cat ) {
		if ( file_exists(STYLESHEETPATH . "/single-{$cat->slug}.php") )
		return STYLESHEETPATH . "/single-{$cat->slug}.php"; }
	return $the_template;' )
);



// ACF PRO Options pages

if( function_exists('acf_add_options_page') ) {

  acf_add_options_page(array(
    'page_title'  => 'Homepage Banner',
    'menu_title'  => 'Homepage Banner',
    'menu_slug'   => 'homepage-banner',
    'capability'  => 'edit_posts',
    'icon_url'    => 'dashicons-images-alt2',
    'redirect'    => false // This allows the parent to have it's own page instead of redirecting to the first child.
  ));

}


function wpt_admin_color_schemes() {
	
	$theme_dir = get_stylesheet_directory_uri();

	wp_admin_css_color( 
		'nmag', __( 'N Magazine' ),
		$theme_dir . '/admin-colors/nmag/colors.css',
		array( '#3a3a3a', '#1f1f1f', '#A72423', '#ffffff' )
	);
	
}
add_action('admin_init', 'wpt_admin_color_schemes');

function template_part( $atts, $content = null ){
   $tp_atts = shortcode_atts(array( 
      'path' =>  null,
   ), $atts);         
   ob_start();  
   get_template_part($tp_atts['path']);  
   $ret = ob_get_contents();  
   ob_end_clean();  
   return $ret;    
}
add_shortcode('template_part', 'template_part');

function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/header_logo_01.png);
            padding-bottom: 30px;
            background-size: cover;
            height: 200px;
            width: 400px;
            margin: 0px auto 0 -40px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

add_image_size( 'rectangle-size-small', 296, 197, false );
add_image_size( 'regular', 333, 222, false );




