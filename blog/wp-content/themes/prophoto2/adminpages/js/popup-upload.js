/* Scripts for the Upload Images iframed popup */

function p2_sendtopage(url, shortname, width, height, size) {
	var win = window.opener ? window.opener : window.dialogArguments;
	if (!win) win = top;
	// get is_misc from global scope, defined in functions/upload.php p2_upload_form_head()
	if (is_misc == true) {shortname = 'logo';} // trick: images named logo will force page refresh
	win.p2_update_theme_image(url, shortname, width, height, size);
}

jQuery(document).ready( function() {
	jQuery('h3').html('Select a file to upload').css('display','block'); // Modify the default <h3> element
	// jQuery('#html-upload-ui').prepend('<input type="hidden" name="MAX_FILE_SIZE" value="2084000" />'); // Adds a maxfilesize to 750k
	// removed so that misc file can be any size. Size of images tested by PHP in functions/upload.php:p2_image_uploaded()

});