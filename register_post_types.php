<?php
//Create "to-do" post type
function cptui_register_my_cpts() {

	/**
	 * Post Type: To-Dos.
	 */

	$labels = [
		"name" => esc_html__( "To-Dos", "mightylucy" ),
		"singular_name" => esc_html__( "To-Do", "mightylucy" ),
		"menu_name" => esc_html__( "My To-Dos", "mightylucy" ),
		"all_items" => esc_html__( "All To-Dos", "mightylucy" ),
		"add_new" => esc_html__( "Add new", "mightylucy" ),
		"add_new_item" => esc_html__( "Add new To-Do", "mightylucy" ),
		"edit_item" => esc_html__( "Edit To-Do", "mightylucy" ),
		"new_item" => esc_html__( "New To-Do", "mightylucy" ),
		"view_item" => esc_html__( "View To-Do", "mightylucy" ),
		"view_items" => esc_html__( "View To-Dos", "mightylucy" ),
		"search_items" => esc_html__( "Search To-Dos", "mightylucy" ),
		"not_found" => esc_html__( "No To-Dos found", "mightylucy" ),
		"not_found_in_trash" => esc_html__( "No To-Dos found in trash", "mightylucy" ),
		"parent" => esc_html__( "Parent To-Do:", "mightylucy" ),
		"featured_image" => esc_html__( "Featured image for this To-Do", "mightylucy" ),
		"set_featured_image" => esc_html__( "Set featured image for this To-Do", "mightylucy" ),
		"remove_featured_image" => esc_html__( "Remove featured image for this To-Do", "mightylucy" ),
		"use_featured_image" => esc_html__( "Use as featured image for this To-Do", "mightylucy" ),
		"archives" => esc_html__( "To-Do archives", "mightylucy" ),
		"insert_into_item" => esc_html__( "Insert into To-Do", "mightylucy" ),
		"uploaded_to_this_item" => esc_html__( "Upload to this To-Do", "mightylucy" ),
		"filter_items_list" => esc_html__( "Filter To-Dos list", "mightylucy" ),
		"items_list_navigation" => esc_html__( "To-Dos list navigation", "mightylucy" ),
		"items_list" => esc_html__( "To-Dos list", "mightylucy" ),
		"attributes" => esc_html__( "To-Dos attributes", "mightylucy" ),
		"name_admin_bar" => esc_html__( "To-Do", "mightylucy" ),
		"item_published" => esc_html__( "To-Do published", "mightylucy" ),
		"item_published_privately" => esc_html__( "To-Do published privately.", "mightylucy" ),
		"item_reverted_to_draft" => esc_html__( "To-Do reverted to draft.", "mightylucy" ),
		"item_scheduled" => esc_html__( "To-Do scheduled", "mightylucy" ),
		"item_updated" => esc_html__( "To-Do updated.", "mightylucy" ),
		"parent_item_colon" => esc_html__( "Parent To-Do:", "mightylucy" ),
	];

	$args = [
		"label" => esc_html__( "To-Dos", "mightylucy" ),
		"labels" => $labels,
		"description" => "A conversation-starter, a to-do, a task, etc.",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"can_export" => true,
		"rewrite" => [ "slug" => "todo", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-format-chat",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "trackbacks", "custom-fields", "comments", "revisions", "author", "page-attributes", "post-formats" ],
		"show_in_graphql" => false,
	];

	register_post_type( "todo", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );