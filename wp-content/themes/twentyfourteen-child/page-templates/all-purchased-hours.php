<?php
/**
 * Template Name: REPORT: All Purchased Hours
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
get_currentuserinfo(); // NOTE: I don't know why, but this call to get_currentuserinfo() fixes a bug that was causing the home page of each sub-site to display when not logged in.
 ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			
									
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php twentyfourteen_post_thumbnail(); ?>
					
						<header class="entry-header">
							
							<h1 class="entry-title">REPORT: All Active Sites</h1>	
											
						</header><!-- .entry-header -->
					
						
						<div class="entry-content">
						
							<?php
							//getpostmeta  xxx
							//update_post_meta($post_id, $meta_key, $meta_value)  meta_value=sites_orderxxxblogID
														
							$args = array(
										'archived'   => false,
										'mature'     => false,
										'spam'       => false,
										'deleted'    => false,
										'sort_column'=> 'registered',
									);
									
							$blog_list = wp_get_sites($args);
							?>
							<table>
							<?php
							foreach ($blog_list as $blog) {
								$blogID = $blog['blog_id'];
								$site_order=get_user_meta(1,'sites_orderxxx'.$blogID,true);
								$site_orderx[]=$site_order.'yyy'.$blogID;
								if(empty($site_order)){
								   $site_order=-1;
								}
								$blog_details=get_blog_details($blogID);
								$arr_site['blogID']=$blogID;
								$arr_site['blogOrder']=$site_order;
								$arr_site['blogURL']=$blog_details->siteurl;
								$arr_site['blogName']=$blog_details->blogname;
								
								
								
							
							
								$arr_prepaid_hours = array();
								
								switch_to_blog($blog['blog_id']);
									
									/*echo '<pre>';
									print_r(get_field('prepaid_hours', 'options'));
									echo '</pre>';*/
									
									$prepaid_hours = get_field('prepaid_hours', 'options');
									foreach ($prepaid_hours as $number_of_hours_purchased) {
										
										$arr_prepaid_hours['number_of_hours_purchased'] = $number_of_hours_purchased['number_of_hours_purchased'];
										$arr_prepaid_hours['date_of_purchase'] = $number_of_hours_purchased['date_of_purchase'];
										$arr_prepaid_hours['blogname'] = get_bloginfo('name');
										
										echo '<pre>';
										print_r($arr_prepaid_hours);
										echo '</pre>';
										
										echo '<tr><td>' . $number_of_hours_purchased['number_of_hours_purchased'] . '</td><td>' . $number_of_hours_purchased['date_of_purchase'] . '</td><td>' . get_bloginfo('name') . '</td></tr>';
									}
									
									//usort($arr_prepaid_hours, 'date_of_purchase');
										
									
									
									
									/*if( get_field('prepaid_hours', 'options') ) {
										while( has_sub_field('number_of_hours_purchased') ) { 
											$hours_purchased = get_sub_field('number_of_hours_purchased');
											echo 'Hours Purchased:' . $hours_purchased;
											// do something with sub field...
										}
									}*/
								
								restore_current_blog();
								
								$arr_sites[]=$arr_site;
							}
							
							?>
							</table>
							<?php
							echo '<ul>';
							foreach ($arr_sites as $blog) {
								
								echo '<li>' . $blog['blogName'] . '</li>';
							}
							echo '</ul>';
							
							?>
														
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