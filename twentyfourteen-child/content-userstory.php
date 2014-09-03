<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php twentyfourteen_post_thumbnail(); ?>

	<header class="entry-header" <?php if(function_exists('live_edit')) { live_edit('post_title, post_content, user_story_done_or_not, how_many_hours_will_this_to-do_require, assigned_to'); }?>>
		<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && twentyfourteen_categorized_blog() ) : ?>
		<div class="entry-meta">
			<span class="cat-links"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfourteen' ) ); ?></span>
		</div>
		<?php
			endif;

			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
			endif;
		?>
		
		<div class="hours-estimate" style="clear:both;margin-bottom:1em;">We estimate that this to-do will require <strong><?php the_field('how_many_hours_will_this_to-do_require'); ?> <?php if (get_field('how_many_hours_will_this_to-do_require') == 1) { echo 'hour'; } else { echo 'hours'; } ?></strong>.</div>

		<div class="entry-meta">
			<?php
				if ( 'post' == get_post_type() )
					twentyfourteen_posted_on();

				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'twentyfourteen' ), __( '1 Comment', 'twentyfourteen' ), __( '% Comments', 'twentyfourteen' ) ); ?></span>
			<?php
				endif;

				edit_post_link( __( 'Edit', 'twentyfourteen' ), '<span class="edit-link">', '</span>' );
			?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
	
		<!--get_status-->
		<?php
		//onactive=6 done=4
		$arr_user_story_done_or_not=get_field('user_story_done_or_not');
		//fix on the story not saved properly
		if($arr_user_story_done_or_not[0]==false){ //set to active
			//update_field('user_story_done_or_not', 'active', get_the_ID());
			echo 'Please save this ToDo again. This ToDo is not saved properly. Thanks.';
		}
		$doneornot=get_term($arr_user_story_done_or_not[0],'user_story_done_or_not');
		if($doneornot->slug=='done'){ //if done
		   $radiobuttons='<tr><td><h5>Status:</h5></td><td><input id="tactive"  name="tstatus_story" class="active user_story_status" type="radio"  value="activexxx'.get_the_ID().'"> Active</td><td><input id="tdone"   name="tstatus_story" class="done user_story_status"  type="radio"  value="donexxx'.get_the_ID().'" checked> Done</td><td><input id="ton-hold" name="tstatus_story" class="on-hold user_story_status"  type="radio"  value="on-holdxxx'.get_the_ID().'">On Hold</td><td><input id="tready-for-client-review" name="tstatus_story" class="ready-for-client-review user_story_status"  type="radio"  value="ready-for-client-reviewxxx'.get_the_ID().'" >Ready For Client Review</td></tr>';		
		}elseif($doneornot->slug=='active'){ //if active
			$radiobuttons='<tr><td><h5>Status:</h5></td><td><input id="tactive"  name="tstatus_story" class="active user_story_status" type="radio"  value="activexxx'.get_the_ID().'"  checked> Active</td><td><input id="tdone" name="tstatus_story" class="done user_story_status"  type="radio"  value="donexxx'.get_the_ID().'"> Done</td><td><input id="ton-hold" name="tstatus_story" class="on-hold user_story_status"  type="radio"  value="on-holdxxx'.get_the_ID().'">On Hold</td><td><input id="tready-for-client-review" name="tstatus_story" class="ready-for-client-review user_story_status"  type="radio"  value="ready-for-client-reviewxxx'.get_the_ID().'" >Ready For Client Review</td></tr>'; 
		}elseif($doneornot->slug=='on-hold'){ //if onhold
			$radiobuttons='<tr><td><h5>Status:</h5></td><td><input id="tactive"  name="tstatus_story" class="active user_story_status" type="radio"  value="activexxx'.get_the_ID().'"> Active</td><td><input id="tdone" name="tstatus_story" class="done user_story_status"  type="radio"  value="donexxx'.get_the_ID().'"> Done</td><td><input id="ton-hold" name="tstatus_story" class="on-hold user_story_status"  type="radio"  value="on-holdxxx'.get_the_ID().'" checked>On Hold</td><td><input id="tready-for-client-review" name="tstatus_story" class="ready-for-client-review user_story_status"  type="radio"  value="ready-for-client-reviewxxx'.get_the_ID().'" >Ready For Client Review</td></tr>'; 
		}else{ //if onhold
			$radiobuttons='<tr><td><h5>Status:</h5></td><td><input id="tactive"  name="tstatus_story" class="active user_story_status" type="radio"  value="activexxx'.get_the_ID().'"> Active</td><td><input id="tdone" name="tstatus_story" class="done user_story_status"  type="radio"  value="donexxx'.get_the_ID().'"> Done</td><td><input id="ton-hold" name="tstatus_story" class="on-hold user_story_status"  type="radio"  value="on-holdxxx'.get_the_ID().'">On Hold</td><td><input id="tready-for-client-review" name="tstatus_story" class="ready-for-client-review user_story_status"  type="radio"  value="ready-for-client-reviewxxx'.get_the_ID().'" checked>Ready For Client Review</td></tr>'; 
		}
		?>
		<div id="t_story_status"><table><?php echo $radiobuttons;?></table><div class="ajax_status"></div></div>
		<p>This to-do was requested by <span style="font-weight:bold"><?php echo ucwords(get_the_author()); ?> on <?php the_date();?></span> and is assigned to <span style="font-weight:bold"><?php $assigned_to = get_field('assigned_to'); echo $assigned_to['display_name']; ?></span>.</p>
		
		<?php
		
		the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyfourteen' ) );
		?>
		
		<?php
		$current_user;
		if ( current_user_can('publish_posts') ) {
			echo make_clickable(get_field('lowrize_url'));
		}?>	
		
		<?php 
		
		if (get_field('date_worked')) {
			$date1 = DateTime::createFromFormat('Ymd', get_field('date_worked'));
			echo 'Date Worked: ' . $date1->format('d M, Y') .' -by:'.get_the_author(); 			
		}
		

		
		
		
		
		
		$posts = get_field('related_user_stories');
		if( $posts ): ?>
			<h2>Related User Stories:</h2>
		    <ul>
		    <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
		        <?php setup_postdata($post); ?>
		        <li>
		            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		        </li>
		    <?php endforeach; ?>
		    </ul>
		    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php 
		endif; ?>
		
		
	</div><!-- .entry-content -->
	<?php endif; ?>

	<?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); ?>
</article><!-- #post-## -->
