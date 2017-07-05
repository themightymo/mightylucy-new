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
			'post_type'=> array( 'todo' ),
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