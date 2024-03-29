<?php
/*
Plugin Name: MightyLucy by Toby Cryns
Plugin URI: https://www.themightymo.com/
Description: A conversation-oriented project management solution using WordPress.  Inspired by Basecamp.  
Author: themightymo, Toby Cryns
Author URI: https://www.themightymo.com
License: GPLv2 or later
Text Domain: themightymo
Version: 0.2
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

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
//include( plugin_dir_path( __FILE__ ) . 'shortcodes.php');



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
    $output = '<a href="/assigned-to/?assigned_to=' . $userID . '" title="' . $userName . '">' . $userName . '</a>';

    return $output;
}

// Register the shortcode with WordPress
add_shortcode('display_assigned_to_user_link', 'display_assigned_to_user_link');




/*
	[display_tagged_users_links]
	In this function:

	We retrieve the "tagged_users" field, which should return an array of user objects.
	We check if any users are tagged; if not, a message is shown.
	If there are tagged users, we loop through each user, creating a list item with a link to their profile page (or any other page you'd prefer).
	We use get_author_posts_url to get the URL to the user's author page. If you have a custom profile page, you may need to adjust this URL.
	Now, by using the shortcode [display_tagged_users_links] in your posts, you can display a list of tagged users with links to their profiles or author pages. Make sure the tagged_users field is configured correctly in ACF to return user objects, and adjust the user link generation as needed for your site's requirements.
*/
function display_tagged_users_links($atts) {
    global $post;

    // Ensure we are on a 'todo' post type
    if ($post->post_type !== 'todo') {
        return '';
    }

    // Get the 'tagged_users' field which returns an array of user objects
    $tagged_users = get_field('tagged_users', $post->ID);

    // Check if there are tagged users
    if (empty($tagged_users)) {
        return 'No users tagged.';
    }

    // Start building the output
    $output = '<span class="tagged-users">';

    // Loop through the users and create a link for each
    foreach ($tagged_users as $user) {
        // Assume you want to link to the user's author page or a custom profile page
        $user_link = get_author_posts_url($user['ID']);

        // Append each user's link to the output
        $output .= '<a href="' . esc_url($user_link) . '">' . esc_html($user['display_name']) . '</a> ';
    }

    $output .= '</span>';

    return $output;
}

// Register the shortcode with WordPress
add_shortcode('display_tagged_users_links', 'display_tagged_users_links');








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








/*
	[list_my_todos]
	Shortcode to display the currently logged in user's to-dos
*/
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
        'author' => $current_user->ID,
    );

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return "No tasks found assigned to you.";
    }

    // Start building the output
    $output = '<ul class="list-my-todos">';
    while ($query->have_posts()) {
        $query->the_post();

        // Assuming each "todo" post is associated with one "customer" term
        $customers = wp_get_post_terms(get_the_ID(), 'customer');
        $logo_html = '';

        if (!empty($customers)) {
            // Fetch the first term
            $customer = $customers[0];

            // Get the 'logo' field (ID) for the term
            $logo_id = get_field('logo', 'customer_' . $customer->term_id);
            if ($logo_id) {
                // Get the image URL from the attachment ID
                $logo_url = wp_get_attachment_image_url($logo_id, 'thumbnail'); // You can change 'thumbnail' to any other image size
                // Construct image tag
                $logo_html = '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr($customer->name) . '" style="width:50px;height:auto;"> ';
            }
        }

        $output .= '<li>' . $logo_html . '<a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    }
    wp_reset_postdata();  // Reset the global post object
    $output .= '</ul>';

    return $output;
}

// Register the shortcode with WordPress [list_my_todos]
add_shortcode('list_my_todos', 'list_my_todos');



function toby_list_terms_custom_taxonomy( $atts ) {
    // Inside the function, we extract the custom taxonomy parameter of our shortcode
    extract( shortcode_atts( array(
        'custom_taxonomy' => '',
    ), $atts ) );

    $terms = get_terms([
        'taxonomy' => $custom_taxonomy,
        'hide_empty' => false,
    ]);

    $output = '';
    foreach ($terms as $term) {
        // Get the 'logo' field for the term
        $logo_id = get_field('logo', $term);
        $logo_url = wp_get_attachment_image_url($logo_id, 'full'); // Adjust image size as needed

        // Check if there's a logo to display
        $logo_img = $logo_url ? '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr($term->name) . ' Logo" class="customer_logo" style="max-width:50px;">' : '';

        $output .= '<li>' . $logo_img . '<a href="' . get_term_link($term) . '">' . $term->name . '</a></li>';
    }

    return '<ul class="toby-terms">' . $output . '</ul>';
}
add_shortcode( 'toby_terms', 'toby_list_terms_custom_taxonomy' );
