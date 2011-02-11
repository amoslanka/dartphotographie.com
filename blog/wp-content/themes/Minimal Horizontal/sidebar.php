 			<div class="clear"></div>
 		</div>
 	</div>
 	<div id="subcontent">
 		<?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		<div class="block">
 			<h5>Categories</h5>
 			<ul>
 				<?php wp_list_categories('title_li='); ?>
 			</ul>
 		</div>
 		<div class="block">
 			<h5>Archives</h5>
 			<ul>
 				<?php wp_get_archives('type=monthly'); ?>
 			</ul>
 		</div>
 		<div class="block">
 			<h5>Pages</h5>
 			<ul>
 				<?php wp_list_pages('title_li='); ?>
 			</ul>
 		</div>
 		<?php endif; ?>
 		<div class="clear"></div>
 	</div>
<div class="clear"></div>
<?php completeTheme(); ?>