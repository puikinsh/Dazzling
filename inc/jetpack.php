<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package dazzling
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function dazzling_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'type' 		=> 'click',
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'dazzling_jetpack_setup' );
