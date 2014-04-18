<?php
	function register_programs_posttype() {
		$labels = array(
			'name' 				=> _x( 'Programs of Study', 'post type general name' ),
			'singular_name'		=> _x( 'Program of Study', 'post type singular name' ),
			'add_new' 			=> __( 'Add New Program of Study' ),
			'add_new_item' 		=> __( 'Add New Program of Study' ),
			'edit_item' 		=> __( 'Edit Program of Study' ),
			'new_item' 			=> __( 'New Program of Study' ),
			'view_item' 		=> __( 'View Program of Study' ),
			'search_items' 		=> __( 'Search Programs of Study' ),
			'not_found' 		=> __( 'No Programs of Study found' ),
			'not_found_in_trash'=> __( 'No Programs of Study found in Trash' ),
			'parent_item_colon' => __( '' ),
			'menu_name'			=> __( 'Programs of Study' )
		);
		
		$taxonomies = array();
		
		$supports = array('title','revisions','thumbnail' );
		
		$post_type_args = array(
			'labels' 			=> $labels,
			'singular_label' 	=> __('Program of Study'),
			'public' 			=> true,
			'show_ui' 			=> true,
			'publicly_queryable'=> true,
			'query_var'			=> true,
			'capability_type' 	=> 'post',
			'has_archive' 		=> false,
			'hierarchical' 		=> true,
			'rewrite' 			=> array('slug' => 'programs', 'with_front' => false ),
			'supports' 			=> $supports,
			'menu_position' 	=> 5,
			'taxonomies'		=> $taxonomies,
			'show_in_nav_menus' => true
		 );
		 register_post_type('programs',$post_type_args);
	}
	add_action('init', 'register_programs_posttype');

$basicinformation_5_metabox = array( 
	'id' => 'basicinformation',
	'title' => 'Basic Information',
	'page' => array('programs'),
	'context' => 'normal',
	'priority' => 'default',
	'fields' => array(

				array(
					'name' 			=> 'Contact Name',
					'desc' 			=> '',
					'id' 				=> 'ecpt_contact_name',
					'class' 			=> 'ecpt_contact_name',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''				
				),
				array(
					'name' 			=> 'Phone Number',
					'desc' 			=> '',
					'id' 				=> 'ecpt_phonenumber',
					'class' 			=> 'ecpt_phonenumber',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''				
				),
							
				array(
					'name' 			=> 'Email Address',
					'desc' 			=> '',
					'id' 				=> 'ecpt_emailaddress',
					'class' 			=> 'ecpt_emailaddress',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''				
				),
							
				array(
					'name' 			=> 'Application Deadline',
					'desc' 			=> '',
					'id' 				=> 'ecpt_deadline',
					'class' 			=> 'ecpt_deadline',
					'type' 			=> 'textarea',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''				
				),
							
				array(
					'name' 			=> 'Application Requirements',
					'desc' 			=> '',
					'id' 				=> 'ecpt_requirements',
					'class' 			=> 'ecpt_requirements',
					'type' 			=> 'textarea',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''				
				),
				
				array(
					'name' 			=> 'Website',
					'desc' 			=> 'Enter URL you want to link to',
					'id' 				=> 'ecpt_website',
					'class' 			=> 'ecpt_website',
					'type' 			=> 'text',
					'rich_editor' 	=> 1,			
					'max' 			=> 0,
					'std'			=> ''				
				),
				
				array(
					'name' 			=> 'Facebook',
					'desc' 			=> '',
					'id' 				=> 'ecpt_facebook',
					'class' 			=> 'ecpt_facebook',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''				
				),				
				
				array(
					'name' 			=> 'Twitter',
					'desc' 			=> '',
					'id' 				=> 'ecpt_twitter',
					'class' 			=> 'ecpt_twitter',
					'type' 			=> 'text',
					'rich_editor' 	=> 0,			
					'max' 			=> 0,
					'std'			=> ''				
				),
				)
);			
			
