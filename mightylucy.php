<?php
/*
Plugin Name: MightyLucy
Plugin URI: https://www.themightymo.com/
Description: A conversation-oriented project management solution using WordPress.  Inspired by Basecamp.  
Author: themightymo, Toby Cryns
Author URI: https://www.themightymo.com
License: GPLv2 or later
Text Domain: themightymo
Version: 0.1
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2014 The Mighty Mo! Design Co. LLC
*/

//include( plugin_dir_path( __FILE__ ) . 'register_post_types.php');
//include( plugin_dir_path( __FILE__ ) . 'register_taxonomies.php');
include( plugin_dir_path( __FILE__ ) . 'shortcodes.php');



// Add edit_post_link() to single posts in Beaver Builder
add_action( 'fl_after_header', 'bb_do_single_post_top_section' );
function bb_do_single_post_top_section() {
	global $post;
	// If the current page loading is a Single Post
	if(is_single() && get_post_type( $post ) == 'post'){
				edit_post_link( _x( 'Edit', 'Edit post link text.', 'fl-automator' ) );
	}
}

/* 
	Hide the Posts menu in wp-admin
	via https://wordpress.stackexchange.com/questions/36123/how-to-disable-posts-and-use-pages-only
*/
function remove_posts_menu() {
    remove_menu_page('edit.php');
}
add_action('admin_menu', 'remove_posts_menu');






// Create shortcode to display the ACF User relational field on "todo" post types.
function display_assigned_to_user_link($atts) {
    // Get the global post object
    global $post;

    // Get the 'assigned_to' field value
    $assigned_users = get_field('assigned_to', $post->ID);		
	$userID = get_field('assigned_to', $post->ID);   // grabs the user ID
	$userName = get_the_author_meta('display_name', $userID);
	//$userSlug = get_the_author_meta ('user_login' , $userID);
	
    // Check if there are assigned users
    if (empty($assigned_users)) {
        return 'No users assigned.' . $assigned_users . $post->ID . 'Rat farts!';
    }

    // Start building the output
    $output = 'Assigned to: ' . '<a href="/assigned-to/?assigned_to=' . $userID . '" title="' . $userName . '">' . $userName . '</a>';

    return $output;
}

// Register the shortcode with WordPress
add_shortcode('display_assigned_to_user_link', 'display_assigned_to_user_link');



/* 
	Add the ability to use the "assigned_to" url parameter
	via https://stackoverflow.com/questions/13652605/extracting-a-parameter-from-a-url-in-wordpress
*/
add_action('init','add_get_val');
function add_get_val() { 
    global $wp; 
    $wp->add_query_var('assigned_to'); 
}

// Create shortcode to display the ACF User relational field on "todo" post types.
function display_assigned_to_user_content ($atts) {
	
	// via https://stackoverflow.com/questions/13652605/extracting-a-parameter-from-a-url-in-wordpress

	// Arguments for the WP_Query
    $args = array(
        'post_type' => 'todo',
        'posts_per_page' => -1,  // Retrieve all posts
        'meta_key' => 'assigned_to',  // Adjust if your ACF field name is different
        'meta_value' =>  get_query_var('assigned_to'),
        'compare' => '='
    );
  

    $query = new WP_Query($args);
    if (!$query->have_posts()) {
        return 'Rat farts!!!';
    }


    // Start building the output
    $output = '<ul>';
    while ($query->have_posts()) {
        $query->the_post();
        $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    }
    wp_reset_postdata();  // Reset the global post object
    $output .= '</ul>';

    return '<h1>To-dos assigned to ' . get_the_author_meta('display_name', get_query_var('assigned_to')) . '</h1>' . $output;
}

// Register the shortcode with WordPress
add_shortcode('display_assigned_to_user_content', 'display_assigned_to_user_content');








// Shortcode to display teh currently logged in user's to-dos
function list_my_todos($atts) {
    // Get the current user
    $current_user = wp_get_current_user();
    if (!$current_user->exists()) {
        return 'You must be logged in to see your tasks.';
    }
    
    // Arguments for the WP_Query
    $args = array(
        'post_type' => 'todo',
        'posts_per_page' => -1,  // Retrieve all posts
        'meta_key' => 'assigned_to',  // Adjust if your ACF field name is different
        'meta_value' =>  $current_user->ID,
        'compare' => '='
    );
  

    $query = new WP_Query($args);
    if (!$query->have_posts()) {
        return 'No tasks found assigned to you.';
    }


    // Start building the output
    $output = '<ul>';
    while ($query->have_posts()) {
        $query->the_post();
        $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    }
    wp_reset_postdata();  // Reset the global post object
    $output .= '</ul>';

    return $output;
}

// Register the shortcode with WordPress [list_my_todos]
add_shortcode('list_my_todos', 'list_my_todos');

