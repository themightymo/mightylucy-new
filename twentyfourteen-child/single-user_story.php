<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', 'userstory' );

					// Previous/next post navigation.
					//twentyfourteen_post_nav();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					
					
					//get_status
					
					//onactive=6 done=4
					$arr_user_story_done_or_not=get_field('user_story_done_or_not');
					$doneornot=get_term($arr_user_story_done_or_not[0],'user_story_done_or_not');
					if($doneornot->slug=='done'){ //if done
					   $radiobuttons='<tr><td><h5>Status:</h5></td><td><input id="bactive"  name="status_story" class="active user_story_status" type="radio"  value="activexxx'.get_the_ID().'"> Active</td><td><input id="bdone"   name="status_story" class="done user_story_status"  type="radio"  value="donexxx'.get_the_ID().'" checked> Done</td></tr>'; 		
					}else{
						$radiobuttons='<tr><td><h5>Status:</h5></td><td><input id="bactive"  name="status_story" class="active user_story_status" type="radio"  value="activexxx'.get_the_ID().'"  checked> Active</td><td><input id="bdone" name="status_story" class="done user_story_status"  type="radio"  value="donexxx'.get_the_ID().'"> Done</td></tr>'; 
					}
					?>
					
					<div id="b_story_status"><table><?php echo $radiobuttons;?></table><div class="ajax_status"></div></div>
				<?php endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();

?>
<script>
(function($) {  
    $(document).on("click",".user_story_status",function(){
       status_value=$(this).attr('id');
	   
	   if(status_value=='tactive'){
	       $("#bactive").prop("checked", true);
	   }else if(status_value=='bactive'){
	       $("#tactive").prop("checked", true);
	   }
	   if(status_value=='tdone'){
	       $("#bdone").prop("checked", true);
	   }else if(status_value=='bdone'){
	       $("#tdone").prop("checked", true);
	   }
	});
   
   $(document).on("change",".user_story_status",function(){
       var data = {
            action: 'change_status',
            data_status:$(this).val(), 
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        $.post(ajaxurl, data, function(response) {
		    //alert(response);
           $('.ajax_status').html(response);
        }); 
	});
	
})( jQuery );
</script>
<?php

get_footer();
