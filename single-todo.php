<?php
// Add edit_post_link() to single posts in Beaver Builder
add_action( 'fl_after_header', 'bb_do_single_post_top_section' );
function bb_do_single_post_top_section() {
	// If the current page loading is a Single Post
	if(is_single() && get_post_type( $post ) == 'post'){
				
					<?php edit_post_link( _x( 'Edit', 'Edit post link text.', 'fl-automator' ) ); ?>
	}
}