<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
	<article>
		<h2><?php the_title(); ?></h2>
		<p><?php the_excerpt(); ?></p>
	</article>
<?php endwhile; endif; ?>