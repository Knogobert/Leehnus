<?php if( have_posts() ): while( have_posts() ): the_post(); ?>
	<figure>
		<?php if ( function_exists( 'masterslider' ) ) : ?>
			<?php masterslider(1); ?>
		<?php else : ?>
			<img src="<?php echo get_template_directory_uri(); ?>img/nomasterslider.jpg"/><!-- Put in a standard 960x360 picture here -->
		<?php endif; ?>
	</figure>
	<article>
		<h2><?php the_title(); ?></h2><!-- <?php the_permalink(); ?> -->
		<?php get_the_post_thumbnail ( 'infoPhoto', 'thumbnail' ) ?>
		<p><?php the_content(); ?></p>
	</article>
<?php endwhile; endif; ?>