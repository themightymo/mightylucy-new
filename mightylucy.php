<?php
/*
Plugin Name: MightyLucy
Plugin URI: https://www.themightymo.com/
Description: Adds functionality to mightylucy website.  
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

	register_post_type( "to_do", $args );
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
		"rewrite" => [ 'slug' => 'to_do_category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "to_do_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "to_do_category", [ "to-do" ], $args );

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
		"rewrite" => [ 'slug' => 'to_do_tags', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "to_do_tags",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "to_do_tags", [ "to-do" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );


/*
	TIME ENTRY CONTENT 
*/
// If post type is time_entry, then display the date worked	
add_filter( 'the_content', 'return_acf_time_entry_content' ); 
function return_acf_time_entry_content ( $content ) { 
    // if it's not a todo, then return the normal content.
    if ( is_singular( 'to_do' ) ) {
	    
	    
    } else {
	
    }
    
    // Get to-do info
    global $post;
	$todo_post_object = get_field( 'todo_worked_on' );
	if ( $todo_post_object ):
		$post = $todo_post_object;
		
		setup_postdata( $post );
			$todo_permalink = get_permalink( get_the_ID() );
			$todo_title = get_the_title( get_the_ID() );
		wp_reset_postdata();
	endif; 

    if ( is_singular('time_entry') ) {
	    //var_dump($todo_post_object);
        $acf_echo = 'Date Worked: ' . get_field( 'date_worked' ) . '<br>';
        $acf_echo .= 'Hours Worked: ' . get_field( 'hours_worked' ) . '<br>';
        $acf_echo .= 'Related To-Do: <a href="' . $todo_permalink . '">' . $todo_title . '</a>';
        //$acf_echo .= var_dump( get_term ( '', get_field( 'customer' ) ) );
        $content = $acf_echo . $content;
	}

    return $content;
}


/*
	TO-DOS CONTENT
*/
// If post type is todo, then display the date worked	
add_filter( 'the_content', 'return_acf_todo_content' ); 
function return_acf_todo_content ( $content ) { 
    
    $assigned_to = get_field('assigned_to');
    
    if ( is_singular('todo') ) {
	    $todo_basics = '<div>This to-do was requested by <span style="font-weight:bold">' . get_the_author() . ' on ' . get_the_date() . '</span> and is assigned to <span style="font-weight:bold">' . $assigned_to['display_name'] . '</span>.</div>';
	    
	    if (get_field('hours_estimate')>0) { 
			$hours_estimate = '<div class="hours-estimate" style="clear:both;">We estimate that this to-do will require <strong>' . get_field('hours_estimate') . ' hours </strong>.</div>';
			 
		}
		
		if ( get_field('customer') ) { 
			$customer = get_field('customer');
			//var_dump($customer);
			$customer_output = '<div class="customer" style="clear:both;margin-bottom:1em;">Customer: <a href="' . get_permalink( $customer->ID ) . '">' . $customer->post_title . '</a></div>';
			 
		}

        $content = $todo_basics . $hours_estimate . $customer_output . $content;
	}
	
	
	
	/*
		Display Related Time Entries on Single todo post type
	*/
	if ( is_singular('todo') ) {
		/*
			Get all time entry posts and display the ones that are attached to this to-do
		*/
		global $current_page_id;
		$current_page_id = get_the_ID();
		
		$timeEntries = get_posts(array(
			'post_type' => 'time_entry',
			'posts_per_page' => -1, 
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'todo_worked_on', // name of custom field
					'value' => $current_page_id, // matches exaclty "123", not just 123. This prevents a match for "1234"
					'compare' => 'LIKE'
				)
			)
		));
	
		
		if( $timeEntries ): ?>
			<quote>
				Time Entries for This To-Do:
				<ul>
				<?php foreach( $timeEntries as $timeEntry ) : ?>
					<?php $hours_invested = get_field( 'hours_worked', $timeEntry->ID ); ?>
					<?php $date_worked = get_field( 'date_worked', $timeEntry->ID ); ?>
					<li>
						<a href="<?php echo get_permalink( $timeEntry->ID ); ?>">
							<?php echo get_the_title( $timeEntry->ID ); ?> (<?php echo $hours_invested; ?> hours on <?php echo date( "F d, Y", strtotime( $date_worked ) ); ?><?php if ( has_term('non-billable','time_entry_categories') ) { echo ', unbilled'; } ?>)
							<?php $totalHoursWorked += $hours_invested; ?>
						</a>
					</li>
				<?php endforeach; ?>
					<li>Total hours invested on this to-do: <?php echo $totalHoursWorked; ?></li>
				</ul>
			</quote>
		<?php 
		endif; 
		
	
	}
	
    return $content;
}




/*
	Single Customer View
*/
// If post type is customer, then display the date worked	
add_filter( 'the_content', 'my_the_content_filter', 20 );
/**
 * Add a icon to the beginning of every post page.
 *
 * @uses is_single()
 */



function my_the_content_filter( $content ) {

    if ( is_singular ('customer') ) {
	    
		if ( have_rows('contact_information') ): 
			while( have_rows('contact_information') ): the_row(); 
			
				$name = get_sub_field('name'); 
				$email = get_sub_field('email');
			    $phone = get_sub_field('phone'); 
		    
		    endwhile; 
		    
		endif;
        
        if ( have_rows('purchases') ): 
			while( have_rows('purchases') ): the_row(); 
			
				$purchase_date = get_sub_field('purchase_date'); 
				$hours_purchased = get_sub_field('hours_purchased');
			    $additional_details = get_sub_field('additional_details'); 
		    
		    endwhile; 
		    
		endif;
		
    	$content .= get_field( 'website_url' ) . '<br><h2>Customer Details</h2>Customer Name: ' . $name . '<br>Customer Email: ' . $email . '<br> Customer Phone: '  . $phone . '<br><br><h2>Hours Purchased</h2>Purchase Date: ' . $purchase_date . '<br>Hours Purchased: ' . $hours_purchased . '<br>Additional Details: ' . $additional_details . '<br>'; 
     
    }
    
    return $content;
}


/*
	SHORTCODES
*/
// Shortcode: To-Dos List
function todos_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'todo_customer' => 'null',
			'todo_assigned_to' => 'null',
		),
		$atts,
		'todos'
	);
	
	function query_todos() {
		
		// WP_Query arguments
		$args = array(
			'post_type' => array( 'todo' ),
			'nopaging' => false,
		);
		
		// The Query
		$query = new WP_Query( $args );
		
		// The Loop
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				
				echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a><br>';
				
				//var_dump($query);
			}
		} else {
			// no posts found
		}
				
		// Restore original Post Data
		wp_reset_postdata();
	    
	}
	
	query_todos();

}
add_shortcode( 'todos', 'todos_shortcode' );


/* 
	Remove Custom Taxonomy Meta Boxes from the "edit" views of custom post 
	types for taxonomies that are handled by ACF 
	via https://codex.wordpress.org/Function_Reference/remove_meta_box
*/

function remove_custom_taxonomy_meta_boxes() {
	//remove_meta_box( 'customerdiv', 'todo', 'side' );
	//remove_meta_box( 'customerdiv', 'time_entry', 'side' );
	remove_meta_box( 'tagsdiv-to_do_status', 'todo', 'side' );	
}
add_action( 'admin_menu', 'remove_custom_taxonomy_meta_boxes' );