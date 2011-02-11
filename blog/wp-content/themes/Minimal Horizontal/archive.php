<?php get_header(); ?>

		<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
 			<div class="post">
 				<div class="date"><?php the_time('m.d.y'); ?></div>
 				<a class="posttitle" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
 				<div class="postcontent">
 					<?php the_content(''); ?>
 				</div>
 				<a class="readmore" href="<?php the_permalink(); ?>">Read More</a>
 			</div>
		<?php endwhile; ?>
			<div id="end">
 				<?php next_posts_link('Older') ?>
 				<?php previous_posts_link('Newer') ?>
 			</div>

	<?php else : ?>

		<div class="post">
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</div>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
