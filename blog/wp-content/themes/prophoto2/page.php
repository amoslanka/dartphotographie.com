<?php get_header(); ?>
	
	<div id="content">
		
<?php the_post(); ?>

		<div id="post-<?php the_ID(); ?>" class="entry-post self-clear <?php sandbox_post_class() ?>">
			
			<h1 class="entry-title"><?php the_title(); ?></h1>
				
				<div class="entry-content self-clear">
					
					<?php the_content(); ?>
					
					<?php edit_post_link( 'Edit', '<p class="edit-link">', '</p>'); ?>
					
				</div><!-- .entry content -->  
			
<?php // Add a key+value of "comments" to enable comments on a page
if ( get_post_custom_values('comments') ) p2_the_comments(); ?>

		</div><!-- #post-<?php the_ID(); ?>-->
			
<?php p2_nav_sidebar_footer(); ?>