	<div id="sidebar-footer" class="self-clear">
		<div id="primary" class="sidebar">
			<ul class="top-level-sidebar">
				<?php p2_footer_subscribe( 'left' ); ?>				
	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : // begin primary sidebar widgets ?>
				<li id="search">
					<h3><label for="s"><?php p2_option( 'nav_search_dropdown_linktext' ); ?></label></h3>
					<form id="searchform" method="get" action="<?php bloginfo('home') ?>">
						<div>
							<input id="s" name="s" class="text-input" type="text" value="<?php the_search_query() ?>" size="13" tabindex="1" accesskey="S" />
							<input id="searchsubmit" class="submit-button" name="searchsubmit" type="submit" value="<?php p2_translate('search_notfound_button') ?>" tabindex="2" />
						</div>
					</form>
				</li>
				
				<li id="pages">
					<h3><?php p2_option( 'navpagestitle' ) ?></h3>
					<ul>
	<?php wp_list_pages('title_li=&sort_column=post_title' ) ?>
					</ul>
				</li>
				
				<li id="categories">
					<h3><?php p2_option( 'navcategoriestitle' ) ?></h3>
					<ul>
	<?php wp_list_categories('title_li=&show_count=0&hierarchical=1') ?> 

					</ul>
				</li>
				
	<?php endif; // end primary sidebar widgets  ?>
			</ul>
		</div><!-- #primary .sidebar -->

		<div id="secondary" class="sidebar">
			<ul class="top-level-sidebar">
				<?php p2_footer_subscribe( 'middle' ); ?>	
	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : // begin  secondary sidebar widgets ?>
				<li id="rss-links">
					<h3><?php _e('RSS Feeds', 'P2') ?></h3>
					<ul>
						<li><a href="<?php p2_rss() ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> <?php _e('Posts RSS feed', 'P2'); ?>" rel="alternate" type="application/rss+xml"><?php _e('All posts', 'P2') ?></a></li>
						<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> <?php _e('Comments RSS feed', 'P2'); ?>" rel="alternate" type="application/rss+xml"><?php _e('All comments', 'P2') ?></a></li>
					</ul>
				</li>
				
	<?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>&show_images=1') ?>
				
	<?php endif; // end secondary sidebar widgets  ?>
			</ul>
		</div><!-- #secondary .sidebar -->
		<div id="tertiary" class="sidebar">
			<ul class="top-level-sidebar">
				<?php p2_footer_subscribe( 'right' ); ?>	
	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(3) ) : // begin tertiary sidebar widgets ?>
				<li id="archives">
					<h3><?php p2_option( 'navarchivestitle' ); ?></h3>
					<ul>
	<?php wp_get_archives('type=monthly') ?>

					</ul>
				</li>
				<li id="meta">
					<h3><?php _e('Meta', 'P2') ?></h3>
					<ul>
						<?php wp_register() ?>

						<li><?php wp_loginout() ?></li>
						<?php wp_meta() ?>

					</ul>
				</li>
		
	<?php endif; // end secondary sidebar widgets  ?>
			</ul>
		</div><!-- #tertiary .sidebar -->
	</div> <!-- #sidebar-footer  -->