<?php get_header(); ?>

	<div id="content">
	

			<div id="post-0" class="error404 post no-results not-found">
				
				<h2 class="entry-title"><?php p2_translate( '404_header' ) ?></h2>
				
				<div class="entry-content">
					
					<p><?php p2_translate( '404_text' ) ?></p>
					
				</div>
				
				<form id="searchform-no-results" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
					<div>
						
						<input id="s-no-results" name="s" class="text" type="text" value="<?php the_search_query() ?>" size="40" />
						
						<input class="button" type="submit" value="<?php p2_translate( 'search_notfound_button' ) ?>" />
						
					</div>
					
				</form>
				
			</div><!-- .post -->


<?php p2_nav_sidebar_footer(); ?>