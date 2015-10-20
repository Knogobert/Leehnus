<?php 
/* Template name: Gallery */
get_header() ?>
    <main id="main" class="site-main" role="main">
        <h2>Welcome to my gallery</h2>
        <div id="galleryWrapper">
            <?php while(have_posts()): the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        </div>
    </main><!-- #main -->
    <script src="isotope.js"/>
    <script>
        $(function(){
            $('#galleryWrapper').isotope({
                itemSelector: '.gallery-item'
            })
        });
    </script>
    <!-- ../wp-content/themes/Leehnus/img/5.jpg -->
<?php get_footer() ?>