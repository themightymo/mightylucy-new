<?php
/**
 * @package Table Sorter jQuery Loader
 * @author Toby Cryns
 * @version 1.0
 */
/*
Plugin Name: The Mighty Mo! Table Sorter jQuery Loader
Plugin URI: http://tablesorter.com/docs/#Demo
Description: Adds the javascript and jQuery to make the tablesorter run.  Uses http://tablesorter.com/docs/#Demo
Author: Toby Cryns
Version: 1.0
Author URI: http://www.themightymo.com/updates
*/

/*  Copyright 2014  Toby Cryns  (email : toby at themightymo dot com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function tsj_scripts() {
	wp_enqueue_style( 'tsj-style', plugins_url( 'style/style.css' , __FILE__ ) );
	wp_enqueue_script('jquery');
	wp_enqueue_script('table-sorter-js', plugins_url( 'js/jquery.tablesorter.js' , __FILE__ ), array( 'jquery' ));
	wp_enqueue_script('table-sorter-metadata', plugins_url( 'js/jquery.metadata.js' , __FILE__ ), array( 'table-sorter-js' ));
	wp_enqueue_script('table-sorter-custom', plugins_url( 'js/custom.js' , __FILE__ ), array( 'table-sorter-metadata' ));
	wp_enqueue_script('table-to-csv', plugins_url( 'js/table2CSV.js' , __FILE__ ), array( 'table-sorter-metadata' ));
}

add_action( 'wp_enqueue_scripts', 'tsj_scripts' );