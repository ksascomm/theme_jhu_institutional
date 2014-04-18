	<nav class="three columns hide-for-print pull-nine" role="navigation" id="sidebar"> <!-- Begin Sidebar -->
		 	<!-- Start Navigation for Sibling Pages -->	
			<?php 
				wp_reset_query();
				if( is_page() || is_singular() || is_tax() ) { 
					global $post;
						$the_id = $post->ID;
				        $ancestors = get_post_ancestors( $post->ID ); // Get the array of ancestors
				        	//Get the top-level page slug for sidebar/widget content conditionals
							$ancestor_id = ($ancestors) ? $ancestors[count($ancestors)-1]: $post->ID;
					        $the_ancestor = get_page( $ancestor_id );
					        $ancestor_url = $the_ancestor->guid;
					        $ancestor_title = $the_ancestor->post_title;
				     //If there are no ancestors display a menu of children
								?>						
							<div class="offset-gutter" id="sidebar_header">
								<h5 class="grey">Also in <a href="<?php echo $ancestor_url;?>" class="white bold"><?php echo $ancestor_title; ?></a></h5>
							</div>
							<?php 
								wp_nav_menu( array( 
									'theme_location' => 'main_nav', 
									'menu_class' => 'nav', 
									'container_class' => 'offset-gutter',
									'sub_menu' => true,
								));
							} ?>
					
	</nav> <!-- End Sidebar -->