add_action('admin_menu', 'ecpt_add_basicinformation_5_meta_box');
function ecpt_add_basicinformation_5_meta_box() {

	global $basicinformation_5_metabox;		

	foreach($basicinformation_5_metabox['page'] as $page) {
		add_meta_box($basicinformation_5_metabox['id'], $basicinformation_5_metabox['title'], 'ecpt_show_basicinformation_5_box', $page, 'normal', 'default', $basicinformation_5_metabox);
	}
}

// function to show meta boxes
function ecpt_show_basicinformation_5_box()	{
	global $post;
	global $basicinformation_5_metabox;
	global $ecpt_prefix;
	global $wp_version;
	
	// Use nonce for verification
	echo '<input type="hidden" name="ecpt_basicinformation_5_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($basicinformation_5_metabox['fields'] as $field) {
		// get current post meta data

		$meta = get_post_meta($post->ID, $field['id'], true);
		
		echo '<tr>',
				'<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
				'<td class="ecpt_field_type_' . str_replace(' ', '_', $field['type']) . '">';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '', stripslashes($field['desc']);
				break;
			case 'textarea':
			
				if($field['rich_editor'] == 1) {
						echo wp_editor($meta, $field['id'], array('textarea_name' => $field['id'], 'wpautop' => false)); }
					 else {
					echo '<div style="width: 100%;"><textarea name="', $field['id'], '" class="', $field['class'], '" id="', $field['id'], '" cols="60" rows="8" style="width:97%">', $meta ? $meta : $field['std'], '</textarea></div>', '', stripslashes($field['desc']);				
				}
				
				break;			
		}
		echo     '<td>',
			'</tr>';
	}
	
	echo '</table>';
}	

