<?php
/**
 *  Jigoshop Functions for Dazzling theme
 */

function dazzling_open_jigoshop_content_wrappers() {
	echo '<div id="content" class="site-content container"><div id="primary" class="content-area col-sm-12 col-md-8"><main id="main" class="site-main" role="main">';
}

function dazzling_close_jigoshop_content_wrappers() {
	echo '</main></div>';
}

function dazzling_close_jigoshop_sidebar() {
	echo '</div>';
}

function dazzling_prepare_jigoshop_wrappers() {
  remove_action( 'jigoshop_before_main_content', 'jigoshop_output_content_wrapper', 10 );
  remove_action( 'jigoshop_after_main_content', 'jigoshop_output_content_wrapper_end', 10);

  add_action( 'jigoshop_before_main_content', 'dazzling_open_jigoshop_content_wrappers', 10 );
  add_action( 'jigoshop_after_main_content', 'dazzling_close_jigoshop_content_wrappers', 10 );

  remove_action('jigoshop_after_sidebar', 'jigoshop_get_sidebar_end', 10);
  add_action( 'jigoshop_after_sidebar', 'dazzling_close_jigoshop_sidebar', 10 );
}

add_action( 'wp_head', 'dazzling_prepare_jigoshop_wrappers' );

?>