<?php get_header(); ?>

	<div id="content">
		
<?php if ( have_posts() ) : ?>

		<h2 class="page-title"><?php p2_translate('search_results'); ?> <span><?php the_search_query() ?></span></h2>

<?php // found some results? loop it up
	while ( have_posts() ) : the_post() ?>
	
		<div id="post-<?php the_ID(); ?>" class="entry-post self-clear">
			
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(__('Permalink to %s', 'P2'), wp_specialchars(get_the_title(), 1)); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			
			<div class="entry-meta entry-meta-top">
				
				<p><?php if ( 'page' != $post->post_type ) {  // don't show meta for Page results
				 			p2_the_day(); 
				 			p2_the_time(); 
							p2_the_categories( 'top' ); 
						} ?></p>
					
			</div><!-- .entry-meta-top -->
				
				<div class="entry-content self-clear">
					
					<?php p2_print_content_or_excerpt( 'search' ); ?>
					
				</div><!-- .entry content --> 
				
				<?php p2_the_meta(); ?> 
		
		</div><!-- #post-<?php the_ID(); ?>-->
		
<?php endwhile; ?>	

<?php else : // no results ?>

			<div id="post-0" class="post no-results not-found">
				
				<h2 class="entry-title"><?php p2_translate('search_notfound_header') ?></h2>
				
				<div class="entry-content">
					
					<p><?php p2_translate('search_notfound_text') ?></p>
					
				</div>
				
				<form id="searchform-no-results" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
					<div>
						
						<input id="s-no-results" name="s" class="text" type="text" value="<?php the_search_query() ?>" size="40" />
						
						<input class="button" type="submit" value="<?php p2_translate('search_notfound_button') ?>" />
						
					</div>
					
				</form>
				
			</div><!-- .post -->

<?php endif; ?>	

<?php p2_nav_sidebar_footer(); ?>