<?php
//Check to see if global plugins is active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
if(!is_plugin_active('ksas-global-functions/ksas-global-functions.php')) {
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'start_post_rel_link', 10, 0);
		remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
	
		//remove version info from head and feeds
		    function complete_version_removal() {
		    	return '';
		    }
		    add_filter('the_generator', 'complete_version_removal');
	
		//***8.4 Get page ID from page slug - Used to generate left side nav on some pages
		function ksas_get_page_id($page_name){
			global $wpdb;
			$page_name = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."'");
			return $page_name;
		}


	//***8.8 Create Title for <head> section
		function create_page_title() {
			if ( is_front_page() )  { 
				$page_title = bloginfo('description');
				$page_title .= print(' '); 
				$page_title .= bloginfo('name');
				$page_title .= print(' | Johns Hopkins University'); 
				} 
			
			elseif ( is_category() ) { 
				$page_title = single_cat_title();
				$page_title .= print(' | ');
				$page_title .= bloginfo('description');
				$page_title .= print(' '); 
				$page_title .= bloginfo('name');
				$page_title .= print(' | Johns Hopkins University'); 
		 
				}
		
			elseif (is_single() ) { 
				$page_title = single_post_title(); 
				$page_title .= print(' | ');
				$page_title .= bloginfo('description');
				$page_title .= print(' '); 
				$page_title .= bloginfo('name');
				$page_title .= print(' | Johns Hopkins University'); 
				}
		
			elseif (is_page() ) { 
				$page_title = single_post_title();
				$page_title .= print(' | ');
				$page_title .= bloginfo('description');
				$page_title .= print(' '); 
				$page_title .= bloginfo('name');
				$page_title .= print(' | Johns Hopkins University'); 
			}
			elseif (is_404()) {
				$page_title = print('Page Not Found'); 
				$page_title .= print(' | ');
				$page_title .= bloginfo('description');
				$page_title .= print(' '); 
				$page_title .= bloginfo('name');
				$page_title .= print(' | Johns Hopkins University'); 
			}
			else { 
				$page_title = bloginfo('description');
				$page_title .= print(' '); 
				$page_title .= bloginfo('name');
				$page_title .= print(' | Johns Hopkins University'); 
				} 
			return $page_title;
		}
	//***9.1 Menu Walker to add Foundation CSS classes
		class foundation_navigation extends Walker_Nav_Menu
		{
		      function start_el(&$output, $item, $depth, $args)
		      {
					global $wp_query;
					$indent = ( $depth ) ? str_repeat( "", $depth ) : '';
					
					$class_names = $value = '';
					
					// If the item has children, add the dropdown class for bootstrap
					if ( $args->has_children ) {
						$class_names = "has-flyout ";
					}
					$classes = empty( $item->classes ) ? array() : (array) $item->classes;
					
					$class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
					$class_names = ' class="'. esc_attr( $class_names ) . ' page-id-' . esc_attr( $item->object_id ) .'"';
		           
					$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		           
		
		           	$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		           	$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		           	$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		           	$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		           	// if the item has children add these two attributes to the anchor tag
		           	if ( $args->has_children ) {
						$attributes .= 'data-toggle="dropdown"';
					}
		
		            $item_output = $args->before;
		            $item_output .= '<a'. $attributes .'>';
		            $item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		            $item_output .= $args->link_after;
		            $item_output .= '</a>';
		            $item_output .= $args->after;
		
		            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		            }
		            
		function start_lvl(&$output, $depth) {
			$output .= "\n<ul class=\"flyout up\">\n";
		}
		            
		      	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
		      	    {
		      	        $id_field = $this->db_fields['id'];
		      	        if ( is_object( $args[0] ) ) {
		      	            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		      	        }
		      	        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		      	    }
		      	
		            
		}
		
		// Add a class to the wp_page_menu fallback
		function foundation_page_menu_class($ulclass) {
			return preg_replace('/<ul>/', '<ul class="nav-bar">', $ulclass, 1);
		}
		
		add_filter('wp_page_menu','foundation_page_menu_class');

}
//Add Theme Options Page
	if(is_admin()){	
		require_once('assets/functions/theme-options-init.php');
	}
	
	//Collect current theme option values
		function flagship_sub_get_global_options(){
			$flagship_sub_option = array();
			$flagship_sub_option 	= get_option('flagship_sub_options');
		return $flagship_sub_option;
		}
	
	//Function to call theme options in theme files 
		$flagship_sub_option = flagship_sub_get_global_options();

//Add custom background option
	
function academic_flagship_theme_support() {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 125, 125, true );   // default thumb size
	add_image_size( 'rss', 300, 150, true );
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

// Initiate Theme Support
add_action('after_setup_theme','academic_flagship_theme_support');

//Register Sidebars
	if ( function_exists('register_sidebar') )
		register_sidebar(array(
			'name'          => 'Default Sidebar',
			'id'            => 'page-sb',
			'description'   => 'This is the default sidebar',
			'before_widget' => '<div id="widget" class="widget %2$s row">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="blue_bg widget_title"><h5 class="white">',
			'after_title'   => '</h5></div>' 
			));
	if ( function_exists('register_sidebar') )
		register_sidebar(array(
			'name'          => 'Homepage Sidebar',
			'id'            => 'homepage-sb',
			'description'   => 'This sidebar will only appear on the homepage',
			'before_widget' => '<div id="widget" class="widget %2$s row">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="blue_bg widget_title"><h5 class="white">',
			'after_title'   => '</h5></div>' 
			));

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
	}
}
	add_action('save_post','delete_academic_open_transients');
	
	//***9.2 Menu Walker to create social media icon menu	
		class social_media_menu extends Walker_Nav_Menu{
		    function start_lvl(&$output, $depth){
		      $indent = str_repeat("\t", $depth); // don't output children opening tag (`<ul>`)
		    }
		
		    function end_lvl(&$output, $depth){
		      $indent = str_repeat("\t", $depth); // don't output children closing tag
		    }
		
		    function start_el(&$output, $item, $depth, $args){
		
		      parent::start_el(&$output, $item, $depth, $args);
		
		      // no point redefining this method too, we just replace the li tag...
		      $output = '<a href="'. esc_attr( $item->url) . '"><span class="icon-'. $item->title .'"></span><span class="hide">' . $item->title . '</span></a>';

		    }
		
		    function end_el(&$output, $item, $depth){
		      $output .= ''; // replace closing </li> with the option tag
		    }
		}

?>