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
function display_assigned_to_user($atts) {
    // Get the global post object
    global $post;

    // Ensure we are on a 'todo' post type
    if ($post->post_type !== 'todo') {
        return '';
    }

    // Get the 'assigned_to' field value
    $assigned_users = get_field('assigned_to', $post->ID);
	
			
	$userID = $assigned_users['ID'];   // grabs the user ID			
	
	// grabs corresponding social info from user account
	$userEmail = get_the_author_meta('user_email', $userID); 
	$userName = get_the_author_meta('display_name', $userID); 
	
    // Check if there are assigned users
    if (empty($assigned_users)) {
        return 'No users assigned.' . $assigned_users . $post->ID . 'Rat farts!';
    }
    //var_dump($post);

    // Start building the output
    $output = 'Assigned to: ' . '<a href="' . esc_url( get_author_posts_url( $userID ) ) . '?post_type=todo" title="' . esc_attr( get_the_author() ) . '">' . $userName . '</a>';

    

    return $output;
}

// Register the shortcode with WordPress
// DOESN'T WORK CORRECTLY YET
add_shortcode('display_assigned_to', 'display_assigned_to_user');


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

