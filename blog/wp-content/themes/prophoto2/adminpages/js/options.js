/* Scripts for the Options page */

// get the p2_tab=XXX part of the current URL
function p2_get_option_tab() {
	var objURL = {};
	window.location.search.replace(
		new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
		function( $0, $1, $2, $3 ){
			objURL[ $1 ] = $3;
		}
	);
	return (objURL['p2_tab']);
}

// constrains text input areas to required limits
function p2_constrain_textinput(id, bottom, top) {
	jQuery(id).blur(function(){
		var opacity = jQuery(this).val();
		if ( opacity > top ) {
			jQuery(this).val(top);
		}
		if ( opacity < bottom ) {
			jQuery(this).val(bottom);		
		}
	});	
}


function p2_next_tab(id) {
	// First step :
	// if all tabs displayed: nothing
	// if 1 tab displayed: warn, and if true, proceed
	var nextstep = p2_hijack_tab_url(1);
	if (nextstep == false)
		return false;
	if (nextstep == 'update_display') { // if all tabs displayed
		var hashish = id.split('-');
		jQuery('#location-post').attr('value', hashish[0]);
		jQuery('.tabbed-sections').css('display', 'none');
		jQuery('#tab-section-'+id).css('display', 'block');
		jQuery('a.tab-link').removeClass('active');
		jQuery('#'+id).addClass('active');
	}
	// all tabs: return false
	// 1 tab: return true
	return p2_hijack_tab_url(2);
}

function p2_color_validate(color,id) {
	if (color.charAt(0) != '#') {
		color = '#'+color;
	}
	if (color.length > 7) {
		color = color.substring(0,7);
	}
	if (color.length > 4 && color.length < 7) {
		color = color.substring(0,4);
		color = color+color.substring(1,4);
	}
	justnum = color.substring(1,color.length);
	if (/#/.test(justnum)) {
		color = '#ffffff';
	}
	jQuery('#'+id).val(color).blur();
	return color;
}

/* functions for live font preview */
function p2_is_checked(optionid) {
	if ( jQuery(optionid).children().children('.optional-color-bind-checkbox').length > 0 ) {
		if ( jQuery(optionid).children().children('.optional-color-bind-checkbox').is(':checked') ) {
			return true;
		}
		return false;
	}
	return true;
}

function p2_get_color_input(optionid) {
	return color = jQuery(optionid).children().children().children('.color-picker').val();
}

function p2_get_sectionid(optionid) {
	return sectionid = '#'+jQuery(optionid).parents('.option-section').attr('id');
}

function p2_get_color_setting_type(optionid) {
	var type = 'none';
	if ( jQuery(optionid).hasClass('nonlink-font-color-picker') ) {type='';}
	if ( jQuery(optionid).hasClass('font-color-picker') ) {type=' a.unvisited';}
	if ( jQuery(optionid).hasClass('visited-link-font-color-picker') ) {type=' a.visited';}
	return type;
}

function p2_update_color_preview(sectionid, type, color) {
	if ( type != 'none' ) {
		jQuery(sectionid+' .font-preview'+type).css('color', color);
	}
}
/* END functions for live font preview */


