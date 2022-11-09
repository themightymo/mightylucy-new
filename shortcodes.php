<?php
/*
	Create a shortcode that'll display all the terms in the "Customers" taxonomy
	Via https://www.wpbeginner.com/plugins/how-to-display-custom-taxonomy-terms-in-wordpress-sidebar-widgets/#Displaying-Custom-Taxonomy-Terms-in-a-Widget-Using-Code
	[ct_terms custom_taxonomy=customtaxonomyname]
	[ct_terms custom_taxonomy=customer]
*/
function list_terms_custom_taxonomy( $atts ) {
	// Inside the function we extract custom taxonomy parameter of our shortcode
	extract( shortcode_atts( array(
	    'custom_taxonomy' => '',
	), $atts ) );
	$terms = get_terms([
	    'taxonomy' => $custom_taxonomy,
	    'hide_empty' => false,
	]);
	$output = '';
	foreach ($terms as $term){
		$output .= '<li><a href=' . get_term_link($term) . '>' . $term->name . '</a></li>';
	}
	return '<ul>' . $output . '</ul>';
}
add_shortcode( 'ct_terms', 'list_terms_custom_taxonomy' );


function todos_archive_list ( $atts ) {
	$output = testing;
	return $output;
}
add_shortcode( 'todos_archive_list', 'todos_archive_list' );



//Allow Text widgets to execute shortcodes
add_filter('widget_text', 'do_shortcode');