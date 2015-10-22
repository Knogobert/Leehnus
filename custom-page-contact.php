<?php 
/* Template name: Contacts */
	get_header() ?>
	<main id="main" class="site-main" role="main">
		<?php
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
	</main><!-- #main -->
<?php get_footer() ?> 