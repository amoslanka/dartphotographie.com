<?php get_header() ?>

	<div id="container">
		
		<div id="content">

<?php the_post() ?>

			<div id="post-<?php the_ID(); ?>" class="entry-post self-clear <?php sandbox_post_class(); ?>">
				
				<h1 class="entry-title"><?php the_title(); ?></h1>
				
				<div class="entry-meta entry-meta-top">

					<p>	<?php p2_the_day(); ?>
						<?php p2_the_time(); ?>
						<?php p2_the_categories( 'top' ); ?></p>

				</div><!-- .entry-meta-top -->
				
				<div class="entry-content self-clear">
					
					<?php the_content(); ?>
					
				</div>
				
				<div class="entry-meta">
					
					<?php p2_the_meta(); ?>

				</div><!-- .entry-meta -->
				
				<p id="nav-below" class="navigation self-clear">
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> %title' ) ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&raquo;</span>' ) ?></span>
				</p>
				
			</div><!-- .post -->

			<?php p2_the_comments(); ?>

<?php p2_nav_sidebar_footer(); ?>