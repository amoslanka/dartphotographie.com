// do not edit this file, it is created by the theme, any edits will be lost

	// throb text "loading message" for (hopefully) long enough to load contact form
function p2_throb() {
	jQuery('#contact-throbber').fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1).fadeTo(200, .5).fadeTo(200, 1);
}


// Load if needed (ajax) and toggle contact form display
function p2_toggle_contactform(delay) {
	if (delay == undefined) delay = 500;
	var a = jQuery('#p2-contact-click').html();
	jQuery('#p2-contact-click a').remove();
	jQuery("<a id='contact-throbber'>Loading</a>").appendTo('#p2-contact-click');
	p2_throb();
	jQuery('#contact-form').load('http://dartphotographie.com/blog/wp-content/themes/prophoto2/includes/contact.php', function(){
		jQuery('#p2-contact-click a').remove();
		jQuery(a).appendTo('#p2-contact-click');
		jQuery('#contact-form').slideToggle(delay);
		p2_contactform_loaded = true;
		jQuery('#referpage').val(window.location); // update hidden field location with page URL
		jQuery('#p2-nav-contact').unbind('click').click(function(){
			jQuery('#contact-form').slideToggle(500);
		})
	});
}
	
sfHover = function() {
	var sfEls = document.getElementById("topnav").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover); // for MSIE only


jQuery(document).ready(function(){
		
		jQuery(".comments-count").click(function(){
		$thisclick = jQuery(this);
		var comments_id = "#"+$thisclick.parents(".entry-comments").attr("id");
		if ( jQuery(comments_id+" p.comment").size() > 0 ) {
			jQuery(comments_id).toggleClass('comments-count-active');
			jQuery(comments_id+" .comments-body").slideToggle(400);
		}
	});			
		
	 
	jQuery('.comments-count p:not(.no-comments)').mouseover(function(){
		old_hover = jQuery(this).css('color');
		old_dec = jQuery(this).css('text-decoration');
		jQuery(this).css('color', '#514747');
		jQuery(this).css('text-decoration', 'none'); 
	}).mouseout(function(){
		jQuery(this).css('color', old_hover);
		jQuery(this).css('text-decoration', old_dec); 
	});
	
		
	jQuery('#p2-nav-contact').click(function(){
		p2_toggle_contactform(500);
	});	

	var hash = window.location.hash.substr(1);
	if ( hash === 'contact-form' ) {
		p2_toggle_contactform(0);
	}
	
	// handle contact form submission messages
	if ( hash === 'error' ) {
		jQuery("#p2-contact-error")
			.css('display', 'block')
			.animate({opacity: 1.0}, 3500, function(){p2_toggle_contactform(300)})
			.fadeTo(500, 0)
			.slideUp(300);
	}
	if ( hash === 'success' ) {
		jQuery("#p2-contact-success")
			.css('display', 'block')
			.animate({opacity: 1.0}, 3500)
			.fadeTo(500, 0)
			.slideUp(300);
	}
	
	jQuery('a[href*=#contact-form]').click(function(){
		if (jQuery("#contact-form form").size() == 0 ) {
			p2_toggle_contactform();
		} else {
			jQuery('#contact-form').slideDown(500);
		}
	});
		
	jQuery('#topnav li ul a').attr('title', '');
	
	// add arrow to dropdown with nested menu
	jQuery('#topnav li ul li:has(ul)').each(function(){
		$link = jQuery(this).children('a');
		linktext = $link.html();
		$link.html(linktext+" &raquo;");
	});
	// add underline to parent while child is being viewed
	jQuery('#topnav li ul li ul').hover(function(){
		jQuery(this).parent().children('a').css('text-decoration', 'underline');
	},function(){
		jQuery(this).parent().children('a').css('text-decoration', 'none');
	});
	
		if (!jQuery.browser.msie) {	
		jQuery('#topnav li ul').css('opacity', 0.93);
	}
	if (jQuery.browser.msie) {
		if (jQuery('#topnav li ul li:has(ul)').size() == 0) {
			jQuery('#topnav li ul').css('opacity', 0.93);
		}
	}
		
	jQuery('.entry-post:last').css('border', 'none');
	var padding = jQuery('body.single .entry-content').css('padding-bottom');
	jQuery('.entry-post:last').css('padding-bottom', '0');
	jQuery('.entry-post:last').css('background-image', 'none');
			
	jQuery('a#hidden-bio').click(function(){
		 
		jQuery('#bio').slideToggle(350,function(){
			jQuery('#bio-outer').css('display', 'block');
			jQuery('#biocolumns').css('display', 'inline');
			jQuery('.biocolumn').css('display', 'block');
			});
	});	
		if (!jQuery.browser.msie) {	    
	    jQuery(".entry-content img").lazyload({
			effect : "fadeIn",
			threshold : 1500,
			placeholder : "http://dartphotographie.com/blog/wp-content/themes/prophoto2/images/nodefaultimage.gif" 
		});
	}		
		
	
			 
});

// flash header area
var params = {
	FlashVars: "path2xml=http://dartphotographie.com/blog/wp-content/uploads/p2/images.xml?10914",
	bgcolor: "#121212",
	wmode: "opaque"
}
swfobject.embedSWF("http://dartphotographie.com/blog/wp-content/themes/prophoto2/flash/flashheader.swf", "flash-header", "900", "600", "7.0.0", "http://dartphotographie.com/blog/wp-content/themes/prophoto2/flash/expressinstall.swf", false, params);

