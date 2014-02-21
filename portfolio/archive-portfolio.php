<?php get_header(); ?>
		 <section class="portfolio contain">
			<?php if (have_posts()) : ?>
			
		<?php while (have_posts()) : the_post(); ?>
			
			<div class="card">
				<?php the_post_thumbnail('jlc_project'); ?>
				<h3><?php the_title(); ?></h3>
				<p><?php echo get_the_excerpt(); ?> <a href="<?php the_permalink(); ?>">read more...</a></p>
			</div>

		<?php endwhile; ?>

		<?php endif; ?>
		
		</section>

<?php get_footer(); ?>

