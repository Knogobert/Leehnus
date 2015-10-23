<!-- single.php -->
<?php get_header() ?>
<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
	<article>
		<h1><?php the_title(); ?></h1>
		<p><?php the_content(); ?></p>
		<center><?php the_post_thumbnail(); ?></center>
	</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>