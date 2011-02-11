<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> comments RSS Feed" href="<?php bloginfo('comments_rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>
	 <!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie.css"><![endif]-->
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/thw.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-min.js"></script>
	<?php comments_popup_script(); ?>	
	<?php wp_head(); ?>	
	<script type="text/javascript">
	jQuery.noConflict();
	
		jQuery('blockquote').remove();
	</script>
	<?php if (is_page() || is_single()) {?>
	<script type="text/javascript">
	jQuery.noConflict();
	
		jQuery(document).ready(function(){
     	
     	
     	var totalcontent = (jQuery('.entry').outerHeight());
     	var parw = (jQuery('.par').outerWidth());
		var bodyw = (jQuery('body').outerWidth());          
     	var numpar = (Math.ceil(totalcontent/parw));

 
        jQuery('.entry p').slice().wrap("<div class='par'></div>");
        jQuery('.par:first').prepend(jQuery('.entry span.emph'));
        jQuery('.par:first').prepend(jQuery('.entry h2:first'));
        
        if (jQuery('.par').length > 2) {
			jQuery('.entry').width((jQuery('.par').length * '380') + jQuery('#rightsider').width()); 
		
		}else{
			jQuery('.entry').width(3 * 430); 
		}
		jQuery('body').width(jQuery('#content').width() + (jQuery('#leftsider').width() + jQuery('#rightsider').width()));
              
		jQuery('.par').each(function(){
 	   		jQuery(this).append("<p class='secbot'><a href='#mainmenu' title='go left to menu'>return to menu</a></p>");
    	});

	// arrange the thumbnails in a gallery post/page along the bottom
		jQuery('.img_thumb').each(function(){
			jQuery('#bottombar').append(jQuery(this).css("float", "left"));
		});

   });

   
   
	</script>
	<?php }?>
	<?php if (is_home() || is_archive()) {?>
	<script type="text/javascript">
	jQuery.noConflict();
		jQuery(document).ready(function(){	

	if ((jQuery('.par').length > 6)) {
		var numpar = (jQuery('.par').length);
		var parw = (jQuery('.par').outerWidth());
		jQuery('body').width(parseInt(numpar * (parw + (jQuery('#leftsider').width() + jQuery('#rightsider').width()))));
	}
   });	
	</script>
	<?php }?>
  </head>