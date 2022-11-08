<?php
/*
Plugin Name: MightyLucy
Plugin URI: https://www.themightymo.com/
Description: A conversation-oriented project management solution using WordPress.  Inspired by Basecamp.  
Author: themightymo, Toby Cryns
Author URI: https://www.themightymo.com
License: GPLv2 or later
Text Domain: themightymo
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

//Register To-Do Categories & Tags
function cptui_register_my_taxes() {

	/**
	 * Taxonomy: To-Do Categories.
	 */

	$labels = [
		"name" => esc_html__( "To-Do Categories", "mightylucy" ),
		"singular_name" => esc_html__( "To-Do Category", "mightylucy" ),
	];

	
	$args = [
		"label" => esc_html__( "To-Do Categories", "mightylucy" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'todo_category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "todo_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "todo_category", [ "to-do" ], $args );

	/**
	 * Taxonomy: To-Do Tags.
	 */

	$labels = [
		"name" => esc_html__( "To-Do Tags", "mightylucy" ),
		"singular_name" => esc_html__( "To-Do Tag", "mightylucy" ),
	];

	
	$args = [
		"label" => esc_html__( "To-Do Tags", "mightylucy" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'todo_tags', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "todo_tags",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "todo_tags", [ "to-do" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );


