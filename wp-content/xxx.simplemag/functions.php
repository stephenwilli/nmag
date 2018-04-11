<?php
/**
 * SimpleMag functions and definitions
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.0
**/


/* Install plugins for theme use */
include_once ( 'admin/tgm/tgm-init.php' );


/* Content Width */
if ( ! isset( $content_width ) ) 
	$content_width = 1050; /* pixels */


/* Theme Setup */
function ti_theme_setup() {

	/* Register Menus  */
	register_nav_menus( array(
		'main_menu' => __( 'Main Menu', 'themetext' ), // Main site menu
		'secondary_menu' => __( 'Secondary Menu', 'themetext' ) // Main site menu
	));

	/*  Post Formats */
	add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio' ) );

	/* Images */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'rectangle-size', 330, 220, true );
	add_image_size( 'rectangle-size-small', 296, 197, false );
	add_image_size( 'masonry-size', 330, 9999, true );
	add_image_size( 'medium-size', 690, 9999 );
	add_image_size( 'big-size', 1050, 9999 );
	global $ti_option;
	add_image_size( 'gallery-carousel', 9999, $ti_option['site_carousel_height'] );

	/* Enable post and comment RSS feed links */
	add_theme_support( 'automatic-feed-links' );

	/* Theme localization */
	load_theme_textdomain( 'themetext', get_template_directory() . '/languages' );
	
}
add_action( 'after_setup_theme', 'ti_theme_setup' );


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
**/
function ti_wp_title( $title, $sep ) {

	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'simpletheme' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'ti_wp_title', 10, 2 );



/**
 * Add classes to the body tag
**/
function ti_body_classes( $classes ){

	global $post, $ti_option;
	
	if ( !is_rtl() ) {
		$classes[] = 'ltr';
	}

	// Page Name as body class name
	if ( is_page() ) {
		$page_name = $post->post_name;
		$classes[] = 'page-'.$page_name;
 	} 

	// If page have sidebar enabled
	if ( get_field( 'page_sidebar' ) == 'page_sidebar_on' || get_field( 'comp_page_sidebar' ) == 'comp_sidebar_page' || get_field('category_slider', 'category_' . get_query_var('cat') ) == 'cat_slider_on' && get_field('category_slider_position', 'category_' . get_query_var('cat') ) == 'cat_slider_above' && get_field( 'category_sidebar', 'category_' . get_query_var('cat') ) == 'cat_sidebar_on' ) { 
		$classes[] = 'with-sidebar';
	}

	// Text Alignmnet Left for the whole site
	if ( $ti_option['text_alignment'] == '2' ) {
		$classes[] = 'text-left';
	}

	return $classes;
}
add_filter( 'body_class', 'ti_body_classes' );



/**
 * Add classes to top strip based on Theme Options selections
**/
function ti_top_strip_class(){

	global $ti_option;

	// Hide/Show top strip
	if ( $ti_option['site_top_strip'] == 0 ) { echo ' hide-strip'; }

	// Make top strip fixed
	if ( $ti_option['site_fixed_menu'] == '2' ) { echo ' top-strip-fixed'; }

	// If top strip have white background
	if ( $ti_option['site_top_strip_bg'] == '#ffffff') { echo ' color-site-white'; }

}


/**
 * Posts Meta Data. Category and Date.
**/
function ti_meta_data(){
	
	global $ti_option;
	
	// Category Name
	if ( is_single() ) {
		if ( $ti_option['single_post_cat_name'] == true ) {
			echo '<span class="entry-category">'; the_category(', '); echo '</span>';
		}
	} else {
		echo '<span class="entry-category">'; the_category(', '); echo '</span>';
	}
	
	// Date
	$publish_date = '<time class="entry-date updated" datetime="' . get_the_time( 'c' ) . '" itemprop="datePublished">' . get_the_time( get_option( 'date_format' ) ) . '</time>';
	
	if ( is_home() || is_front_page() || is_page() ) {
		if ( $ti_option['home_post_date'] == 1 ) {
    		echo $publish_date;
		}
	} 
	if ( is_category() || is_tag() || is_author() ) {
		if ( $ti_option['archive_post_date'] == 1 ) {
    		echo $publish_date;
		}
	}
	if ( is_single() ) {
		if ( $ti_option['single_post_date'] == 1 ) {
    		echo $publish_date;
		}
	}
}


/**
 * Calculate to total score for posts with Rating feature is enabled
 *
 * Applies to:
 * 1. Latest Reviews & Latest Posts sections
 * 2. Latest Reviews widget
 * 3. Single Post
**/
function ti_rating_calc() {

    $score_rows = get_field( 'rating_module' );
    $score = array();
    
    // Loop through the scores
    if ( $score_rows ){
        foreach( $score_rows as $key => $row ){
            $score[$key] = $row['score_number'];
        }
    
	    $score_items = count( $score ); // Count the scores
	    $score_sum = array_sum( $score ); // Get the scores summ
	    $score_total = $score_sum / $score_items; // Get the score result

	    return $score_total;
	}
}
add_filter( 'ti_score_total', 'ti_rating_calc' );




/**
 * Add Previous & Next links to a numbered link list 
 * of wp_link_pages() if single post is paged
 */
function ti_wp_link_pages( $args ){

    global $page, $numpages, $more;

    if ( !$args['next_or_number'] == 'next_and_number' ){
        return $args;
    }
	
	// Keep numbers for the main part
    $args['next_or_number'] = 'number'; 
    if (!$more){
        return $args;
    }
	
	// If previous page exists
    if( $page-1 ){
        $args['before'] .= _wp_link_page($page-1) . $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>';
    }

	// If next page exists
    if ( $page<$numpages ){
        $args['after'] = _wp_link_page($page+1) . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>' . $args['after'];
    }

    return $args;
}
add_filter( 'wp_link_pages_args', 'ti_wp_link_pages' );



