<?php
/*
Plugin Name: MightyLucy
Plugin URI: https://www.themightymo.com/
Description: Adds functionality to mightylucy website.  
Author: themightymo
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

Copyright 2016 The Mighty Mo! Design Co.
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