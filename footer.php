<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package dazzling
 */
?>
                </div><!-- close .row -->
            </div><!-- close .container -->
        </div><!-- close .site-content -->

	<div id="footer-area">
		<div class="container footer-inner">
			<?php get_sidebar( 'footer' ); ?>
		</div>

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info container">
				<?php if( of_get_option('footer_social') ) dazzling_social_icons(); ?>
				<nav role="navigation" class="col-md-6">
					<?php dazzling_footer_links(); ?>
				</nav>
				<div class="copyright col-md-6">
					<?php echo of_get_option( 'custom_footer_text', 'dazzling' ); ?>
					<?php dazzling_footer_info(); ?>
				</div>
			</div><!-- .site-info -->
			<button class="scroll-to-top"><i class="fa fa-angle-up"></i></button><!-- .scroll-to-top -->
		</footer><!-- #colophon -->
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>