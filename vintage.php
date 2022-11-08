<?php
//BEGIN VINTAGE CODE THAT NEEDS TO BE REWRITTEN FOR THE TO-DO POST TYPE

/*
	TIME ENTRY CONTENT 
*/
// If post type is time_entry, then display the date worked	
add_filter( 'the_content', 'return_acf_time_entry_content' ); 
function return_acf_time_entry_content ( $content ) { 
    // if it's not a todo, then return the normal content.
    if ( !is_singular( 'time_entry' ) ) {
	    return $content;
	    
    } else {
    
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
	remove_meta_box( 'tagsdiv-todo_status', 'todo', 'side' );	
}
add_action( 'admin_menu', 'remove_custom_taxonomy_meta_boxes' );