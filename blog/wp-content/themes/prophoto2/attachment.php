<?php get_header() ?>

	<div id="container">
		
		<div id="content">

<?php the_post() ?>

			<div id="post-<?php the_ID(); ?>" class="entry-post self-clear <?php sandbox_post_class(); ?>">
				
				<h1 class="entry-title"><a href="<?php echo wp_get_attachment_url($post->ID) ?>"><?php the_title() ?></a></h1>
				
				<div class="entry-content self-clear">
					
					<div class="entry-attachment"><a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo wp_specialchars( get_the_title($post->ID), 1 ) ?>" rel="attachment"><img src="<?php echo wp_get_attachment_url($post->ID) ?>" /></a></div>
					<div class="entry-caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt() ?></div>

					
				</div>
				
				<div class="entry-meta">
					
					<?php p2_single_the_meta(); ?>

				</div><!-- .entry-meta -->
				
			</div><!-- .post -->


<?php p2_nav_sidebar_footer(); ?>

