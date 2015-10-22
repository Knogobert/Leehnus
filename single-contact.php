<?php get_header() ?>
	<main id="main" class="site-main" role="main">
		<?php if(have_posts()): while(have_posts()): the_post(); ?>
	        <h1 class="contactTitle">
		        <?php the_title() ?>
		    </h1>
	        <center class="contactThumb">
		    	<?php the_post_thumbnail () ?>
			</center>
	        <center class='content'>
	        	<?php the_content() ?>
	        </center>
	        <center>
	        	<?php echo get_post_meta( get_the_ID(), 'my-info', true ); ?>
	        </center>
		<?php endwhile; endif; ?>
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