<?php get_header() ?>
	<main id="main" class="site-main" role="main">
		<?php
		    $contacts = new WP_Query( array('post_type' => 'contact') );
		    if( $contacts->have_posts() ) {
		      while( $contacts->have_posts() ) {
		        $contacts->the_post();
		        ?>
		          <h1><?php the_title() ?></h1>
		          <div class="contactThumb">
			        <?php the_post_thumbnail () ?>
		          </div>
		          <center class='content'>
		            <?php the_content() ?>
		          </center>
		        <?php
		      }
		    }
		    else {
		      echo 'There are no contact(s) to display. Create a "Leehnus Contact" in the wordpress admin side-menu';
		    }
		  ?>
		  
<!--
		  <form class="contactForm" action="MAILTO:someone@example.com" method="post" enctype="text/plain">
            <input name="name" type="text" class="contact-input" placeholder="Name" />   
            <input name="email" type="text" class="contact-input" placeholder="Email" />
            <textarea name="text" class="contact-input" placeholder="Comment"></textarea>
            <input type="submit" value="SUBMIT"/>
          </form>
-->
	</main><!-- #main -->
<?php get_footer() ?>