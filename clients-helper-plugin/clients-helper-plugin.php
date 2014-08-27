<?php
/*
Plugin Name: The Mighty Mo! Clients Helper Plugin
Plugin URI: http://www.themightymo.com/
Description: Supports Mighty Lucy!
Author: toby
Version: 1.0
Author URI: http://www.themightymo.com/
Text Domain: tmm-clients-helper-plugin
License: GPLv2
*/

add_filter('upload_mimes', 'custom_upload_mimes');

function custom_upload_mimes ( $existing_mimes = array() ) {
    $existing_mimes['psd'] = 'image/vnd.adobe.photoshop';
    return $existing_mimes;
}



function my_scripts_method() {
	wp_enqueue_script(
		'custom-script',
		plugins_url( 'clients-helper-plugin.js' , __FILE__ ),
		array( 'jquery' )
	);
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

function my_login_logo() { 
	$image = plugins_url() . '/clients-helper-plugin/login-background-images/' . (mt_rand(1,27)) . '.jpg'; 
	?>
    <style type="text/css">
        body {
			background:#000 url(<?php echo $image; ?>) repeat center center;
			background-size: cover;
		}
		body #login h1 a, body .login h1 a {
			background-size:auto !important;
			display: block !important;
		}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

add_action('init', 'cptui_register_my_cpt_view');
function cptui_register_my_cpt_view() {
	register_post_type('view', array(
		'label' => 'Views',
		'description' => '',
		'menu_icon'=> 'dashicons-desktop',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => true,
		'rewrite' => array('slug' => 'view', 'with_front' => true),
		'query_var' => true,
		'has_archive' => true,
		'supports' => array('title','editor','excerpt','custom-fields','comments','revisions','thumbnail','author','page-attributes'),
		'taxonomies' => array('page_views'),
		'labels' => array (
			'name' => 'Views',
			'singular_name' => 'View',
			'menu_name' => 'Views',
			'add_new' => 'Add View',
			'add_new_item' => 'Add New View',
			'edit' => 'Edit',
			'edit_item' => 'Edit View',
			'new_item' => 'New View',
			'view' => 'View View',
			'view_item' => 'View View',
			'search_items' => 'Search Views',
			'not_found' => 'No Views Found',
			'not_found_in_trash' => 'No Views Found in Trash',
			'parent' => 'Parent View',
		)
	) 
	); 
}

add_action('init', 'cptui_register_my_cpt_time_entry');
function cptui_register_my_cpt_time_entry() {
	register_post_type('time_entry', array(
		'label' => 'Time Entries',
		'description' => '',
		'menu_icon'=> 'dashicons-clock',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => true,
		'rewrite' => array('slug' => 'time_entry', 'with_front' => true),
		'query_var' => true,
		'has_archive' => true,
		'supports' => array('title','editor','custom-fields','author'),
		'labels' => array (
			'name' => 'Time Entries',
			'singular_name' => 'Time Entry',
			'menu_name' => 'Time Entries',
			'add_new' => 'Add Time Entry',
			'add_new_item' => 'Add New Time Entry',
			'edit' => 'Edit',
			'edit_item' => 'Edit Time Entry',
			'new_item' => 'New Time Entry',
			'view' => 'View Time Entry',
			'view_item' => 'View Time Entry',
			'search_items' => 'Search Time Entries',
			'not_found' => 'No Time Entries Found',
			'not_found_in_trash' => 'No Time Entries Found in Trash',
			'parent' => 'Parent Time Entry',
		)
	) 
	); 
}

add_action('init', 'cptui_register_my_cpt_user_story');
function cptui_register_my_cpt_user_story() {
	register_post_type('user_story', array(
		'label' => 'To-Dos',
		'description' => '',
		'menu_icon'=> 'dashicons-tickets',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => true,
		'rewrite' => array('slug' => 'user_story', 'with_front' => true),
		'query_var' => true,
		'has_archive' => true,
		'supports' => array('title','editor','custom-fields','comments','author','page-attributes'),
		'labels' => array (
			'name' => 'To-Dos',
			'singular_name' => 'To-Do',
			'menu_name' => 'To-Dos',
			'add_new' => 'Add To-Do',
			'add_new_item' => 'Add New To-Do',
			'edit' => 'Edit',
			'edit_item' => 'Edit To-Do',
			'new_item' => 'New To-Do',
			'view' => 'View To-Do',
			'view_item' => 'View To-Do',
			'search_items' => 'Search To-Dos',
			'not_found' => 'No To-Dos Found',
			'not_found_in_trash' => 'No To-Dos Found in Trash',
			'parent' => 'Parent To-Do',
		)
	) 
	); 
}

add_action('init', 'cptui_register_my_taxes_page_views');
function cptui_register_my_taxes_page_views() {
register_taxonomy( 'page_views',array (
  0 => 'view',
),
array( 'hierarchical' => true,
	'label' => 'Page Views Taxonomy',
	'show_ui' => true,
	'query_var' => true,
	'show_admin_column' => true,
	'labels' => array (
		'search_items' => 'Page View Taxonomy',
		'popular_items' => '',
		'all_items' => '',
		'parent_item' => '',
		'parent_item_colon' => '',
		'edit_item' => '',
		'update_item' => '',
		'add_new_item' => '',
		'new_item_name' => '',
		'separate_items_with_commas' => '',
		'add_or_remove_items' => '',
		'choose_from_most_used' => '',
	)
) 
); 
}

add_action('init', 'cptui_register_my_taxes_user_story_categories');
function cptui_register_my_taxes_user_story_categories() {
register_taxonomy( 'user_story_categories',array (
  0 => 'user_story',
),
array( 'hierarchical' => true,
	'label' => 'To-Do Categories',
	'show_ui' => true,
	'query_var' => true,
	'show_admin_column' => true,
	'labels' => array (
  'search_items' => 'To-Do Category',
  'popular_items' => '',
  'all_items' => '',
  'parent_item' => '',
  'parent_item_colon' => '',
  'edit_item' => '',
  'update_item' => '',
  'add_new_item' => '',
  'new_item_name' => '',
  'separate_items_with_commas' => '',
  'add_or_remove_items' => '',
  'choose_from_most_used' => '',
)
) ); 
}

add_action('init', 'cptui_register_my_taxes_time_entry_categories');
function cptui_register_my_taxes_time_entry_categories() {
	register_taxonomy( 'time_entry_categories',array (
	  0 => 'time_entry',
	),
	array( 'hierarchical' => true,
		'label' => 'Time Entry Categories',
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
		'labels' => array (
			'search_items' => 'Time Entry Category',
			'popular_items' => '',
			'all_items' => '',
			'parent_item' => '',
			'parent_item_colon' => '',
			'edit_item' => '',
			'update_item' => '',
			'add_new_item' => '',
			'new_item_name' => '',
			'separate_items_with_commas' => '',
			'add_or_remove_items' => '',
			'choose_from_most_used' => '',
		)
	) 
	); 
}

add_action('init', 'cptui_register_my_user_story_done_or_not');
function cptui_register_my_user_story_done_or_not() {
	register_taxonomy( 'user_story_done_or_not',array (
	  0 => 'user_story',
	),
	array( 'hierarchical' => true,
		'label' => 'Done or Not done?',
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
		'labels' => array (
			'search_items' => 'Done or not done?',
			'popular_items' => '',
			'all_items' => '',
			'parent_item' => '',
			'parent_item_colon' => '',
			'edit_item' => '',
			'update_item' => '',
			'add_new_item' => '',
			'new_item_name' => '',
			'separate_items_with_commas' => '',
			'add_or_remove_items' => '',
			'choose_from_most_used' => '',
		)
	) 
	); 
}

// Make hyperlinks clickable even if the user doesn't add the html markup
add_filter( 'the_content', 'make_clickable',      12 );