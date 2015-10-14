<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
	<article>
			<h2><?php the_title(); ?></h2><!-- <?php the_permalink(); ?> -->
			<?php get_the_post_thumbnail ( 'infoPhoto', 'thumbnail' ) ?>
			<p><?php the_content(); ?> THIS IS part-gallery.php</p>
	</article>
<?php endwhile; endif; ?>