<?php get_header(); ?>

		<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
 			<div class="post">
 				<div class="date"><?php the_time('m.d.y'); ?></div>
 				<a class="posttitle" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
 				<div class="postcontent2">
 					<?php the_content(''); ?>
 				</div>
 			</div>
<?php comments_template(); ?>
		<?php endwhile; ?>

	<?php else : ?>

		<div class="post">
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</div>

	<?php endif; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
