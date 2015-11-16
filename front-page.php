<!-- front-page.php -->
<?php get_header() ?>
	<main id="main" class="site-main" role="main">		
		<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
			<article>
				<div class="frontTitle">
					<h1><?php the_title(); ?></h1><!-- <?php the_permalink(); ?> -->
				</div>
				<div id="slides">
				<?php
				$pageID = get_the_ID(); // This is must be replaced with your page ID
				$args = array(
				    'post_type' => 'attachment',
				    'numberposts' => null,
				    'post_status' => null,
				    'post_parent' => $pageID
				);
				$attachments = get_posts($args);
				if ($attachments) {
				    foreach ($attachments as $attachment) {
				        $imageAlt = $attachment->post_title;
		                $attachment_id = $attachment->ID; // attachment ID
		                $image_attributes = wp_get_attachment_image_src( $attachment_id , 'full' ); // returns an array
		                echo '<img src="'.$image_attributes[0].'" alt="'.$imageAlt.'"/>';
					}
				}
				?>
				</div>
				<div class="frontContent">
					<?php the_content(); ?>
				</div>
				
				<div class="frontThumb">
			    	<?php the_post_thumbnail () ?>
		        </div>
			</article>
		<?php endwhile; endif; ?>
		<script type="text/javascript">
			$(function(){
		      $("#slides").slidesjs({
		        width: 960,
		        height: 320,
		        pagination: false
		      });
		    });
		</script>
	</main><!-- #main -->
<?php get_footer() ?>