<!-- index.php -->
<?php get_header() ?>
	<main id="main" class="site-main" role="main">		
		<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
			<article>
				<h2><?php the_title(); ?></h2><!-- <?php the_permalink(); ?> -->
				<?php get_the_post_thumbnail ( 'infoPhoto', 'thumbnail' ) ?>
				<p><?php the_content(); ?></p>
			</article>
		<?php endwhile; endif; ?>
	</main><!-- #main -->
<?php get_footer() ?>
