<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 *
 * @package dazzling
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses dazzling_header_style()
 * @uses dazzling_admin_header_style()
 * @uses dazzling_admin_header_image()
 *
 * @package dazzling
 */
function dazzling_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'dazzling_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 300,
		'height'                 => 66,
		'flex-height'            => true,
		'wp-head-callback'       => 'dazzling_header_style',
		'admin-head-callback'    => 'dazzling_admin_header_style',
		'admin-preview-callback' => 'dazzling_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'dazzling_custom_header_setup' );

if ( ! function_exists( 'dazzling_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see dazzling_custom_header_setup().
 */
function dazzling_header_style() {
	$header_text_color = get_header_textcolor();

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.navbar > .container .navbar-brand {
			color: #<?php echo $header_text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // dazzling_header_style

if ( ! function_exists( 'dazzling_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see dazzling_custom_header_setup().
 */
function dazzling_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // dazzling_admin_header_style

if ( ! function_exists( 'dazzling_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see dazzling_custom_header_setup().
 */
function dazzling_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // dazzling_admin_header_image
