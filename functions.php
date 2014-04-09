<?php
//Add Theme Options Page
	if(is_admin()){	
		require_once('assets/functions/theme-options-init.php');
	}
	
//Function to call theme option values
	function flagship_sub_get_global_options(){
		$flagship_sub_option = array();
		$flagship_sub_option 	= get_option('flagship_sub_options');
	return $flagship_sub_option;
	}
	

// Initiate Theme Support
add_action('after_setup_theme','academic_flagship_theme_support');
function academic_flagship_theme_support() {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 125, 125, true );   // default thumb size
	add_image_size( 'rss', 410, 175, true );
	add_image_size( 'directory', 90, 130, true );
	add_theme_support( 'automatic-feed-links' ); // rss thingy
	$bg_args = array(
		'default-color'          => '#e2e1df',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', $bg_args  );
	add_theme_support( 'menus' );            
	register_nav_menus(                      
		array( 
			'main_nav' => 'The Main Menu', 
			'search_bar' => 'Search Bar Links',
			'quick_links' => 'Quick Links',
			'footer_links' => 'Footer Links',
			'social_media' => 'Social Media Links'
		)
	);	
}


//Register Sidebars
add_action( 'widgets_init', 'ksas_widget_init' );
function ksas_widget_init() {

        register_sidebar( array(
					 'name' => 'Homepage Sidebar',
					   'id' => 'homepage-sb',			
			'before_widget' => '<div id="widget" class="widget %2$s row">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget_title"><h5>',
			'after_title'   => '</h5></div>' 
			));
        register_sidebars( 7, array(
			'before_widget' => '<div id="widget" class="widget %2$s row">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget_title"><h5>',
			'after_title'   => '</h5></div>' 
			));
}
include_once (TEMPLATEPATH . '/assets/functions/page_metabox.php'); 

function get_the_directory_filters($post) {
	$directory_filters = get_the_terms( $post->ID, 'filter' );
					if ( $directory_filters && ! is_wp_error( $directory_filters ) ) : 
						$directory_filter_names = array();
							foreach ( $directory_filters as $directory_filter ) {
								$directory_filter_names[] = $directory_filter->slug;
							}
						$directory_filter_name = join( " ", $directory_filter_names );
						
					endif;
					return $directory_filter_name;
}

function get_the_roles($post) {
	$roles = get_the_terms( $post->ID, 'role' );
					if ( $roles && ! is_wp_error( $roles ) ) : 
						$role_names = array();
							foreach ( $roles as $role ) {
								$role_names[] = $role->slug;
							}
						$role_name = join( " ", $role_names );
						
					endif;
					return $role_name;
}

/**********DELETE TRANSIENTS******************/

function delete_academic_open_transients($post_id) {
	global $post;
	if (isset($_GET['post_type'])) {		
		$post_type = $_GET['post_type'];
	}
	else {
		$post_type = $post->post_type;
	}
	switch($post_type) {
		case 'post' :
			for ($i=1; $i < 5; $i++) {
			      delete_transient('news_archive_query_' . $i); }
			   
			delete_transient('news_query');
		break;
		
		case 'slider' :
			delete_transient('slider_query');
		break;
		case 'bulletinboard' :
			delete_transient('ksas_bb_undergrad_query');
			delete_transient('ksas_bb_grad_query');
		break;
		case 'profile' :
			delete_transient('ksas_profile_undergrad_query');
			delete_transient('ksas_profile_grad_query');
			delete_transient('ksas_profile_spotlight_query');
		break;
		case 'programs' :
			delete_transient('flagship_programs_query');
		break;
	}
}
	add_action('save_post','delete_academic_open_transients');
	
	//***9.2 Menu Walker to create social media icon menu	
		class social_media_menu extends Walker_Nav_Menu{
		    function start_lvl(&$output, $depth = 0, $args = array()){
		      $indent = str_repeat("\t", $depth); // don't output children opening tag (`<ul>`)
		    }
		
		    function end_lvl(&$output, $depth = 0, $args = array()){
		      $indent = str_repeat("\t", $depth); // don't output children closing tag
		    }
		
		    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0){
		
		      parent::start_el(&$output, $item, $depth, $args);
		
		      // no point redefining this method too, we just replace the li tag...
		      $output = '<a href="'. esc_attr( $item->url) . '"><span class="icon-'. $item->title .'"></span><span class="hide">' . $item->title . '</span></a>';

		    }
		
		    function end_el(&$output, $item, $depth = 0, $args = array()){
		      $output .= ''; // replace closing </li> with the option tag
		    }
		}
	include_once (TEMPLATEPATH . '/assets/functions/post-type-grad-programs.php'); 

?>