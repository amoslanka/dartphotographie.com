<?php get_header(); ?>

	<div id="content">
		
<?php the_post(); ?>		
		
		<h2 class="page-title author"<?php 
		$authordesc = $authordata->user_description; 
		if ( !empty($authordesc) ) { 
			echo ' style="margin-bottom:';
			echo p2_option( 'archive_h2_margin_below', 0) / 3;
			echo 'px !important;"';
		} ?>><?php 
			if ( ( $authordata->user_url == 'http://' ) || ( $authordata->user_url == '' ) ) echo p2_option( 'translate_author_archives', 0 ) . ' ' . $authordata->display_name;
			else echo p2_option( 'translate_author_archives', 0 ) . ' <a href="' . $authordata->user_url. '">' . $authordata->display_name . '</a>';
		?></h2>
		
		<?php if ( !empty($authordesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . wpautop($authordesc) . '</div>' ); ?>
		
<?php rewind_posts(); ?>
		
<?php while ( have_posts() ) : the_post() // begin loop  ?>
		<div id="post-<?php the_ID(); ?>" class="entry-post self-clear">
			
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(__('Permalink to %s', 'P2'), wp_specialchars(get_the_title(), 1)); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			
			<div class="entry-meta entry-meta-top">
				
				<p>	<?php p2_the_day(); ?>
					<?php p2_the_time(); ?>
					<?php p2_the_categories( 'top' ); ?></p>
					
			</div><!-- .entry-meta-top -->
				
				<div class="entry-content self-clear">
					
					<?php p2_print_content_or_excerpt( 'author' ); ?>
					
				</div><!-- .entry content -->  
				
				<?php p2_the_meta(); ?>
		
		<?php p2_the_comments(); ?>		
		
		</div><!-- #post-<?php the_ID(); ?>-->
		
<?php endwhile; // end loop?>
		
<?php p2_nav_sidebar_footer(); ?>