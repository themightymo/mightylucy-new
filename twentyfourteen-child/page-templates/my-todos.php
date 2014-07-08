<?php
/**
 * Template Name: REPORT: My To-Dos
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>
<?php
global $current_user;
get_currentuserinfo(); // NOTE: I don't know why, but this call to get_currentuserinfo() fixes a bug that was causing the home page of each sub-site to display when not logged in.
 ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			
									
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php twentyfourteen_post_thumbnail(); ?>
					
						<header class="entry-header">
							
							<div class="entry-meta">
								
							</div>
							<h1 class="entry-title">REPORT: My To-Dos</h1>	
											
							<div class="entry-meta">
								
							</div><!-- .entry-meta -->
						</header><!-- .entry-header -->
					
						
						<div class="entry-content">
						
							<?php
							
							$singleUserStory = array();
							$userStories = array();
							$blog_list = get_blog_list( 0, 'all' );
							foreach ($blog_list AS $blog) {
								$blogID = $blog['blog_id'];
								if ($blogID != 11) {
									switch_to_blog($blogID);
									
									$args = array( 
										'posts_per_page' => -1,
										'post_type' => 'user_story',
										'tax_query' => array(
											array(
												'taxonomy' => 'user_story_done_or_not',
												'field' => 'slug',
												'terms' => 'active'
											)
										) 
									);
									
									$myposts = get_posts( $args );
									
									$blog_details = get_blog_details($blogID);
									//$blogName = $blog_details->blogname;
									//echo 'Blog '.$blog_details->blog_id.' is called '.$blog_details->blogname.'.';
	  
									foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
										<?php 
										$singleUserStory['sitename'] = $blog_details->blogname;
										$singleUserStory['title'] = get_the_title();
										$singleUserStory['url'] = get_permalink();
										$singleUserStory['id'] =  get_the_ID();
										$singleUserStory['blogid'] = $blogID;
										$singleUserStory['menu_order'] = $post->menu_order;
										
										if (get_field('assigned_to')){
											$assigned_to = get_field('assigned_to');
											$singleUserStory['dev'] = $assigned_to['display_name'];
										} else {
											$singleUserStory['dev'] = 'unassigned';
										}
										//I can't figure out how to get get_comments_count() to work...battery on my computer dying...
										//$singleUserStory['commentCount'] = comments_number( 'no responses', 'one response', '% responses' );
										$userStories[] = $singleUserStory;
										
									endforeach; 
									wp_reset_postdata(); 
									restore_current_blog();
								}?>
								<?php
							}
							
							/*sort by menu_order*/
							$menu_order = array();
							foreach ($userStories as $key => $row)
							{
								$menu_order[$key] = $row['menu_order'];
							}
							array_multisort($menu_order, SORT_ASC, $userStories);
							
							
							//var_dump($userStories);
							// Display the User Story posts
							echo '<ul id="sortable">';
							foreach ($userStories AS $userStory) {
								if ($current_user->display_name == $userStory['dev']) {
									echo '<li  id="'.$userStory['blogid'].'x'.$userStory['id'].'x'.$userStory['menu_order'].'" class="ui-state-default" ><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><a href="' . $userStory['url'] . '">' . $userStory['sitename'] . ': ' . $userStory['title'] . '</a> [' . $userStory['dev'] . '] ' . $singleUserStory['commentCount'] . '</li>';
								}
							}
							echo '</ul>'; ?>
							
							<script>
								(function($) {  
								var itemList = $('#sortable');
								itemList.sortable({
									update: function(event, ui) {
									    itemlistx=itemList.sortable('toArray').toString();
										//alert('alert='+itemlistx);
										opts = {
											url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
											type: 'POST',
											async: true,
											cache: false,
											dataType: 'json',
											data:{
												action: 'network_sort', // Tell WordPress how to handle this ajax request
												order: itemList.sortable('toArray').toString() // Passes ID's of list items in  1,3,2 format
											},
											//console.log(order);
											success: function(response) {
											    //alert('response='+response);
												return; 
											},
											error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
												//alert(e);
												// alert('There was an error saving the updates');
												return; 
											}
										}; 
										$.ajax(opts);
									}
								
								}); 
							})( jQuery );
							</script>
							
						</div><!-- .entry-content -->
						
					</article><!-- #post-## -->

					
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->
<?php
 ?>
<?php
get_sidebar();
get_footer();