jQuery(document).ready(function() {
	
	if ( jQuery('.hidden-option').css('display') == 'block' ) {
		jQuery('#aot-blogborder a').each(function(){
			text = jQuery(this).html();
			text.replace('Click to ', '');
			text.replace('click')
		});
	}
	
	// display p2 news
	if ( p2_external_explain['p2_news'] != undefined ) {
		jQuery('.wrap h2').after(p2_external_explain['p2_news']);
	}
	
	
	// show/hide the font-live-preview areas
	jQuery('.live-preview-button').click(function(){
		var thisid = '#'+jQuery(this).attr('id');
		jQuery(thisid).toggleClass('live-preview-open');
		var parentid = '#'+jQuery(thisid).parents('.option-section').attr('id');
		jQuery(parentid+' .font-preview-wrapper').slideToggle(250);
	});
	
	// add a color picker to every div.p2_picker
	jQuery('.p2_picker').each(function(){
		var id = jQuery(this).attr('id');
		var target = id.replace(/picker/, 'input');
		jQuery(this).farbtastic('#'+target);
	});
	
	// add the toggling behavior to .p2_swatch
	jQuery('.p2_swatch').click(function(){
		var id = jQuery(this).attr('id');
		var target = id.replace(/swatch/, 'picker-wrap');
		p2_hideothercolorpickers(target);
		var display = jQuery('#'+target).css('display');
		(display == 'block') ? jQuery('#'+target).fadeOut(300) : jQuery('#'+target).fadeIn(300);
		var bg = (display == 'block') ? '0px 0px' : '0px -24px';
		jQuery(this).css('background-position', bg);
		}).tTips(); // tooltipize

	
	// link and font section show/hide links
	jQuery('.font-link-more-options').click(function(){
		var speed = 1;
		if ( jQuery(this).hasClass('option-open') ) {
			var speed = 180;
		}
		jQuery(this).toggleClass('option-open');
		var div = jQuery(this).prev();
		var id = jQuery(div).attr('id');
		jQuery('#'+id+' .hidden-font-link-option')
			.animate({opacity: 0}, speed)
			.slideToggle(200)
			.animate({opacity: 1}, 180);
	});
	
	// inline documentation hide/reveal links
	jQuery('a.click-for-explain').click(function(){
		thisid = jQuery(this).attr('id');
		var parent = jQuery('#'+thisid).parent();
		var id = jQuery(parent).attr('id');
		id = id.replace('-option-section', '');
			 	var speed = 1;
		if ( jQuery('#'+thisid).hasClass('help-active') ) {
			var speed = 130;
		}
		jQuery('#'+thisid).toggleClass('help-active');
		var second_para = ''
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



	/* LIVE FONT/LINK PREVIEWS */
	// handles all the hovers of the links in the font-preview areas
	jQuery('.font-preview a').mouseover(function(){
		thistemp = jQuery(this);
		sectionid = "#"+jQuery(this).parents('.option-section').attr('id');
		hoverdec = jQuery(sectionid+' .link-hover-decoration-select option:selected').val();
		nonhoverdec = jQuery(sectionid+' .link-decoration-select option:selected').val();
		hovercoloroptionid = "#"+jQuery(sectionid+' .link-hover-font-color-picker').attr('id');
		hovercolor = jQuery(sectionid+' .link-hover-font-color-picker .color-picker').val();
		if ( jQuery(thistemp).hasClass('unvisited') ) {
			nonhovercolorid = "#"+jQuery(sectionid+' .font-color-picker').attr('id');
			if ( p2_is_checked(nonhovercolorid) ) {
				nonhovercolor = jQuery(sectionid+' .font-color-picker .color-picker').val();
			} else {
				nonhovercolor = '';
			}
		} else {
			nonhovercolorid = "#"+jQuery(sectionid+' .visited-link-font-color-picker').attr('id');
			if ( p2_is_checked(nonhovercolorid) ) {
				nonhovercolor = jQuery(sectionid+' .visited-link-font-color-picker .color-picker').val();
			} else {
				nonhovercolor = '';
			}		
		}
		if ( p2_is_checked(hovercoloroptionid) ) {
			hovercolor = jQuery(sectionid+' .link-hover-font-color-picker .color-picker').val();
			jQuery(thistemp).css('color', hovercolor);
		}
		jQuery(thistemp).css('text-decoration', hoverdec);
	}).mouseout(function(){
		if ( p2_is_checked(hovercoloroptionid) ) {
			hovercolor = jQuery(sectionid+' .link-hover-font-color-picker .color-picker').val();
			jQuery(thistemp).css('color', nonhovercolor);
		}
		jQuery(thistemp).css('text-decoration', nonhoverdec);
	});
	// font family
	jQuery('.font-family-select select').change(function(){
		var id = jQuery(this).attr('id');
		var font = jQuery('#'+id+' option:selected').val();
		var sectionid = jQuery(this).parents('.option-section').attr('id');
		jQuery('#'+sectionid+' .font-preview, #'+sectionid+' .font-preview a').css('font-family', font);
	})
	.change();
	// font size
	jQuery('.font-group .font-size-input input').blur(function(){
		var size = jQuery(this).val();
		size = jQuery.trim(size);
		var sectionid = jQuery(this).parents('.option-section').attr('id');
		jQuery('#'+sectionid+' .font-preview, #'+sectionid+' .font-preview p').css('font-size', size+'px');
	});
	// link font size
	jQuery('.link-group .font-size-input input').blur(function(){
		var size = jQuery(this).val();
		size = jQuery.trim(size);
		var sectionid = jQuery(this).parents('.option-section').attr('id');
		jQuery('#'+sectionid+' .font-preview, #'+sectionid+' .font-preview a').css('font-size', size+'px');
	});
	// font weight
	jQuery('.font-weight-select select').change(function(){		
		var id = jQuery(this).attr('id');
		var weight = jQuery('#'+id+' option:selected').val();
		var sectionid = jQuery(this).parents('.option-section').attr('id');
		jQuery('#'+sectionid+' .font-preview').css('font-weight', weight);
	})
	.change();
	// font style
	jQuery('.font-style-select select').change(function(){		
		var id = jQuery(this).attr('id');
		var style = jQuery('#'+id+' option:selected').val();
		var sectionid = jQuery(this).parents('.option-section').attr('id');
		jQuery('#'+sectionid+' .font-preview, #'+sectionid+' .font-preview a').css('font-style', style);
	})
	.change();
	// text transform
	jQuery('.text-transform-select select').change(function(){		
		var id = jQuery(this).attr('id');
		var transform = jQuery('#'+id+' option:selected').val();
		var sectionid = jQuery(this).parents('.option-section').attr('id');
		jQuery('#'+sectionid+' .font-preview, #'+sectionid+' .font-preview a').css('text-transform', transform);
	})
	.change();		
	// check/uncheck the optional color bind (link groups)
	jQuery('.link-group .optional-color-bind-checkbox').click(function(){
		thisid = '#'+jQuery(this).attr('id');
		var optionid = "#"+jQuery(thisid).parents('.individual-option').attr('id');
		var type = p2_get_color_setting_type(optionid);
		var sectionid = p2_get_sectionid(optionid);
		var color = p2_get_color_input(optionid);
		if ( p2_is_checked(optionid) !== true ) {
			jQuery(sectionid+' .font-preview'+type).css('color', '');
			if ( type == ' a.visited' ) {
				jQuery(sectionid+' .font-preview a.visited').fadeOut(300);
			}
		} else {
			jQuery(sectionid+' .font-preview'+type).css('color', color);
			if ( type == ' a.visited' ) {
				jQuery(sectionid+' .font-preview a.visited').fadeIn(300);
			}
		}	
	});
	// check/uncheck the optional color bind (font groups)
	jQuery('.font-group .optional-color-bind-checkbox').click(function(){
		thisid = '#'+jQuery(this).attr('id');
		var optionid = "#"+jQuery(thisid).parents('.individual-option').attr('id');
		var sectionid = p2_get_sectionid(optionid);
		var color = p2_get_color_input(optionid);
		if ( p2_is_checked(optionid) !== true ) {
			jQuery(sectionid+' .font-preview').css('color', '');
		} else {
			jQuery(sectionid+' .font-preview').css('color', color);
		}	
	});
	// font color updater
	jQuery('.font-group .farbtastic div')
		.mouseup(function(){
			optionid = "#"+jQuery(this).parents('.individual-option').attr('id');
			sectionid = p2_get_sectionid(optionid);
			color = p2_get_color_input(optionid);
			if ( p2_is_checked(optionid) ) {	
				p2_update_color_preview(sectionid, '', color);
			}
		}).change(function(){
			if ( p2_is_checked(optionid) ) {	
				p2_update_color_preview(sectionid, '', color);
			}
		}).mouseup();
	// link group font/link/hover color updater
	jQuery('.link-group .farbtastic div')
		.mouseup(function(){
			optionid = "#"+jQuery(this).parents('.individual-option').attr('id');
			sectionid = p2_get_sectionid(optionid);
			color = p2_get_color_input(optionid);
			type = p2_get_color_setting_type(optionid);
			if ( p2_is_checked(optionid) ) {	
				p2_update_color_preview(sectionid, type, color);
			} else {
				if ( type == ' a.visited') {
					jQuery(sectionid+' .font-preview .visited').hide();
				}
			}
		}).change(function(){
			if ( p2_is_checked(optionid) ) {	
				p2_update_color_preview(sectionid, type, color);
			}
	})
	.mouseup();
	// link text-decoration
	jQuery('.link-decoration-select select').change(function(){
		var id = jQuery(this).attr('id');
		var dec = jQuery('#'+id+' option:selected').val();
		var sectionid = jQuery(this).parents('.option-section').attr('id');
		var hoverdec = jQuery('#'+sectionid+' .link-hover-decoration-select select option:selected').val();
		jQuery('#'+sectionid+' .font-preview a').css('text-decoration', dec);
	})
	.change();
	// color input areas if they don't use farbtastic
	jQuery('.font-group .color-picker').blur(function(){
		var color = p2_color_validate(jQuery(this).val(), jQuery(this).attr('id'));		
		var sectionid = '#'+jQuery(this).parents('.option-section').attr('id');
		jQuery(sectionid+' .font-preview').css('color', color);
	});
	jQuery('.link-group .color-picker').blur(function(){
		tempthis = jQuery(this);
		var color = p2_color_validate(jQuery(tempthis).val(), jQuery(this).attr('id'));
		var optionid = "#"+jQuery(tempthis).parents('.individual-option').attr('id');
		var sectionid = '#'+jQuery(tempthis).parents('.option-section').attr('id');
		var type = p2_get_color_setting_type(optionid);
		p2_update_color_preview(sectionid, type, color);
	});
	// menu link bg hovers
	jQuery('#nav_bg_color-font-preview a.withhover').mouseover(function(){
		thistemp = jQuery(this);
		var sectionid = '#'+jQuery(this).parents('.option-section').attr('id');
		color = jQuery('#p2-input-nav_link_font_color').val();
		if ( jQuery(thistemp).hasClass('visited') ) {
			if ( jQuery('#p2-input-nav_link_visited_font_color-bind').is(':checked') ) {
				color = jQuery('#p2-input-nav_link_visited_font_color').val();
			}
		}
		hovercolor = jQuery(sectionid+' #p2-input-nav_dropdown_bg_hover_color').val();
		nonhovercolor = jQuery('#p2-input-nav_bg_color').val();
		if ( jQuery('#p2-input-nav_dropdown_bg_color-bind').is(':checked') ) {
			nonhovercolor = jQuery('#p2-input-nav_dropdown_bg_color').val();
		}
		jQuery(thistemp).css('background-color', hovercolor);
	}).mouseout(function(){
		jQuery(thistemp).css('background-color', nonhovercolor);
		jQuery(thistemp).css('color', color);
	});
	// footer bg area update
	jQuery('#p2-input-footer_bg_color').blur(function(){
		color = jQuery(this).val();
		jQuery('#footer_headings_font_family-font-preview, #footer_link_font_size-font-preview').css('background-color', color);
	});
	jQuery('#footer_bg_color-individual-option .farbtastic div').mouseup(function(){
		color = p2_get_color_input('#footer_bg_color-individual-option');
		jQuery('#footer_headings_font_family-font-preview, #footer_link_font_size-font-preview').css('background-color', color);
	}).change(function(){
		jQuery('#footer_headings_font_family-font-preview, #footer_link_font_size-font-preview').css('background-color', color);
	}).mouseup();
	// comment bg area update
	jQuery('#p2-input-comments_comment_bg').blur(function(){
		color = jQuery(this).val();
		jQuery('#comments_link_font_size-font-preview').css('background-color', color);
	});
	jQuery('#comments_comment_bg-individual-option .farbtastic div').mouseup(function(){
		color = jQuery('#p2-input-comments_comment_bg').val();
		jQuery('#comments_link_font_size-font-preview').css('background-color', color);
	}).change(function(){
		jQuery('#comments_link_font_size-font-preview').css('background-color', color);
	}).mouseup();
	// menu special font sizes
	jQuery('#p2-input-nav_top_fontsize').blur(function(){
		size = jQuery(this).val()+'px';
		jQuery('#nav_bg_color-font-preview a.title').css('font-size', size);
	});
	jQuery('#p2-input-nav_dropdown_link_textsize').blur(function(){
		size = jQuery(this).val()+'px';
		jQuery('#nav_bg_color-font-preview a.unvisited').not('.title').css('font-size', size);
		jQuery('#nav_bg_color-font-preview a.visited').css('font-size', size);
	});
	// special menu bg color updates
	jQuery('#p2-input-nav_bg_color').blur(function(){
		color = jQuery(this).val();
		jQuery('#nav_bg_color-font-preview a.title').css('background-color', color);
		if ( p2_is_checked('#nav_dropdown_bg_color-individual-option') === false ) {
			jQuery('#nav_bg_color-font-preview a.visited').css('background-color', color);
			jQuery('#nav_bg_color-font-preview a.unvisited').css('background-color', color);
		}
	});
	jQuery('#nav_bg_color-individual-option .farbtastic div').mouseup(function(){
		color = p2_get_color_input('#nav_bg_color-individual-option');
		jQuery('#nav_bg_color-font-preview a.title').css('background-color', color);
		if ( p2_is_checked('#nav_dropdown_bg_color-individual-option') === false ) {
			jQuery('#nav_bg_color-font-preview a.visited').css('background-color', color);
			jQuery('#nav_bg_color-font-preview a.unvisited').css('background-color', color);
		}
	}).change(function(){
		jQuery('#nav_bg_color-font-preview a.title').css('background-color', color);
		if ( p2_is_checked('#nav_dropdown_bg_color-individual-option') === false ) {
			jQuery('#nav_bg_color-font-preview a.visited').css('background-color', color);
			jQuery('#nav_bg_color-font-preview a.unvisited').css('background-color', color);
		}
	}).mouseup();
	jQuery('#p2-input-nav_dropdown_bg_color-bind').click(function(){
		if ( jQuery('#p2-input-nav_dropdown_bg_color-bind').is(':checked') ) {
			color = jQuery('#p2-input-nav_dropdown_bg_color').val();
			jQuery('#nav_bg_color-font-preview a').not('.title').css('background-color', color);
		} else {
			color = jQuery('#p2-input-nav_bg_color').val();
			jQuery('#nav_bg_color-font-preview a').css('background-color', color);
		}
	});
	jQuery('#p2-input-nav_dropdown_bg_color').blur(function(){
		color = jQuery(this).val();
		jQuery('#nav_bg_color-font-preview a').not('.title').css('background-color', color);
	});
	jQuery('#nav_dropdown_bg_color-individual-option .farbtastic div').mouseup(function(){
		color = p2_get_color_input('#nav_dropdown_bg_color-individual-option');
		jQuery('#nav_bg_color-font-preview a').not('.title').css('background-color', color);
	}).change(function(){
		jQuery('#nav_bg_color-font-preview a').not('.title').css('background-color', color);
	});
	jQuery('#vis-menu').hide();
	jQuery('#p2-input-nav_link_visited_font_color-bind').click(function(){
		if ( jQuery(this).is(':checked') ) { 
			jQuery('#vis-menu').fadeIn(300); 
		} else {
			jQuery('#vis-menu').fadeOut(300);
		}
	});
	// comment timestamp color
	jQuery('#p2-input-commenttimecolor').blur(function(){
		color = jQuery(this).val();
		jQuery('#comments_link_font_size-font-preview span#comment-timestamp').css('color', color);
	});
	jQuery('#commenttimecolor-individual-option .farbtastic div').mouseup(function(){
		color = jQuery('#p2-input-commenttimecolor').val();
		jQuery('#comments_link_font_size-font-preview span#comment-timestamp').css('color', color);
	}).change(function(){
		jQuery('#comments_link_font_size-font-preview span#comment-timestamp').css('color', color);
	}).mouseup();
	// line-heights
	jQuery('#p2-input-post_text_line_height').change(function(){		
		var lineheight = jQuery(this).val();
		jQuery('#post_text_font_family-font-preview p').css('line-height', lineheight+'em');
	});
	jQuery('#p2-input-gen_line_height').change(function(){		
		var lineheight = jQuery(this).val();
		jQuery('#gen_font_family-font-preview').css('line-height', lineheight+'em');
	});
	// post title and post meta top justification
	jQuery('#p2-input-post_header_align-left').click(function(){
		jQuery('#emt_font_family-font-preview, #post_title_link_font_size-font-preview').css('text-align', 'left');
	});
	jQuery('#p2-input-post_header_align-right').click(function(){
		jQuery('#emt_font_family-font-preview, #post_title_link_font_size-font-preview').css('text-align', 'right');
	});
	jQuery('#p2-input-post_header_align-center').click(function(){
		jQuery('#emt_font_family-font-preview, #post_title_link_font_size-font-preview').css('text-align', 'center');
	});
	// category links prelude
	jQuery('#p2-input-catprelude').blur(function(){
		var catprelude = jQuery(this).val();
		jQuery('.cat-links').html(catprelude);
	});
	
	/* END - LIVE FONT/LINK PREVIEWS */

	

	// option header mouseovers, mouseouts, and clicks
	var layouts = new Object();
	layouts['default'] = 0;
	layouts['defaultc'] = 1;
	layouts['defaultr'] = 2;
	layouts['pptclassic'] = 3;
	layouts['logobelowa'] = 4;
	layouts['logobelowb'] = 5;
	layouts['logobelowal'] = 6;
	layouts['logobelowbl'] = 7;
	layouts['logobelowar'] = 8;
	layouts['logobelowbr'] = 9;
	layouts['logotopa'] = 10;
	layouts['logotopb'] = 11;
	layouts['logotopal'] = 12;
	layouts['logotopbl'] = 13;
	layouts['logotopar'] = 14;
	layouts['logotopbr'] = 15;
	layouts['nologoa'] = 16;
	layouts['nologob'] = 17;
	jQuery('.header-thumb-button').mouseover(function(){
		var left = jQuery(this).attr('id');
		left = layouts[left] * 200;
		jQuery('#headerlayout-viewer').css('background-position', '-'+left+'px 0');
		jQuery(this).addClass('hovered');
	});
	jQuery('.header-thumb-button').mouseout(function(){
		var selected = jQuery('#headerlayout-input').attr('value');
		left = layouts[selected] * 200;
		jQuery('#headerlayout-viewer').css('background-position', '-'+left+'px 0');
		jQuery(this).removeClass('hovered');
	});
	jQuery('.header-thumb-button').click(function(){
		var selected = jQuery(this).attr('id');
		jQuery('#headerlayout-input').attr('value', selected);
		left = layouts[selected] * 200;
		jQuery('#headerlayout-viewer').css('background-position', '-'+left+'px 0');
		jQuery('.header-thumb-button').removeClass('active-thumb');
		jQuery(this).addClass('active-thumb');
	});
	
	
	// this for the "tabbed" options areas
	var p2_hash = p2_get_option_tab();
	if (p2_hash != undefined) {
		jQuery('.tabbed-sections').css('display', 'none');
		jQuery('#tab-section-'+p2_hash+'-link').css('display', 'block');
		jQuery('a.tab-link').removeClass('active');
		jQuery('#'+p2_hash+'-link').addClass('active');
	} else {
		jQuery('#background-link').addClass('active');
		jQuery('#tab-section-background-link').css('display', 'block');
	}
	var funky_helper = jQuery('.funky-helper').text();
	if (funky_helper) {
		jQuery('.tabbed-sections').css('display', 'none');
		jQuery('#tab-section-'+funky_helper+'-link').css('display', 'block');
		jQuery('a.tab-link').removeClass('active');
		jQuery('#'+funky_helper+'-link').addClass('active');
	}
	// makes the tabs work
	jQuery('a.tab-link').click(function(){
		var id = jQuery(this).attr('id');
		return p2_next_tab(id);
	});
	
	jQuery('.click-for-explain').tTips();
	jQuery('.not-banner').parent().css('margin-top', '0');
	jQuery('.blank-comment').next().css('margin-top', '0');
	
	
	// for post separator area
	jQuery('#p2-input-post_divider_onoff-line').click(function(){
		jQuery('.a017shg').slideDown(300);
		jQuery('#margin_below_post-individual-option').slideDown(300);
		jQuery('.for2').css('display', 'none');
		jQuery('.for3').css('display', 'none');
		jQuery('.for1').css('display', 'inline');
	});
	jQuery('#p2-input-post_divider_onoff-none').click(function(){
		jQuery('.a017shg').slideUp(300);
		jQuery('#margin_below_post-individual-option').slideUp(300);
		jQuery('.for1').css('display', 'none');
		jQuery('.for3').css('display', 'none');
		jQuery('.for2').css('display', 'inline');
	});
	jQuery('#p2-input-post_divider_onoff-image').click(function(){
		jQuery('.a017shg').slideUp(300);
		jQuery('#margin_below_post-individual-option').slideDown(300);
		jQuery('.for1').css('display', 'none');
		jQuery('.for2').css('display', 'none');
		jQuery('.for3').css('display', 'inline');
	});
	

	//load punymce mini-editors for bio/contact textarea fields
	if ( jQuery('#p2-input-contact_text').length > 0 ) {
		var editor5 = new punymce.Editor({
			id : 'p2-input-contact_text',
			plugins : 'Link,ForceBlocks,EditSource',
			toolbar : 'bold,italic,underline,link,editsource',
			min_width: 570,
			min_height : 180
		});
	}
	if ( jQuery('#p2-input-biopara1').length > 0 ) {
		var editor1 = new punymce.Editor({
			id : 'p2-input-biopara1',
			plugins : 'Link,ForceBlocks,EditSource',
			toolbar : 'bold,italic,underline,link,editsource',
			min_width: 570,
			min_height : 180
		});
	}
	if ( jQuery('#p2-input-biopara2').length > 0 ) {
		var editor2 = new punymce.Editor({
			id : 'p2-input-biopara2',
			plugins : 'Link,ForceBlocks,EditSource',
			toolbar : 'bold,italic,underline,link,editsource',
			min_width: 570,
			min_height : 180
		});
	}
	if ( jQuery('#p2-input-biopara3').length > 0 ) {
		var editor3 = new punymce.Editor({
			id : 'p2-input-biopara3',
			plugins : 'Link,ForceBlocks,EditSource',
			toolbar : 'bold,italic,underline,link,editsource',
			min_width: 570,
			min_height : 180
		});
	}
	if ( jQuery('#p2-input-biopara4').length > 0 ) {
		var editor4 = new punymce.Editor({
			id : 'p2-input-biopara4',
			plugins : 'Link,ForceBlocks,EditSource',
			toolbar : 'bold,italic,underline,link,editsource',
			min_width: 570,
			min_height : 180
		});
	}
	
	// constrain some text input choices
	p2_constrain_textinput('#p2-input-nav_dropdown_opacity', 1, 100);
	p2_constrain_textinput('#p2-input-blog_border_width', 0, 16);
	p2_constrain_textinput('#p2-input-flash_fadetime', 1, 50);
	
	
	// show custom date format field when appropriate
	jQuery('#p2-input-dateformat').change(function(){
		var choice = jQuery('#p2-input-dateformat option:selected').val();
		if (choice == 'custom') {
			jQuery('#dateformat_custom-individual-option').slideDown(150);
		} else {
			jQuery('#dateformat_custom-individual-option').slideUp(150);
		}
	});
	
	
	
	// update recommended width of uploaded images when blog width changed
	jQuery('#p2-input-blog_width').change(function(){
		var difference = jQuery('.upload-width').attr('difference');
		var innermargin = 62;
		if ( jQuery('.upload-width').attr('innermargin') == 'zero') {
			innermargin = 0;
		}
		var newwidth = jQuery('#p2-input-blog_width option:selected').val();
		//alert('newwidth:'+newwidth+' differenc:'+difference+' innermargin:'+innermargin);
		var upload_width = newwidth - difference - innermargin;
		jQuery('.upload-width').text(upload_width).css({
			background: '#6fec22',
			color: '#000',
			padding: '0 3px'
		});	
	});
	jQuery('#p2-input-inner_margin-30').click(function(){
		jQuery('.upload-width').attr('innermargin', '30');
		jQuery('#p2-input-blog_width').change();
	});
	jQuery('#p2-input-inner_margin-zero').click(function(){
		jQuery('.upload-width').attr('innermargin', 'zero');
		jQuery('#p2-input-blog_width').change();
	});
	
	
	// hide/reveal message about bio bottom custom border image
	var $bioimage = jQuery('#bio_border-individual-option p');
	if (jQuery('#bio_border-individual-option input:checked').val() != 'image') {
		$bioimage.hide();
	}
	jQuery('#p2-input-bio_border-border, #p2-input-bio_border-noborder').click(function(){$bioimage.fadeOut();})
	jQuery('#p2-input-bio_border-image').click(function(){$bioimage.fadeIn();})
	
});

// Close color pickers when click on the document. This function is hijacked by farbtastic's event when a color picker is open
jQuery(document).mousedown(function(){
	p2_hideothercolorpickers();
});

// Close color pickers except "what"
function p2_hideothercolorpickers(what) {
	jQuery('.p2_picker_wrap').each(function(){
		var id = jQuery(this).attr('id');
		if (id == what) {
			return;
		}
		var display = jQuery(this).css('display');
		if (display == 'block') {
			jQuery(this).fadeOut(300);
			var swatch = id.replace(/picker-wrap/, 'swatch');
			jQuery('#'+swatch).css('background-position', '0px 0px');
		}
	});
}


  
