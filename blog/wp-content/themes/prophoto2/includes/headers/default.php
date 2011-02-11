	<div id="masthead" class="self-clear">	
		<div id="logo">
			<a href="<?php echo get_option('home') ?>/" title="<?php bloginfo('name') ?>" rel="home" id="logoimg">
				<img src="<?php p2_imageurl('logo'); ?>" <?php p2_imageHTML('logo'); ?> alt="<?php bloginfo('name') ?> logo" />
			</a>
			<<?php echo $h; ?>><a href="<?php echo get_option('home') ?>/" title="<?php bloginfo('name') ?>" rel="home"><?php bloginfo( 'name' ) ?></a></<?php echo $h; ?>>
			<p><?php bloginfo('description') ?></p>		
		</div><!-- #logo -->
		<div id="flash-header">
			<img src="<?php p2_imageurl('flashheader1'); ?>" <?php p2_imageHTML( 'flashheader1' ); ?> alt="" />
		</div><!-- #flash-header -->
	</div><!-- #masthead -->	
	<?php include ( TEMPLATEPATH . '/includes/nav.php'); ?>