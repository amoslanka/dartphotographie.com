<?php get_header(); ?>
	
	<div id="content">
		
<?php the_post() ?>

<?php if ( is_day() ) : ?>
			<h2 class="page-title"><?php printf( __( 'Daily Archives: <span>%s</span>', 'P2' ), get_the_time(get_option('date_format')) ) ?></h2>
<?php elseif ( is_month() ) : ?>
			<h2 class="page-title"><?php printf( __( p2_translate('archives_monthly', false) . ' <span>%s</span>', 'P2' ), get_the_time('F Y') ) ?></h2>
<?php elseif ( is_year() ) : ?>
			<h2 class="page-title"><?php printf( __( p2_translate('archives_yearly', false) . ' <span>%s</span>', 'P2' ), get_the_time('Y') ) ?></h2>
<?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
			<h2 class="page-title"><?php p2_translate('blog_archives') ?></h2>
<?php endif; ?>

<?php rewind_posts() ?>
		
<?php while ( have_posts() ) : the_post() // begin loop ?>
		<div id="post-<?php the_ID(); ?>" class="entry-post self-clear">
			
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(__('Permalink to %s', 'P2'), wp_specialchars(get_the_title(), 1)); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			
			<div class="entry-meta entry-meta-top">
				
				<p>	<?php p2_the_day(); ?>
					<?php p2_the_time(); ?>
					<?php p2_the_categories( 'top' ); ?></p>
					
			</div><!-- .entry-meta-top -->
				
				<div class="entry-content self-clear">
					
					<?php p2_print_content_or_excerpt( 'archive' ); ?>
					
				</div><!-- .entry content -->  
				
				<?php p2_the_meta(); ?>
		
		<?php p2_the_comments(); ?>		
		
		</div><!-- #post-<?php the_ID(); ?>-->
		
<?php endwhile; // end loop ?>	
	
<?php p2_nav_sidebar_footer(); ?>