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
		          <h5 class="contactTitle">
			          <?php the_title() ?>
			      </h5>
		          <center><a href="<?php the_permalink() ?>" class="contactThumb">
			        <?php the_post_thumbnail () ?>
		          </a></center>
		        <?php
		      }
		    }
		    else {
		      echo 'There are no contact(s) to display. Create a "Leehnus Contact" in the wordpress admin side-menu';
		    }
		  ?>
	</main><!-- #main -->
<?php get_footer() ?> 