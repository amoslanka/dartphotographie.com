/* Scripts for the Upload page */

jQuery(document).ready(function() {
	jQuery('.click-for-explain').tTips();
	
	// display p2 news
	if ( p2_external_explain['p2_news'] != undefined ) {
		jQuery('.wrap h2').after(p2_external_explain['p2_news']);
	}
	
	
	// inline documentation hide/reveal links
	jQuery('a.click-for-explain').click(function(){
		$thisclick = jQuery(this);
		var speed = 1;
		if ( $thisclick.hasClass('help-active') ) {
			speed = 130;
		}
		$thisclick.toggleClass('help-active');
		var id = $thisclick.attr('id').replace('-cfe','');
		// build the text
		if ( p2_external_explain[id] == undefined ) {
			p2_external_explain[id] = '';
		}
		var second_para = '<p class="explain-link">Need more help with this specific area? We got it. <a href="http://www.prophotoblogs.com/support/'+p2_external_slugs[id]+'/" target="_blank">Click here</a>.</p>';
		if ( p2_external_slugs[id] == undefined ) {
			second_para = '';
		}
		var help = p2_external_explain[id] + second_para;
		jQuery('#explain-' + id)
			.html(help)
			.animate({opacity: 0}, speed) 
			.slideToggle(185)
			.animate({opacity: 1}, 130);
	});
	
});



// what: url, where: shortname
function p2_update_theme_image(url, shortname, width, height, size, show_reset) {

	// Special case: if the new image is 'logo', we reload the page
	if (shortname == 'logo') {
		window.location.href=window.location.href;
		// or:
		// window.location.reload()
		// history.go(0)
	}
	
	// Update the image src
	jQuery('#p2_image_'+shortname)
		.fadeOut(250, function() {
			jQuery(this)
				.attr('src', url+'?' + Math.random())
				.fadeIn(250);
			if (width >= 475) {
				jQuery(this)
					.attr('width', '475')
					.next('p.p2_widthmsg').html("Not shown <a href=\"" +url + "\">fullsize</a>");
			} else {
				jQuery(this)
					.attr('width', width)
					.next('p.p2_widthmsg').html("");

			}			
		});

	// Update the image informations
	jQuery('#p2_imginfos_'+shortname+' .p2_imginfos_width').html(width);
	jQuery('#p2_imginfos_'+shortname+' .p2_imginfos_height').html(height);
	jQuery('#p2_imginfos_'+shortname+' .p2_imginfos_size').html(size);
	jQuery('#p2_imginfos_'+shortname+' .p2_imginfos_url a').attr('href', url);
	

	// if the new image has recommendations
	if (jQuery('#p2_recommendation_'+shortname).length) {
		// in #p2_flashheader_shortname: update classname of p2_recommended p2_recommended:W:H
		var actual = jQuery('#p2_recommendation_'+shortname+' .p2_recommended').attr('class');
		actual = actual.replace(/actual:[0-9]+:[0-9]+/, 'actual:'+width+':'+height);
		jQuery('#p2_flashheader_'+shortname+' .p2_recommended').attr('class', actual);
		
		// Update the recommendation display
		var should_w = jQuery('#p2_recommendation_'+shortname+' .p2_recommended_width').text();
		var should_h = jQuery('#p2_recommendation_'+shortname+' .p2_recommended_height').text();
		if (
			(should_w && width == should_w && should_h && height == should_h)
			||
			(should_w && width == should_w)
			||
			(should_h && height == should_h)
		) {
			var displaygood = '';
			var displaybad = 'none';		
		} else {
			var displaygood = 'none';
			var displaybad = '';
		}
		jQuery('#p2_recommendation_'+shortname+' .p2_recommended .p2_fh_dimensions_ok').css('display', displaygood);
		jQuery('#p2_recommendation_'+shortname+' .p2_recommended .p2_fh_dimensions_notok').css('display', displaybad);
	}
	
	// hide the "no default image" msg and make sure image info is shown
	jQuery('#p2_imginfos_'+shortname).css('display', 'block');
	jQuery('#p2_noimg_'+shortname).css('display', 'none');
	
	
	// Show/hide the reset button
	if (show_reset == false) {
		jQuery('#p2_reset_button_'+shortname).css('display','none');
		jQuery('#p2_noimg_'+shortname).css('display', 'block');
		if ( jQuery('#p2_noimg_'+shortname).length ) {
			jQuery('#p2_imginfos_'+shortname).css('display', 'none');
			jQuery('#p2_recommendation_'+shortname+' .p2_fh_dimensions_notok').css('display', 'none');
		}
	} else {
		jQuery('#p2_reset_button_'+shortname).css('display','');
	}
	
}

function p2_hide_reset_button(shortname) {
	jQuery('#'+shortname+' a.p2_reset_button').hide();
}
