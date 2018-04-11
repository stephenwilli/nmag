<?php
/**
 * A Welcome page with all the information about theme.
 * Page opens right after the theme was activated.
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/


/**
 * Create the welcome page.
 * Redirect to the welcome page after theme activation.
**/
function ti_welcome_page() {

	// Add the welcome page
    add_theme_page( 'Welcome to SimpleMag', 'Welcome to SimpleMag', 'edit_theme_options', 'simplemag-welcome', 'ti_welcome_page_content' );

	// Redirect to welcome page after theme activation
	if ( isset( $_GET['activated'] ) ) {

	    // Do redirect
	    wp_redirect( admin_url( 'themes.php?page=simplemag-welcome' ) );

	}
}
add_action( 'admin_menu', 'ti_welcome_page' );


/* Hide welcome page menu item from the menu */
function ti_admin_css() {
  echo '<style>#adminmenu .wp-submenu a[href="themes.php?page=simplemag-welcome"], .appearance_page_simplemag-welcome #setting-error-tgmpa{display:none;}</style>';
}
add_action( 'admin_head', 'ti_admin_css' );


/**
 * Function to show the Welcome page after theme activation
**/
function ti_welcome_page_content() {
?>

	<style>
	.welcome-wrap {
		margin-bottom:60px;
	}
	.ti-author {
		color:#777;
		margin-top:20px;
	}
	.ti-theme-badge {
		position: absolute;
		top: 0;
		right: 0;
		width: 160px;
		text-align:center;
	}
	.badge {
		padding:142px 0 20px;
		color: #fff;
		font-weight: bold;
		font-size: 14px;
		text-align: center;
		margin: 0 0 12px;
		background:#ffcc0d url("<?php echo esc_url( get_template_directory_uri() ); ?>/admin/images/sm-theme-badge.png") no-repeat top center;
	}
	.ti-block {
		margin-bottom:60px;
	}
    .about-wrap .ti-block h2 {
        text-align:left !important;
        margin:20px 0 !important;
    }
	.white-panel {
		background:#fff;
		padding:10px 30px;
	}
    .about-wrap .feature-section {
        padding:0;
    }
    .about-wrap .feature-section .col {
        margin-top:0;
    }
    .change-log-msg {
        padding:20px 0 10px;
    }
	</style>

	<div class="wrap about-wrap">

		<div class="welcome-wrap ti-block">

			<p class="ti-block">Thank you for installing the theme!</p>

			<?php $ti_current_theme = wp_get_theme(); ?>

			<h1>
				Welcome to <?php echo $ti_current_theme->get( 'Name' ) . ' ' . $ti_current_theme->get( 'Version' ); ?>
			</h1>

			<h2>
				<?php echo $ti_current_theme->get( 'Description' ); ?>
			</h2>

			<div class="ti-author">
				<i>by</i> 
                <a href="http://themesindep.com" target="_blank"><?php echo $ti_current_theme->get( 'Author' ); ?></a>&nbsp; | &nbsp;
                <a href="http://facebook.com/ThemesIndep" target="_blank">Facebook</a> &nbsp;&middot;&nbsp;
                <a href="https://twitter.com/themesindep" target="_blank">Twitter</a>
            </div>
            
			<div class="ti-theme-badge">
				<div class="badge">
					Version <?php echo $ti_current_theme->get( 'Version' ); ?>
				</div>
				<a href="http://www.themesindep.com/support/simplemag-change-log/" class="button" target="_blank">See Change Log</a>
			</div>
		</div>
        
        
        <div class="white-panel ti-block">
            <h2>What's new in this version</h2>
			<hr>
			<div class="feature-section">
				<h4>Fixes and Improvments</h4>
                For more detailed information please <a href="http://www.themesindep.com/support/simplemag-change-log/" target="_blank">see the Change Log</a>.
                <br><br>
            </div>
        </div>
        

        <div class="ti-block">
            <a name="setup"></a>
			<h2>Theme Setup &amp; Configuration</h2>
			<hr>
			<div class="feature-section two-col">
				<div class="col">
					<h4>Install Plugins</h4>
					<p>SimpleMag comes with a small list of recommended and required plugins which are needed to get more from the theme</p>
					<a href="<?php echo admin_url(); ?>themes.php?page=tgmpa-install-plugins" class="button-primary" target="_blank">Install Plugins</a>
				</div>
			
				<div class="col">
					<h4>Theme Options</h4>
					<p>Configure and customize the theme using the intuitive and easy to use theme options panel</p>
					<a href="<?php echo admin_url(); ?>themes.php?page=<?php echo $ti_current_theme->get( 'Name' ); ?>" class="button-primary" target="_blank">Configure</a>
				</div>
			</div>
		</div>

		<div class="ti-block">
            <a name="support"></a>
			<h2>Support Center</h2>
            <hr>
			<div class="feature-section three-col">
				<div class="col">
					<h4>Knowledge Base</h4>
					<p>Contains all the most important topics and code snippets.</p>
					<a href="http://www.themesindep.com/support/knowledgebase/" class="button-primary" target="_blank">Learn It</a>
				</div>
				<div class="col">
					<h4>Video Tutorials</h4>
					<p>Videos about theme configuration and features usage</p>
					<a href="http://www.themesindep.com/support/video-tutorials/" class="button-primary" target="_blank">Watch It</a>
				</div>
				<div class="col">
					<h4>Support Forum</h4>
					<p>Have difficulties in theme setup and configuration? Speak to us directly.</p>
					<a href="http://www.themesindep.com/support/forums/forum/simplemag/" class="button-primary" target="_blank">View the forums</a>
				</div>
			</div>
		</div>

        
        

        
        <hr>
        <br>
        <br>
        
        <div class="ti-block">
            <a href="http://themesindep.com/showcase" target="_blank">Showcase</a> &nbsp;&middot;&nbsp;
            <a href="http://themesindep.com/support/" target="_blank">Support Center</a> &nbsp;&middot;&nbsp;
            <a href="http://facebook.com/ThemesIndep" target="_blank">Facebook</a> &nbsp;&middot;&nbsp;
            <a href="https://twitter.com/themesindep" target="_blank">Twitter</a>
        </div>
	
	</div>

<?php } ?>