/* Theme Options */
require_once( 'admin/theme-options.php' );


/* Custom Fields */
include_once( 'admin/acf/acf.php' );
include_once( 'admin/acf-fields/acf-fields.php' );
include_once( 'admin/acf-fields/add-ons/acf-wp-editor/acf-wp_wysiwyg.php' );
// define( 'ACF_LITE', true );


/* Includes */
include_once( 'inc/user-fields.php' );
include_once( 'inc/mega-menu.php' );
include_once( 'inc/styling-options.php' );
include_once( 'inc/pagination.php' );
global $ti_option;
if ( $ti_option['site_custom_gallery'] == true ) {
	include_once( 'inc/wp-gallery.php' );
}


/* Widgets */
include_once( 'widgets/ti-video.php' );
include_once( 'widgets/ti-authors.php' );
include_once( 'widgets/ti-about-site.php' );
include_once( 'widgets/ti-latest-posts.php' );
include_once( 'widgets/ti-code-banner.php' );
include_once( 'widgets/ti-image-banner.php' );
include_once( 'widgets/ti-latest-reviews.php' );
include_once( 'widgets/ti-featured-posts.php' );
include_once( 'widgets/ti-most-commented.php' );
include_once( 'widgets/ti-latest-comments.php' );
include_once( 'widgets/ti-latest-category-posts.php' );


/* Register jQuery Scripts and CSS Styles */
include_once( 'inc/register-scripts.php' );


/**
 * Excerpt length
 * Excerpt more
*/
// Excerpt Length
function ti_excerpt_length( $length ) {
	global $ti_option;
	return $ti_option['site_wide_excerpt_length'];
}
add_filter( 'excerpt_length', 'ti_excerpt_length' );

// Excerpt more
function ti_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'ti_excerpt_more' );


/**
 * Different image size based on layout selection for Homepage, Categories and Posts Page
*/
function ti_layout_based_post_image() {

	$itemprop = array('itemprop' => 'image');

	if ( has_post_thumbnail() ) { // Set Featured Image
		// Images for Posts Page or if this page is used as Homepage with "Your latest posts" option
		if ( is_home() ) {
			global $ti_option;
            if ( $ti_option['posts_page_layout'] == 'grid-layout' || $ti_option['posts_page_layout'] == 'list-layout' ) {
                the_post_thumbnail( 'rectangle-size', $itemprop );
            } elseif (  $ti_option['posts_page_layout'] == 'classic-layout' ) {
                the_post_thumbnail( 'big-size', $itemprop );
            } else {
                the_post_thumbnail( 'masonry-size', $itemprop );
            }
        // Images for Homepage used with page composer and Categories
        } else {
        	if ( get_sub_field ( 'latest_posts_layout' ) == 'list-layout' || get_field ( 'category_posts_layout', 'category_' . get_query_var('cat') ) == 'list-layout' || get_sub_field ( 'latest_posts_layout' ) == 'grid-layout' || get_field ( 'category_posts_layout', 'category_' . get_query_var('cat') ) == 'grid-layout' ) {
        		the_post_thumbnail( 'rectangle-size', $itemprop );
			} elseif ( get_sub_field ( 'latest_posts_layout' ) == 'classic-layout' || get_field ( 'category_posts_layout', 'category_' . get_query_var('cat') ) == 'classic-layout' ) {
				the_post_thumbnail( 'big-size', $itemprop );
			} else {
				the_post_thumbnail( 'masonry-size', $itemprop );
			}
    	}
    } elseif( first_post_image() ) { // Set the first image from the editor
        echo '<img src="' . first_post_image() . '" class="wp-post-image" alt="' . get_the_title() . '" />';
    }
}


/**
 * Get The First Image From a Post
 */
function first_post_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	if( preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches ) ){
		$first_img = $matches[1][0];
		return $first_img;
	}
}



/* Define sidebars */
function register_theme_sidebars() {

	if ( function_exists('register_sidebars') ) {
		
		// Sidebar for blog section of the site
		register_sidebar(
		   array(
			'name' => __( 'Magazine', 'themetext' ),
			'id' => 'sidebar-1',
			'description'   => __( 'Sidebar for categories and single posts', 'themetext' ),		   
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);

		register_sidebar(
		   array(
			'name' => __( 'Pages', 'themetext' ),  
			'id' => 'sidebar-2',
			'description'   => __( 'Sidebar for static pages', 'themetext' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);

		register_sidebar(
		   array(
			'name' => __( 'Footer Area One', 'themetext' ),  
			'id' => 'sidebar-3',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);
		
		register_sidebar(
		   array(
			'name' => __( 'Footer Area Two', 'themetext' ),
			'id' => 'sidebar-4',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);
		
		register_sidebar(
		   array(
			'name' => __( 'Footer Area Three', 'themetext' ),  
			'id' => 'sidebar-5',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);

	}

}
add_action( 'widgets_init', 'register_theme_sidebars' );


/* Count the number of footer sidebars to enable dynamic classes for the footer */
function ti_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = ' col-1';
			break;
		case '2':
			$class = ' col-2';
			break;
		case '3':
			$class = ' col-3';
			break;
	}

	if ( $class )
		echo $class;
}


/**
 * Remove rel attribute from the category list
 */
function remove_category_list_rel( $output ) {
    return str_replace( 'rel="category tag"', '', $output );
}
add_filter( 'wp_list_categories', 'remove_category_list_rel' );
add_filter( 'the_category', 'remove_category_list_rel' );