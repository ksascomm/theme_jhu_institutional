  <footer>
  	<div class="row hide-for-print">
  		<?php //Check Theme Options for Quicklinks setting 
	  		//Quicklinks Menu
	  		wp_nav_menu( array( 
				'theme_location' => 'quick_links', 
				'menu_class' => 'nav-bar', 
				'fallback_cb' => 'foundation_page_menu', 
				'container' => 'nav', 
				'container_id' => 'quicklinks',
				'container_class' => 'three mobile-four column hide-for-small', 
				'walker' => new foundation_navigation() ) ); 
						
			//Footer Links
			 wp_nav_menu( array( 
				'theme_location' => 'footer_links', 
				'menu_class' => 'inline-list hide-for-small', 
				'fallback_cb' => 'foundation_page_menu', 
				'container' => 'nav', 
				'container_class' => 'six column', 
				'walker' => new foundation_navigation() ) ); 
		 
			//Social Media Icons
			 wp_nav_menu( array( 
				'theme_location' => 'social_media', 
				'menu_class' => '', 
				'fallback_cb' => 'foundation_page_menu', 
				'container' => 'nav', 
				'container_class' => 'two column iconfont hide-for-small', 
				'container_id'	=> 'social-media',
				'items_wrap' => '%3$s',
				'walker' => new social_media_menu() ) ); 
		?>
		
		<!-- Copyright and Address -->
		<div class="row" id="copyright" role="content-info">
  			<p>&copy; <?php print date('Y'); ?> Johns Hopkins University, 
  				<?php $theme_option = flagship_sub_get_global_options();
  				echo $theme_option['flagship_sub_copyright'];?></p>
  		</div>
  		<div class="row">
	  		<div class="four columns centered">
  				<a href="http://www.jhu.edu" title="Johns Hopkins University homepage"><img src="<?php echo get_template_directory_uri() ?>/assets/images/university.jpg" /></a>
  			</div>
  		</div>

  	</div>
  </footer>
  
  <?php //Call all the javascript
  		get_template_part('parts', 'script-initiators');
  		wp_footer(); ?>
	</body>
</html>