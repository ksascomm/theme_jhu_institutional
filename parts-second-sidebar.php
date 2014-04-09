	<aside class="four columns hide-for-print sidebar-right" id="sidebar"> <!-- Begin Sidebar -->
		<!-- Page Specific Sidebar -->
		<?php if ( have_posts()) : while ( have_posts() ) : the_post(); 
				$sidebar = get_post_meta($post->ID, 'ecpt_page_sidebar', true);
				dynamic_sidebar($sidebar);
			endwhile; endif; wp_reset_query();
		?>
	</aside>