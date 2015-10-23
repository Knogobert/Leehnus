<!-- front-page.php -->
<?php get_header() ?>
	<main id="main" class="site-main" role="main">		
		<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
			<article>
				<div class="frontTitle">
					<h1><?php the_title(); ?></h1><!-- <?php the_permalink(); ?> -->
				</div>
				<div class="frontContent">
					<?php the_content(); ?>
				</div>
				
				<div class="frontThumb">
			    	<?php the_post_thumbnail () ?>
		        </div>
			</article>
		<?php endwhile; endif; ?>
	</main><!-- #main -->
<?php get_footer() ?>