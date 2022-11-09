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

//include( plugin_dir_path( __FILE__ ) . 'register_post_types.php');
//include( plugin_dir_path( __FILE__ ) . 'register_taxonomies.php');
include( plugin_dir_path( __FILE__ ) . 'shortcodes.php');



// Add edit_post_link() to single posts in Beaver Builder
add_action( 'fl_after_header', 'bb_do_single_post_top_section' );
function bb_do_single_post_top_section() {
	// If the current page loading is a Single Post
	if(is_single() && get_post_type( $post ) == 'post'){
				edit_post_link( _x( 'Edit', 'Edit post link text.', 'fl-automator' ) );
	}
}