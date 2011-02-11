<?php
/*
The "Upload Image" admin page
*/

// Load library of our custom functions regarding uploading
require_once(dirname(dirname(__FILE__)).'/functions/upload.php');

// Main function: prints the admin page
function p2_upload_page() {
	global $p2, $explain;
	
	p2_debug_report();
	
	echo '<div class="wrap" svn="' . p2_svn( false ) . '">
	<h2>P2 Uploads: upload &amp; manage custom images &amp; files</h2>';
	
	p2_self_check();
	
	// tell people they can't use IE6 to admin this theme
	echo $explain['major']['noie6'];
	
	// general images
	if ( ! p2_test('headerlayout', 'nologoa' ) && ! p2_test('headerlayout', 'nologob' ) || p2_test( 'bioyesno', 'yes' ) ) {
		
		p2_upload_header("General Images");
	
		if ( ! p2_test('headerlayout', 'nologoa' ) && ! p2_test('headerlayout', 'nologob' ) )
			p2_upload_box('logo', "Main Blog Logo", '');
	
	
		// bio pictures
		if ( p2_test( 'bioyesno', 'yes' ) ) {
	
	 		p2_upload_box('biopic1', "Bio Picture");
	
			p2_advanced_image_title('biopics1', 'Your Bio Picture', 'biopics1', 'more', '700');
	
			p2_image_explanation( 'If you add more than one bio picture, the pictures will display randomly.  Please note, the images must match the exact dimensions of the first bio picture you upload to display correctly');
	
			$biomsg = 'remember to match the dimensions of the main bio picture';
			p2_upload_box('biopic2', "Bio Picture2", $biomsg );
			p2_upload_box('biopic3', "Bio Picture3", $biomsg );
			p2_upload_box('biopic4', "Bio Picture4", $biomsg );
			p2_upload_box('biopic5', "Bio Picture5", $biomsg );
		
				p2_advanced_image_title('biopics2', 'Bio Picture', 'biopics2', 'even more', '700');
		
				p2_upload_box('biopic6', "Bio Picture6", $biomsg );
				p2_upload_box('biopic7', "Bio Picture7", $biomsg );
				p2_upload_box('biopic8', "Bio Picture8", $biomsg );
				p2_upload_box('biopic9', "Bio Picture9", $biomsg );
			  	p2_upload_box('biopic10', "Bio Picture10", $biomsg );
		
					p2_advanced_image_title('biopics3', 'Bio Picture', 'biopics3', 'still more', '700');
		
					p2_upload_box('biopic11', "Bio Picture11", $biomsg );
					p2_upload_box('biopic12', "Bio Picture12", $biomsg );
					p2_upload_box('biopic13', "Bio Picture13", $biomsg );
					p2_upload_box('biopic14', "Bio Picture14", $biomsg );
					p2_upload_box('biopic15', "Bio Picture15", $biomsg );
			
					p2_end_advanced_image();
		
				p2_end_advanced_image();
	
			p2_end_advanced_image();
	
		}
	
		p2_upload_spacer();
		
	}
	// end bio pictures
	// end general images
	
	
	// header/flashfader images
	
	
	// only show flashfader images if slideshow on
	if ( p2_test( 'flashonoff', 'on' ) ) {
		
	p2_upload_header("Masthead Slideshow Images");
	p2_upload_box('flashheader1' , 'Masthead Slideshow Image 1', 'This is your first masthead slideshow image.  Pay close attention to the recommended dimensions and be sure to upload a properly sized image.' . p2_masthead_height_explain( TRUE ) );

	p2_upload_box('flashheader2' , 'Masthead Slideshow Image 2');
	p2_upload_box('flashheader3' , 'Masthead Slideshow Image 3');
	p2_upload_box('flashheader4' , 'Masthead Slideshow Image 4');
	p2_upload_box('flashheader5' , 'Masthead Slideshow Image 5');
	
	p2_advanced_image_title('flashheader-2', 'Masthead Slideshow 6-10', 'ms2', 'more', '700');
	
	p2_upload_box('flashheader6' , 'Masthead Slideshow Image 6');
	p2_upload_box('flashheader7' , 'Masthead Slideshow Image 7');
	p2_upload_box('flashheader8' , 'Masthead Slideshow Image 8');
	p2_upload_box('flashheader9' , 'Masthead Slideshow Image 9');
	p2_upload_box('flashheader10' , 'Masthead Slideshow Image 10');
	
		p2_advanced_image_title('flashheader-3', 'Masthead Slideshow 11-15', 'ms3', 'still more', '700');
		
		p2_upload_box('flashheader11' , 'Masthead Slideshow Image 11');
		p2_upload_box('flashheader12' , 'Masthead Slideshow Image 12');
		p2_upload_box('flashheader13' , 'Masthead Slideshow Image 13');
		p2_upload_box('flashheader14' , 'Masthead Slideshow Image 14');
		p2_upload_box('flashheader15' , 'Masthead Slideshow Image 15');
		
			p2_advanced_image_title('flashheader-4', 'Masthead Slideshow 16-20', 'ms4', 'still more', '700');

			p2_upload_box('flashheader16' , 'Masthead Slideshow Image 16');
			p2_upload_box('flashheader17' , 'Masthead Slideshow Image 17');
			p2_upload_box('flashheader18' , 'Masthead Slideshow Image 18');
			p2_upload_box('flashheader19' , 'Masthead Slideshow Image 19');
			p2_upload_box('flashheader20' , 'Masthead Slideshow Image 20');
			
				p2_advanced_image_title('flashheader-5', 'Masthead Slideshow 21-25', 'ms5', 'still more', '700');

				p2_upload_box('flashheader21' , 'Masthead Slideshow Image 21');
				p2_upload_box('flashheader22' , 'Masthead Slideshow Image 22');
				p2_upload_box('flashheader23' , 'Masthead Slideshow Image 23');
				p2_upload_box('flashheader24' , 'Masthead Slideshow Image 24');
				p2_upload_box('flashheader25' , 'Masthead Slideshow Image 25');
				
					p2_advanced_image_title('flashheader-6', 'Masthead Slideshow 26-30', 'ms6', 'still more', '700');

					p2_upload_box('flashheader26' , 'Masthead Slideshow Image 26');
					p2_upload_box('flashheader27' , 'Masthead Slideshow Image 27');
					p2_upload_box('flashheader28' , 'Masthead Slideshow Image 28');
					p2_upload_box('flashheader29' , 'Masthead Slideshow Image 29');
					p2_upload_box('flashheader30' , 'Masthead Slideshow Image 30');

					p2_end_advanced_image();

				p2_end_advanced_image();

			p2_end_advanced_image();
		
		p2_end_advanced_image();
	
	p2_end_advanced_image();
	
	// end if ( p2_test( 'flashonoff', 'on' ) )
	} else {
		p2_upload_header("Masthead Header Image");
		p2_upload_box('flashheader1' , 'Masthead Slideshow Image', 'Right now you have the Masthead slideshow feature turned off, so you only have the option to upload one masthead header image.  If you want multiple images to fade in and out as a slideshow in your header, turn on the Masthead Slideshow in the "P2 Options" page and return here to upload more images.' . p2_masthead_height_explain( FALSE ) );
	}
	
	p2_upload_spacer();
	// end header/flashfader images
	
	
	
	// optional images
	p2_upload_header("Optional Images");
	p2_upload_box('blog_bg', 'Blog background image', 'Background image for your blog, seen at the outside edges of your blog. Properties of background image can be set in the "P2 Options" page under "Background."');
	p2_upload_box('bio_signature', "Bio Signature", 'A signature image for your bio area.  The exact placement of this image can be tweaked in the "P2 Options" page, under "Bio". If you are using the default gradient background for the bio section, you will need to upload a transparent GIF or PNG file for best results.');
	p2_upload_box('post_sep', 'Post Separator Image', 'Upload a custom image to separate your posts. Must be activated on the "P2 Options" page.');
	p2_upload_box('bio_separator', 'Bio section custom separator', 'Upload a custom image to be displayed below your bio, separating it from the rest of your blog. Must be activated on the "P2 Options" page.');
	
	p2_upload_box('favicon', 'Favicon', 'This is the little icon that appears left of the website address in your web browser. You must create a square image file and then <a href="http://www.html-kit.com/favicon/">convert it</a> to a <strong>.ico</strong> file before uploading. Read a <a href="http://www.prophotoblogs.com/support/favicon-ico/">tutorial here</a>.', '', true);
	
	p2_upload_box('iphone_webclip_icon', 'iPhone Webclip Icon', 'This is the image that is displayed on an iPhone when someone saves your blog address to their iPhone homepage. This image must conform to the size recommendations.');
	p2_upload_spacer();
	// end optional images
	
	
	
	// sponsor banners
	p2_upload_header('Banner Link Images');
	p2_image_explanation('If you choose, you may upload sponsor banner images to be displayed in the  bottom of your blog.  These can be advertisements, affiliate banners, sponsor banners, etc. You must also activate this option from the P2 Options menu, as well as link the banners to the correct URLs. Please note the size requirements for these images.');
	p2_advanced_image_title('banners1', 'Sponsor Banners', 'banners1', '', '700');
	p2_upload_box('banner1', 'Banner 1');
	p2_upload_box('banner2', 'Banner 2');
	p2_upload_box('banner3', 'Banner 3');
	p2_upload_box('banner4', 'Banner 4');
	p2_upload_box('banner5', 'Banner 5');
	
		p2_advanced_image_title('banners2', 'Sponsor Banners 6-10', 'banners2', 'more', '700');
		p2_upload_box('banner6', 'Banner 6');
		p2_upload_box('banner7', 'Banner 7');
		p2_upload_box('banner8', 'Banner 8');
		p2_upload_box('banner9', 'Banner 9');
		p2_upload_box('banner10', 'Banner 10');
		
			p2_advanced_image_title('banners1', 'Sponsor Banners 11-15', 'banners3', 'more', '700');
			p2_upload_box('banner11', 'Banner 11');
			p2_upload_box('banner12', 'Banner 12');
			p2_upload_box('banner13', 'Banner 13');
			p2_upload_box('banner14', 'Banner 14');
			p2_upload_box('banner15', 'Banner 15');
			p2_end_advanced_image();
		
		p2_end_advanced_image();
	
	p2_end_advanced_image();
	p2_upload_spacer();
	// end sponsor banners
	
	
	// audio files
	p2_upload_header('Audio Files');
	p2_image_explanation('Use these upload areas to upload audio files to be played while your blog is being viewed.  You must also activate the Audio Player option from the P2 Options menu.  The audio files MUST be in the .mp3 format.  They should be compressed as small as possible so that they don\'t slow down your blog too much. Also note if your file is larger than 2 megabytes (sometimes smaller) you may not be able to upload the audio files.  If that is the case, you may use an FTP program to upload your files and specify the path to those files in the Options menu.');
	p2_advanced_image_title('audiofiles', 'Audio Files', 'audiofiles', '', '700');
	p2_upload_box('audio1', 'Audio MP3 File 1', '', '', true);
	p2_upload_box('audio2', 'Audio MP3 File 2', '', '', true);
	p2_upload_box('audio3', 'Audio MP3 File 3', '', '', true);
	p2_upload_box('audio4', 'Audio MP3 File 4', '', '', true);
	p2_end_advanced_image();
	// end audio files

}


?>