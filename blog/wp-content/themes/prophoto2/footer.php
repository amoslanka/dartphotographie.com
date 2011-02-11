	<div id="footer">
		
		<?php p2_insert_audio_player( 'bottom' ); ?>
		
		<p><?php if ( p2_test( 'custom_copyright' ) ) { p2_option( 'custom_copyright' ); } else { ?>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); } ?> <?php wp_footer(); ?></p>
		
	</div><!-- #footer -->

</div><!-- #wrapper -->

</div><!-- #outerwrapper -->

<?php p2_google_analytics(); ?>

<?php p2_closing_tags(); ?>