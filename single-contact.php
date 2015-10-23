<!-- single-contact.php -->
<?php get_header() ?>
<!-- Store key value to print where you want it use $email. -->
<?php $email = get_post_meta( get_the_ID(), '_my_meta_value_key', true ); ?>

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
	      	<form class="contactForm" action="MAILTO:<?php echo $email;?>" method="post" enctype="text/plain">
            	<input name="name" type="text" class="contact-input" placeholder="Name" />   
            	<input name="email" type="text" class="contact-input" placeholder="Email" />
            	<textarea name="text" class="contact-input" placeholder="Comment"></textarea>
            <input type="submit" value="SUBMIT"/>
          	</form>
		<?php endwhile; endif; ?>
<!--
	
-->
	</main><!-- #main -->
<?php get_footer() ?> 