<?php
/*
Plugin Name: Comment Notifications by The Mighty Mo! Design Co.
Plugin URI: http://www.themightymo.com
Description: Send comment notifications to specific users for EVERY comment that is posted on a site or sub-site. Uses Advanced Custom Fields. Multi-site ready!
Author: Sherwin Calims
Author URI: http://www.themightymo.com
Version: 0.2
Text Domain: tmm-comment-notifications
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
Initially Created By: Sherwin Calims
*/

//while hasfield(emails_to_be_notified) email_address
//option 1

add_action('comment_post', 'notify_author_of_reply', 10, 2);

//based on code from Fabio Trezzi's Notify on Comment plugin
function tagged_users($commentID){
	global $wpdb;
	
	// Get the content of the comment
	$comment = get_comment($commentID);

	// look in the comment content
	$content = $comment->comment_content;
	
	$matches = array();
	//find the @user text
	preg_match_all("/\@[a-z0-9_]+/i", $content, $matches, PREG_SET_ORDER);
	
	//examples of how this is found, notice the structure of the array
	//$firstuser = $matches[0][0];
	//$seconduser = $matches[1][0];
	//$thirduser = $matches[2][0];
	
	$taggeduser = array();
	//preg_match("/\@[a-z0-9_]+/i", $content, $matches);
	$useremails = array();
	$c = count($matches);
	$i = 0;	
	
	while ($i < $c) {
	
		$taggeduser[$i] = $matches[$i][0];
	
		//get just the user name, remove the @ symbol
		$taggeduser[$i] = str_replace('@', '', $taggeduser[$i]);		
								
		// prepare arguments
			$args  = array(
				'meta_query' => array(
					array(
						// uses compare like WP_Query
						'key' => 'nickname',
						'value' => $taggeduser[$i],
						'compare' => '='
						),
				));
				
				// Create the WP_User_Query object
				$wp_user_query = new WP_User_Query($args);
				// Get the results
				$authors = $wp_user_query->get_results();
			
					// loop trough each author
					foreach ($authors as $author)
					{
						// get all the user's data
						$author_info = get_userdata($author->ID);
						$useremails[$i] = $author_info->user_email;
						 
					}
					
				$i++;
	}
	return $useremails;
}

function notify_author_of_reply($comment_id, $approved){
	global $blog_id;
	$current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
	
	$emails_to_be_notified=array();
	if(isset($_POST['selectnotification'])){
		foreach($_POST['selectnotification'] as $value){
			$emails_to_be_notified[]= $value;
		}
	}
 
	if( get_field('emails_to_be_notified', 'option') ):  
		while( has_sub_field('emails_to_be_notified', 'option') ):  
		   $emails_to_be_notified[]=get_sub_field('email_address', 'option');	
		   $emailx.='  '.get_sub_field('email_address', 'option');
		endwhile;  
    endif; 
	
	$emails_to_be_notified=array_unique(array_merge(tagged_users($comment_id),$emails_to_be_notified));
	
  if($approved){
    $comment = get_comment($comment_id);
	$post = get_post($comment->comment_post_ID);
	$comment_author = ($comment->comment_author);
	$subject = $current_blog_details->blogname . " - New comment from " . $comment_author . " on \"" .$post->post_title . "\"";
	$notify_message =  get_avatar( $comment, 64 )." \r\n\r\n On " . get_comment_date("l, F jS, Y") . " at " . get_the_time() . ", " . $comment->comment_author . " wrote: \r\n\r\n" . $comment->comment_content . "\r\n\r\n";
	$notify_message .= '<a href="'.get_comment_link( $comment_id ).'">Click here to reply.</a>' . "\r\n";
	
	wp_mail($emails_to_be_notified, $subject, $notify_message);
  }
}

/** changing default wordpres email settings */
add_filter( 'wp_mail_from_name', 'custom_wp_mail_from_name' );
function custom_wp_mail_from_name( $original_email_from ) {
	return get_bloginfo('name');
}
add_filter( 'wp_mail_from', 'custom_wp_mail_from' );
function custom_wp_mail_from( $original_email_address ) {
	//Make sure the email is from the same domain 
	//as your website to avoid being marked as spam.
	return 'donotreply@mightylucy.com';
}



add_action( 'comment_form_logged_in_after', 'additional_fields' );
add_action( 'comment_form_after_fields', 'additional_fields' );

function additional_fields () {
  $users=get_users();
  $comma='';
  foreach ($users as $user) {
	$users_to_tag.=$comma.' @' . $user->user_nicename;
	$users_select.='<input type="checkbox" name="selectnotification[]" value="'.$user->user_email.'">'.$user->display_name.' | ';
	$comma=' ,';
  }
  $users_to_tag="Here are the available users to notify: ".$users_to_tag.". Just include it to your comment to notify the users.";
  echo '<p><label for="description">' .$users_to_tag. '</label></p><br/>';
  echo '<p><label for="description">Send this comment to:</label><br/>'.$users_select.'</p>';
}


