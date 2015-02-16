<?php

/*
 * Plugin Name: Display Posts By Recency by The Mighty Mo! Design Co.
 * Plugin URI: http://www.themightymo.com/
 * Description: By default, display Time Entries, Todos, & Posts by recency.
 * Author: The Mighty Mo! Design Co. LLC - Abel
 * Author URI: http://www.themightymo.com/
 * License: GPLv2 (or later)
 * Version: 1.0
 */

/* Sort posts in wp_list_table by column in ascending or descending order. */
function custom_post_order($query) {
	/* 
		Set post types.
		_builtin => true returns WordPress default post types. 
		_builtin => false returns custom registered post types. 
	*/
//	$post_types = get_post_types(array('_builtin' => true), 'names');
	$post_types = array( 'user_story', 'time_entry', 'post' );
	/* The current post type. */
	$post_type = $query->get('post_type');
	/* Check post types. */
	if(in_array($post_type, $post_types)) {
		/* Post Column: e.g. title */
		if( $query->get( 'orderby' ) == '') {
			$query->set( 'orderby', 'date' );
 		}
 		/* Post Order: ASC / DESC */
 		if($query->get('order') == '') {
	 		$query->set('order', 'DESC');
	 	}
	}
}

add_action('pre_get_posts', 'custom_post_order');