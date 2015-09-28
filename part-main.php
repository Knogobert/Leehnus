<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
	<article>
		<h2><?php the_title(); ?></h2>
		<p><?php the_excerpt(); ?></p>
		<div><?php masterslider(1); ?></div>
		<span>Test</span>
	</article>
<?php endwhile; endif; ?>