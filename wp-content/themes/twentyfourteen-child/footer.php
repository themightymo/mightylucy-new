<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

		</div><!-- #main -->

		<footer id="colophon" class="site-footer" role="contentinfo">

			<?php get_sidebar( 'footer' ); ?>

			<div class="site-info">
				<?php do_action( 'twentyfourteen_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentyfourteen' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentyfourteen' ), 'WordPress' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->
	<script>
	    (function($) {
		   //hide radio buttons if no value and set the value to in Progress. 5 is Done,  8 is in progress 
		   storystatus=$("input[name='input_14']:checked").val(); 
		   if(storystatus!=5){ //if not done then set in progress
				$('#choice_14_1').prop('checked', true);
		   }
		   
		   //hide in public
		   $('body.page #field_2_14').hide();
		
		})( jQuery );
	</script>

	<?php wp_footer(); ?>
</body>
</html>