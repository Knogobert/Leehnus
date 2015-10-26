	</div><!-- /.page-wrapper -->

<footer>

	<?php if ( is_active_sidebar( 'footer_social' ) ) : ?>
		<div id="footerWidgetArea" class="footer widget-area" role="complementary">
			<?php dynamic_sidebar( 'footer_social' ); ?>
		</div><!-- #primary-sidebar -->
		<?php wp_nav_menu( array(
			'menu' => 'footer menu',
			'theme_location' => 'footer_menu',
			'container' => 'nav',
			'menu_class' => 'footer_menu'
			) ); ?>
	<?php endif; ?>

</footer>

<?php wp_footer(); ?>

</body>
</html>