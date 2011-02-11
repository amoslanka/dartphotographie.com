<?php get_header(); ?>

	<div id="content">
		
<?php while ( have_posts() ) : the_post()  // begin loop ?>
	
		<div id="post-<?php the_ID(); ?>" class="entry-post self-clear <?php sandbox_post_class() ?>">
			
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(__('Permalink to %s', 'P2'), wp_specialchars(get_the_title(), 1)); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			
			<div class="entry-meta entry-meta-top">
				
				<p>	<?php p2_the_day(); ?>
					<?php p2_the_time(); ?>
					<?php p2_the_categories( 'top' ); ?></p>
					
			</div><!-- .entry-meta-top -->
				
				<div class="entry-content self-clear">
					
					<?php p2_print_content_or_excerpt( 'index' ); ?>
					
				</div><!-- .entry content -->  
				
				<?php p2_the_meta(); ?>
			
				<?php p2_the_comments(); ?>

		</div><!-- #post-<?php the_ID(); ?>-->
		
<?php endwhile; // end loop ?>

<?php p2_nav_sidebar_footer(); ?>