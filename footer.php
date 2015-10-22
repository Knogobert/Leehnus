	</div><!-- /.page-wrapper -->

<footer>
	<p>© Linus Hjälmeby 2015</p>

<?php if ( is_active_sidebar( 'footer_social' ) ) : ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'footer_social' ); ?>
	</div><!-- #primary-sidebar -->
<?php endif; ?>

<?php dynamic_sidebar( 'footer_social' ); ?>
</footer>

<?php wp_footer(); ?>

</body>
</html>