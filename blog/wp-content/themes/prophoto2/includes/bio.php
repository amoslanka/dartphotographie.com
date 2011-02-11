	<div id="bio" class="self-clear"<?php p2_bio_minimized(); ?>>
		<div id="bio-outer">
			<div id="bio-inner" class="self-clear">				
	<?php 
	// bio picture
	if (p2_option('biopiconoff',0) == "on") { 
		$noscript_close = $noscript = '';
		if ( p2_using_random_bio_images() ) {
			echo '<script type="text/javascript">randombiopics();</script>';
			$noscript = '<noscript>';
			$noscript_close = '</noscript>';
		}
		echo "\t\t\t$noscript"; ?><img id="biopic" src="<?php p2_imageurl('biopic1'); ?>" <?php p2_imageHTML('biopic1'); ?> alt="<?php bloginfo('name'); ?> bio picture" /><?php echo $noscript_close;
	 } ?>

				<div id="biocolumns"> 
					<?php
					
					// bio text content
					$header1 	= 	p2_option('bioheader1',0);
					$header2 	= 	p2_option('bioheader2',0);
					$header3 	= 	p2_option('bioheader3',0);
					$header4 	= 	p2_option('bioheader4',0);
					$para1 		= 	p2_option('biopara1',0);
					$para2 		= 	p2_option('biopara2',0);
					$para3 		= 	p2_option('biopara3',0);
					$para4 		= 	p2_option('biopara4',0);
					
					echo "<div id=\"biocolumn1\" class=\"biocolumn self-clear\">"; 
					if ($header1) 	echo "\n\t\t\t\t\t<h2>" . $header1 . '</h2>';
					if (!empty($para1)) 	{ 
						echo "\n\t\t\t\t\t";
						echo $tmp = wpautop($para1);
					}
					if ($header2) 	echo "\n\t\t\t\t\t<h2>" . $header2 . '</h2>';
					if ($para2)	{ 
						echo "\n\t\t\t\t\t";
						echo $tmp = wpautop($para2);
					}
					echo "\n\t\t\t\t</div><!-- #biocolumn1 .biocolumn -->\n";
		
					if (p2_option('bio2column',0) == "on") {
						echo "\t\t\t\t<div id=\"biocolumn2\" class=\"biocolumn self-clear\">"; 
						if ($header3) 	echo "\n\t\t\t\t\t<h2>" . $header3 . '</h2>';
						if ($para3) 	{ 
							echo "\n\t\t\t\t\t";
							echo $tmp = wpautop($para3);
						}
						if ($header4) 	echo "\n\t\t\t\t\t<h2>" . $header4 .	'</h2>';
						if ($para4) { 
							echo "\n\t\t\t\t\t";
							echo $tmp = wpautop($para4);
						}
						echo "\n\t\t\t\t</div><!-- .biocolumn -->\n";
					} 
					
					// holder for twitter badge
					if ( ! p2_test( 'bio_twitter', 'off' ) ) 
						echo '<div id="twitter-badge"><script type="text/javascript" charset="utf-8">
							biotwitter();
						</script></div>';
				
					// add the bio signature, if applicable
					if ( p2_image_exists( 'bio_signature' ) ) {
						echo '<img class="png" id="bio-signature" src="';
						p2_imageurl( 'bio_signature' );
						echo '" ';
						p2_imageHTML( 'bio_signature' );
						echo ' alt="" />';
					}

					?>
				</div><!-- #biocolumns-->
			</div><!-- #bio-inner -->
		</div><!-- #bio-outer--> 
		<?php if ( p2_option( 'bio_border', 0 ) == 'image' ) { ?>
		<div id="bio-separator" class="self-clear"></div>	
		<?php } ?>
	</div><!-- #bio--> 
	
	