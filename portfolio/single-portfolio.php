<?php get_header(); ?>


	<section class="project">
			<?php if (have_posts()) : ?>
					
				<?php while (have_posts()) : the_post(); ?>
				
						<h2><?php the_title(); ?></h2>

							<?php the_post_thumbnail('jlc_project'); ?>
						
							<?php the_content('Read the rest of this entry &raquo;'); ?>

							<?php
								if(function_exists('jlc_projects_get_link')){
									$jlc_link= jlc_projects_get_link($post->ID);

									if($jlc_link){
							?>
									<a href="<?php print $jlc_link; ?>" class="button">Visit the Site</a>
							<?php 
									}
								} ?>

				<?php endwhile; ?>

		<?php endif; ?>
	</section>
<?php get_footer(); ?>
