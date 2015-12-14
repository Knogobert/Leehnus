<?php 
/* Template name: Gallery */
get_header() ?>
    <main id="main" class="site-main" role="main">
        <?php while(have_posts()): the_post(); ?>
	        <div id="galleryWrapper">
                <?php the_content(); ?>
        	</div>
        <?php endwhile; ?>
    </main><!-- /#main -->
<?php get_footer() ?>