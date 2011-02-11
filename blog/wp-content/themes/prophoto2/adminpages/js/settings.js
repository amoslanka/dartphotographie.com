/* Scripts for the Settings page */

jQuery(document).ready(function(){
	
	// zebra stripe the layouts list
	jQuery('#settings-list li:even').addClass('alt');
	jQuery('#settings-list li').mouseover(function(){
		jQuery(this).addClass('hover');
	}).mouseout(function(){
		jQuery(this).removeClass('hover');
	});
	
	jQuery('#p2_settings_name').blur(function(){
		jQuery(this).val(p2_sanitize_setname(jQuery(this).val()));
	});
	
	jQuery('#p2_settings_form').submit(function(){
		jQuery('#p2_settings_name').blur();
	
		if (jQuery('#p2_settings_name').val() == '') {
			alert ('Please enter a name');
			return false;
		}
	});
	
	
});


function p2_sanitize_setname(name) {
	// replace underscores and spaces with dashes
	name = name.replace(/ /g,"_");
	// no multiple consecutive dashes
	name = name.replace(/_+/g,"_");
	// remove all that's not a letter, a digit or a dash
	name = name.replace(/[^a-zA-Z0-9-_]/g,"");
	// trim
	name = name.replace(/^\s+|\s+$/g,"");
	name = name.replace(/^_+|_+$/g,"");
	return name;
}
