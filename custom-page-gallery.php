<?php 
/* Template name: Gallery */
get_header() ?>
    <main id="main" class="site-main" role="main">
        <?php while(have_posts()): the_post(); ?>
<!-- 	        <h1><?php the_title(); ?></h1> -->
	        <div id="galleryWrapper">
                <?php the_content(); ?>
        	</div>
        <?php endwhile; ?>
    </main><!-- #main -->
    <!-- <script src="isotope.js"/>
    <script>
        $(function(){
            $('#galleryWrapper').isotope({
                itemSelector: '.gallery-item'
            })
        });
    </script>-->
<?php get_footer() ?>