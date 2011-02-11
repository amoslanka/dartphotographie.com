<div id="leftsider">
	<div id="mainmenu" class="menu">
	<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
	<span class="tagline"><?php bloginfo('description'); ?></span><br /><br />
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Main Sidebar') ) : else : ?>
		<?php endif; /* END FOR WIDGETS CALL */ ?>
	</div>
</div>
