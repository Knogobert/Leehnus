<?php 
/* Template name: Contacts */
	get_header() ?>
	<main id="main" class="site-main" role="main">
		<div class="contactsContainer">
		<?php
			// Checks how many posts there are and styles the contactsContainer to it.
			$count_posts = wp_count_posts('contact')->publish; 
				if ( $count_posts % 3 == 0 ) { 
		        echo "<style>.contactsContainer {width:630px;} @media (max-width: 640px){.contactsContainer{width:84vw;}</style>";}
		        elseif ( $count_posts % 2 == 0 ) { 
		        echo "<style>.contactsContainer {width:420px;} @media (max-width: 640px){.contactsContainer{width:56vw;}}</style>";}
		        elseif ( $count_posts == 1 ) { 
		        echo "<style>.contactsContainer {width:210px;} @media (max-width: 640px){.contactsContainer{width:28vw;}}</style>";}
		        else { 
		        echo "<style>.contactsContainer {width:420px;}</style>";}
			
		    $contacts = new WP_Query( array('post_type' => 'contact') );
		    if( $contacts->have_posts() ) {
		      while( $contacts->have_posts() ) {
		        $contacts->the_post();
		        
		        
		        ?>
			        <div class="contactCard">
			        	<h5 class="contactTitle">
				        	<?php the_title() ?>
				    	</h5>
				    	<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'small' ); ?>
						<a href="<?php the_permalink() ?>" class="contactThumbSmall" style="background: url(<?php echo $url; ?>) center center; background-size: cover; ">
				        	
			        	</a>
					</div>

		        <?php
		      }
		    }
		    else {
		      echo 'There are no contact(s) to display. Create a "Leehnus Contact" in the wordpress admin side-menu';
		    }
		  ?>
		</div>
	</main><!-- #main -->
<?php get_footer() ?> 