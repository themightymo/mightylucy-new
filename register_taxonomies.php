<?php


//Register To-Do Categories & Tags
function cptui_register_my_taxes() {
	
	/**
	 * Taxonomy: Customers
	 */

	$labels = [
		"name" => esc_html__( "Customers", "mightylucy" ),
		"singular_name" => esc_html__( "Customer", "mightylucy" ),
	];

	
	$args = [
		"label" => esc_html__( "Customers", "mightylucy" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'customer', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "customer",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "customer", [ "todo" ], $args );

	/**
	 * Taxonomy: To-Do Categories.
	 */

	/*$labels = [
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
	register_taxonomy( "todo_category", [ "todo" ], $args );
	*/

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
	register_taxonomy( "todo_tags", [ "todo" ], $args );
	
	/**
	 * Taxonomy: To-Do Statuses.
	 */

	$labels = [
		"name" => esc_html__( "To-Do Statuses", "mightylucy" ),
		"singular_name" => esc_html__( "To-Do Status", "mightylucy" ),
	];

	
	$args = [
		"label" => esc_html__( "To-Do Status", "mightylucy" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'todo_status', 'with_front' => true, ],
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
	register_taxonomy( "todo_status", [ "todo" ], $args );
	
}
add_action( 'init', 'cptui_register_my_taxes' );


