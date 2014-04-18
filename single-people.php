<?php get_header(); ?>
<div class="row sidebar_bg" id="page">
	<div class="nine columns wrapper offset-topgutter push-three">	
		<section class="content">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="four columns">
				<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('full'); ?>
					<?php } ?>			    
					<h4><?php the_title() ?></h4>
			    <h6><?php echo get_post_meta($post->ID, 'ecpt_position', true); ?></h6>
			
			    <p class="listing">
			    	<?php if ( get_post_meta($post->ID, 'ecpt_office', true) ) : ?>
			    		<span class="icon-location"></span><?php echo get_post_meta($post->ID, 'ecpt_office', true); ?><br>
			    	<?php endif; ?>
			    
			    	<?php if ( get_post_meta($post->ID, 'ecpt_hours', true) ) : ?>
			    		<span class="icon-calendar-2"></span><?php echo get_post_meta($post->ID, 'ecpt_hours', true); ?><br>
			    	<?php endif; ?>
			    
			    	<?php if ( get_post_meta($post->ID, 'ecpt_phone', true) ) : ?>
			    		<span class="icon-mobile"></span><?php echo get_post_meta($post->ID, 'ecpt_phone', true); ?><br>
			    	<?php endif; ?>
			    
			    	<?php if ( get_post_meta($post->ID, 'ecpt_fax', true) ) : ?>
			    		<span class="icon-printer"></span><?php echo get_post_meta($post->ID, 'ecpt_fax', true); ?><br>
			    	<?php endif; ?>
			    
			    	<?php if ( get_post_meta($post->ID, 'ecpt_email', true) ) : $email = get_post_meta($post->ID, 'ecpt_email', true); ?>
											<span class="icon-mail"></span><a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;<?php echo email_munge($email); ?>">
											
											<?php echo email_munge($email); ?> </a><br>
										<?php endif; ?>
			    	
			    	<?php if ( get_post_meta($post->ID, 'ecpt_cv', true) ) : ?>
			    		<a href="<?php echo get_post_meta($post->ID, 'ecpt_cv', true); ?>"><span class="icon-file-pdf"></span>Curriculum Vitae</a><br>
			    	<?php endif; ?>
			    
			    	<?php if ( get_post_meta($post->ID, 'ecpt_website', true) ) : ?>
			    		<a href="<?php echo get_post_meta($post->ID, 'ecpt_website', true); ?>" target="_blank"><span class="icon-globe"></span>Personal Website</a><br>
			    	<?php endif; ?>
			    	<?php if ( get_post_meta($post->ID, 'ecpt_lab_website', true) ) : ?>
			    		<a href="<?php echo get_post_meta($post->ID, 'ecpt_lab_website', true); ?>" target="_blank"><span class="icon-globe"></span>Group Website</a>
			    	<?php endif; ?>
			    </p>
			</div>

			<dl class="tabs mobile eight columns">
				<?php if ( get_post_meta($post->ID, 'ecpt_bio', true) ) : ?><dd class="active"><a href="#bio">Biography</a></dd><?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_research', true) ) : ?><dd><a href="#research">Research</a></dd><?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_teaching', true) ) : ?><dd><a href="#teaching">Teaching</a></dd><?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_publications', true) : ?><dd><a href="#publications">Publications</a></dd><?php endif; ?>
				<?php if ( get_post_meta($post->ID, 'ecpt_extra_tab_title', true) ) : ?><dd><a href="#extra"><?php echo get_post_meta($post->ID, 'ecpt_extra_tab_title', true); ?></a></dd><?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_extra_tab_title2', true) ) : ?><dd><a href="#extra2"><?php echo get_post_meta($post->ID, 'ecpt_extra_tab_title2', true); ?></a></dd><?php endif; ?>			  
			</dl>
			
			<ul class="tabs-content eight columns">				
			<?php if ( get_post_meta($post->ID, 'ecpt_bio', true) ) : ?>
					<li class="active" id="bioTab">
						<?php echo get_post_meta($post->ID, 'ecpt_bio', true); ?>
					</li>
				<?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_research', true) ) : ?>
					<li id="researchTab"><?php echo get_post_meta($post->ID, 'ecpt_research', true); ?></li>
				<?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_teaching', true) ) : ?>
					<li id="teachingTab"><?php echo get_post_meta($post->ID, 'ecpt_teaching', true); ?></li>
				<?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_publications', true) || get_post_meta($post->ID, 'ecpt_microsoft_id', true) || get_post_meta($post->ID, 'ecpt_google_id', true) ) : ?>
					<li id="publicationsTab">
						<?php if ( get_post_meta($post->ID, 'ecpt_publications', true) ) : echo get_post_meta($post->ID, 'ecpt_publications', true); endif; ?>
					</li>
				<?php endif; ?>
				<?php if ( get_post_meta($post->ID, 'ecpt_extra_tab', true) ) : ?>
					<li id="extraTab"><?php echo get_post_meta($post->ID, 'ecpt_extra_tab', true); ?></li>
				<?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_extra_tab2', true) ) : ?>
					<li id="extra2Tab"><?php echo get_post_meta($post->ID, 'ecpt_extra_tab2', true); ?></li>
				<?php endif; ?>			
			</ul>
			<?php endwhile; endif; ?>	
		</section>
	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-sidebar-nav.php', true, false); ?>
</div> <!-- End #landing -->
<?php get_footer(); ?>