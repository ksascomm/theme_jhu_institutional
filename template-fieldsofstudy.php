<?php
/*
Template Name: Fields of Study
*/
?>
<?php get_header(); 
	//Set Fields of Study Query Parameters
	if ( false === ( $flagship_programs_query = get_transient( 'flagship_programs_query' ) ) ) {
				// It wasn't there, so regenerate the data and save the transient
				$flagship_programs_query = new WP_Query(array(
					'post_type' => 'programs',
					'orderby' => 'title',
					'order' => 'ASC',
					'posts_per_page' => '-1'));
					set_transient( 'flagship_programs_query', $flagship_programs_query, 2592000 ); } ?>
<div class="row wrapper radius10">
<div class="twelve columns">
	<section class="row">
	
		<div class="five columns copy">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h2><?php the_title();?></h2>
			<p><?php the_content(); ?></p>
		<?php endwhile; endif; ?>
		</div>
		
		<div class="seven columns" id="fields_search" role="search">
			<form action="#">
				<fieldset class="radius10">
					<?php $degrees = get_terms('degree_type', array(
						'orderby'       => 'name', 
						'order'         => 'ASC',
						'hide_empty'    => true, 
						));
						
						$count_degrees =  count($degrees);
						if ( $count_degrees > 0 ) { ?>
					<div class="row">
						<h6>Filter by degree type:</h6>
					</div>							

							<div class="row filter option-set" data-filter-group="degree_type">
									<div class="button radio"><a href="#" data-filter="" class="selected">View All</a></div>
								<?php foreach ( $degrees as $degree ) { ?>
									<div class="button radio"><a href="#" data-filter=".<?php echo $degree->slug; ?>"><?php echo $degree->name; ?></a></div>
								<?php } ?>
							</div>
						<?php } ?>
					<div class="row">
						<h5>Search by keyword:</h5>		
						<input type="submit" class="icon-search" placeholder="Search by name/keyword" value="&#xe004;" />
						<input type="text" name="search" value="" id="id_search" aria-label="Search"  /> 
					</div>
					
					<?php $schools = get_terms('school', array(
						'orderby'       => 'name', 
						'order'         => 'ASC',
						'hide_empty'    => true, 
						));
						
						$count_schools =  count($schools);
						if ( $count_schools > 0 ) { ?>
					<div class="row">
						<h6>Filter by Affiliation:</h6>
					</div>							
					
					<div class="row filter option-set" data-filter-group="affiliation">
									<div class="button radius10 yellow_bg"><a href="#" class="black selected" data-filter="" class="selected">View All</a></div>
								<?php foreach ( $schools as $school ) { ?>
									<div class="button radius10 yellow_bg"><a href="#" class="black" data-filter=".<?php echo $school->slug; ?>"><?php echo $school->name; ?></a></div>
								<?php } ?>
							</div>	
					<?php } ?>				
				</fieldset>
			</form>	
		</div>
	</section>

<section class="row" id="fields_container" role="main">
	<?php while ($flagship_programs_query->have_posts()) : $flagship_programs_query->the_post(); 
		//Pull discipline array (humanities, natural, social)
		$program_types = get_the_terms( $post->ID, 'degree_type' );
			if ( $program_types && ! is_wp_error( $program_types ) ) : 
				$program_type_names = array();
				$degree_types = array();
					foreach ( $program_types as $program_type ) {
						$program_type_names[] = $program_type->slug;
						$degree_types[] = $program_type->name;
					}
				$program_type_name = join( " ", $program_type_names );
				$degree_type = join( ", ", $degree_types );

			endif;
		$schools = get_the_terms( $post->ID, 'school' );
			if ( $schools && ! is_wp_error( $schools ) ) : 
				$school_names = array();
					foreach ( $schools as $school ) {
						$school_names[] = $school->slug;
					}
				$school_name = join( " ", $school_names );
			endif;	?>
		
		<!-- Set classes for isotype.js filter buttons -->
		<div class="six columns mobile-four mobile-field  <?php echo $program_type_name . ' ' . $school_name; ?>">
		
			
				<div class="twelve columns field" id="<?php echo $school_name; ?>">
				<a href="<?php echo get_post_meta($post->ID, 'ecpt_website', true); ?>" title="<?php the_title(); ?>" class="field">
					<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('rss'); ?>
					<?php } ?>			    
					<h3><?php the_title(); ?></h3>
				</a>
					<div class="row">
						<div class="twelve columns">
							<p>
								
									<b>Degrees Offered:</b>&nbsp;<?php echo $degree_type ?><br>
													
								<?php if (get_post_meta($post->ID, 'ecpt_deadline', true)) : ?>
									<b>Application Deadline:</b>&nbsp;<?php echo get_post_meta($post->ID, 'ecpt_deadline', true); ?><br>
								<?php endif; ?>
								<?php if (get_post_meta($post->ID, 'ecpt_requirements', true)) : ?>
									<b>Application Requirements:</b>&nbsp;<?php echo get_post_meta($post->ID, 'ecpt_requirements', true); ?><br>
								<?php endif; ?>
							<?php if (get_post_meta($post->ID, 'ecpt_emailaddress', true)) : ?><b>Contact:</b> <a href="mailto:<?php echo get_post_meta($post->ID, 'ecpt_emailaddress', true); ?>"><?php echo get_post_meta($post->ID, 'ecpt_contact_name', true); ?></a><?php endif; ?>
								
							</p>
							<hr>
							
							<?php if (get_post_meta($post->ID, 'ecpt_emailaddress', true)) : ?><a href="mailto:<?php echo get_post_meta($post->ID, 'ecpt_emailaddress', true); ?>"><span class="icon-mail"></span></a><?php endif; ?>
							<?php if (get_post_meta($post->ID, 'ecpt_facebook', true)) : ?><a href="<?php echo get_post_meta($post->ID, 'ecpt_facebook', true); ?>" title="Facebook"><span class="icon-facebook"></span><span class="hide">Facebook</span></a><?php endif; ?>
							<?php if (get_post_meta($post->ID, 'ecpt_twitter', true)) : ?><a href="<?php echo get_post_meta($post->ID, 'ecpt_twitter', true); ?>" title="Twitter"><span class="icon-twitter"></span><span class="hide">Twitter</span></a><?php endif; ?>
							<?php if (get_post_meta($post->ID, 'ecpt_phonenumber', true)) : ?><a href="tel:<?php echo get_post_meta($post->ID, 'ecpt_phonenumber', true); ?>"><span class="icon-phone"></span><?php echo get_post_meta($post->ID, 'ecpt_phonenumber', true); ?></a><?php endif; ?>
						</div>	
					</div>
				</div>
			</a>
		</div>
	<?php endwhile; ?>
	
	<div class="row" id="noresults">
		<div class="four columns centered">
			<h3> No matching results</h3>
		</div>
	</div>
</section>
</div>
</div> <!-- End content wrapper -->
<?php get_footer(); ?>