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

Copyright 2017 The Mighty Mo! Design Co. LLC
*/

/*
	TIME ENTRY CONTENT 
*/
// If post type is time_entry, then display the date worked	
add_filter( 'the_content', 'return_acf_time_entry_content' ); 
function return_acf_time_entry_content ( $content ) { 
    
    // Get to-do info
    global $post;
	$todo_post_object = get_field( 'to-do_worked_on' );
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
			$term = get_term( get_field('customer'), 'customer' );
			$customer_name = $term->name;
			$customer = '<div class="customer" style="clear:both;margin-bottom:1em;">Customer: <a href="' . esc_url( get_term_link( $term ) ) . '">' . $term->name . '</a></div>';
			 
		}

        $content = $todo_basics . $hours_estimate . $customer . $content;
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
	remove_meta_box( 'customerdiv', 'todo', 'side' );
	remove_meta_box( 'tagsdiv-to_do_status', 'todo', 'side' );	
}
add_action( 'admin_menu', 'remove_custom_taxonomy_meta_boxes' );