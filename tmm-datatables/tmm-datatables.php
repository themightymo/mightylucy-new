<?php
/**
 * @package Datatables jQuery Loader
 * @author Toby Cryns
 * @version 1.0
 */
/*
Plugin Name: The Mighty Mo! Datatables jQuery Loader
Plugin URI: http://www.datatables.net/manual/installation
Description: Adds the javascript and jQuery to make the datatables scripts run.  Uses http://www.datatables.net/manual/installation
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

function datatables_scripts() {
	wp_enqueue_style( 'datatables-core-style', plugins_url( 'css/jquery.dataTables.min.css' , __FILE__ ) );
	wp_enqueue_style( 'datatables-custom-style', plugins_url( 'css/custom.css' , __FILE__ ) );
	wp_enqueue_script('jquery');
	wp_enqueue_script('datatables-core-js', plugins_url( 'js/jquery.dataTables.min.js' , __FILE__ ), array( 'jquery' ));
	wp_enqueue_script('datatables-custom-js', plugins_url( 'js/custom.js' , __FILE__ ), array( 'datatables-core-js' ));
}

add_action( 'wp_enqueue_scripts', 'datatables_scripts' );