// Save data from meta box
add_action('save_post', 'ecpt_basicinformation_5_save');
function ecpt_basicinformation_5_save($post_id) {
	global $post;
	global $basicinformation_5_metabox;
	
	// verify nonce
	if (!isset($_POST['ecpt_basicinformation_5_meta_box_nonce']) || !wp_verify_nonce($_POST['ecpt_basicinformation_5_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	foreach ($basicinformation_5_metabox['fields'] as $field) {
	
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		
		if ($new && $new != $old) {
			if($field['type'] == 'date') {
				$new = ecpt_format_date($new);
				update_post_meta($post_id, $field['id'], $new);
			} else {
				if(is_string($new)) {
					$new = $new;
				} 
				update_post_meta($post_id, $field['id'], $new);
				
				
			}
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
function register_degree_type_tax() {
		$labels = array(
			'name' 					=> _x( 'Degree Types', 'taxonomy general name' ),
			'singular_name' 		=> _x( 'Degree Type', 'taxonomy singular name' ),
			'add_new' 				=> _x( 'Add New Degree Type', 'Degree Type'),
			'add_new_item' 			=> __( 'Add New Degree Type' ),
			'edit_item' 			=> __( 'Edit Degree Type' ),
			'new_item' 				=> __( 'New Degree Type' ),
			'view_item' 			=> __( 'View Degree Type' ),
			'search_items' 			=> __( 'Search Degree Types' ),
			'not_found' 			=> __( 'No Degree Type found' ),
			'not_found_in_trash' 	=> __( 'No Degree Type found in Trash' ),
		);
		
		$pages = array('programs');
					
		$args = array(
			'labels' 			=> $labels,
			'singular_label' 	=> __('Degree Type'),
			'public' 			=> true,
			'show_ui' 			=> true,
			'hierarchical' 		=> true,
			'show_tagcloud' 	=> false,
			'show_in_nav_menus' => false,
			'rewrite' 			=> array('slug' => 'degree', 'with_front' => false ),
		 );
		register_taxonomy('degree_type', $pages, $args);
	}
	add_action('init', 'register_degree_type_tax');

function check_degree_type_terms(){
 
        // see if we already have populated any terms
    $term = get_terms( 'degree_type', array( 'hide_empty' => false ) );
 
    // if no terms then lets add our terms
    if( empty( $term ) ){
        $terms = define_degree_type_terms();
        foreach( $terms as $term ){
            if( !term_exists( $term['name'], 'degree_type' ) ){
                wp_insert_term( $term['name'], 'degree_type', array( 'slug' => $term['slug'] ) );
            }
        }
    }
}

add_action( 'init', 'check_degree_type_terms' );

function define_degree_type_terms(){
 
$terms = array(
		'0' => array( 'name' => 'Ph.D.','slug' => 'phd'),
		'1' => array( 'name' => 'M.F.A.','slug' => 'mfa'),
		'2' => array( 'name' => 'M.S.E.','slug' => 'mse'),
		'3' => array( 'name' => 'M.A.','slug' => 'ma'),
		'4' => array( 'name' => 'M.S.','slug' => 'ms'),
		'5' => array( 'name' => 'M.S.E.M.','slug' => 'msem'),
    );
 
    return $terms;
}

function register_school_tax() {
		$labels = array(
			'name' 					=> _x( 'Schools', 'taxonomy general name' ),
			'singular_name' 		=> _x( 'School', 'taxonomy singular name' ),
			'add_new' 				=> _x( 'Add New School', 'School'),
			'add_new_item' 			=> __( 'Add New School' ),
			'edit_item' 			=> __( 'Edit School' ),
			'new_item' 				=> __( 'New School' ),
			'view_item' 			=> __( 'View School' ),
			'search_items' 			=> __( 'Search Schools' ),
			'not_found' 			=> __( 'No School found' ),
			'not_found_in_trash' 	=> __( 'No School found in Trash' ),
		);
		
		$pages = array('programs');
					
		$args = array(
			'labels' 			=> $labels,
			'singular_label' 	=> __('School'),
			'public' 			=> true,
			'show_ui' 			=> true,
			'hierarchical' 		=> true,
			'show_tagcloud' 	=> false,
			'show_in_nav_menus' => false,
			'rewrite' 			=> array('slug' => 'school', 'with_front' => false ),
		 );
		register_taxonomy('school', $pages, $args);
	}
	add_action('init', 'register_school_tax');

function check_school_terms(){
 
        // see if we already have populated any terms
    $term = get_terms( 'school', array( 'hide_empty' => false ) );
 
    // if no terms then lets add our terms
    if( empty( $term ) ){
        $terms = define_school_terms();
        foreach( $terms as $term ){
            if( !term_exists( $term['name'], 'school' ) ){
                wp_insert_term( $term['name'], 'school', array( 'slug' => $term['slug'] ) );
            }
        }
    }
}

add_action( 'init', 'check_school_terms' );

function define_school_terms(){
 
$terms = array(
		'0' => array( 'name' => 'Arts and Sciences','slug' => 'ksas'),
		'1' => array( 'name' => 'Engineering','slug' => 'wse'),
		'2' => array( 'name' => 'Centers','slug' => 'center'),
    );
 
    return $terms;
}

add_filter( 'manage_edit-program_columns', 'my_program_columns' ) ;

function my_program_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'degrees' => __( 'Program Type' ),
		'affiliation' => __( 'Affiliation' ),
		'date' => __( 'Date' ),
	);

	return $columns;
}

add_action( 'manage_studyfields_posts_custom_column', 'my_manage_program_columns', 10, 2 );

function my_manage_program_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'program_type' column. */

		case 'degrees' :

			/* Get the program_types for the post. */
			$terms = get_the_terms( $post_id, 'degree_type' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'degree_type' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'degree_type', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( 'No Degrees Assigned' );
			}

			break;
		case 'affiliation' :

			/* Get the program_types for the post. */
			$terms = get_the_terms( $post_id, 'school' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'school' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'school', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( 'No School Assigned' );
			}

			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}


?>