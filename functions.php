<?php
/**
 * Dazzling functions and definitions
 *
 * @package dazzling
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 730; /* pixels */
}

/**
 * Set the content width for full width pages with no sidebar.
 */
function dazzling_content_width() {
  if ( is_page_template( 'page-fullwidth.php' ) || is_page_template( 'front-page.php' ) ) {
    global $content_width;
    $content_width = 1110; /* pixels */
  }
}
add_action( 'template_redirect', 'dazzling_content_width' );

if ( ! function_exists( 'dazzling_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dazzling_setup() {

  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   * If you're building a theme based on Dazzling, use a find and replace
   * to change 'dazzling' to the name of your theme in all the template files
   */
  load_theme_textdomain( 'dazzling', get_template_directory() . '/languages' );

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  add_theme_support( 'post-thumbnails' );

  add_image_size( 'dazzling-featured', 730, 410, true );
  add_image_size( 'tab-small', 60, 60 , true); // Small Thumbnail

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'primary'      => __( 'Primary Menu', 'dazzling' ),
    'footer-links' => __( 'Footer Links', 'dazzling' ) // secondary menu in footer
  ) );

  // Enable support for Post Formats.
  add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

  // Setup the WordPress core custom background feature.
  add_theme_support( 'custom-background', apply_filters( 'dazzling_custom_background_args', array(
  	'default-color' => 'ffffff',
  	'default-image' => '',
  ) ) );

  /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
  add_theme_support( 'title-tag' );
}
endif; // dazzling_setup
add_action( 'after_setup_theme', 'dazzling_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function dazzling_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Sidebar', 'dazzling' ),
    'id'            => 'sidebar-1',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );
  register_sidebar(array(
    'id'            => 'home-widget-1',
    'name'          => __( 'Homepage Widget 1', 'dazzling' ),
    'description'   => __( 'Displays on the Home Page', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'id'            => 'home-widget-2',
    'name'          =>  __( 'Homepage Widget 2', 'dazzling' ),
    'description'   => __( 'Displays on the Home Page', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'id'            => 'home-widget-3',
    'name'          =>  __( 'Homepage Widget 3', 'dazzling' ),
    'description'   =>  __( 'Displays on the Home Page', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'id'            => 'footer-widget-1',
    'name'          =>  __( 'Footer Widget 1', 'dazzling' ),
    'description'   =>  __( 'Used for footer widget area', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'id'            => 'footer-widget-2',
    'name'          =>  __( 'Footer Widget 2', 'dazzling' ),
    'description'   =>  __( 'Used for footer widget area', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));

  register_sidebar(array(
    'id'            => 'footer-widget-3',
    'name'          =>  __( 'Footer Widget 3', 'dazzling' ),
    'description'   =>  __( 'Used for footer widget area', 'dazzling' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widgettitle">',
    'after_title'   => '</h3>',
  ));


  register_widget( 'dazzling_popular_posts_widget' );
}
add_action( 'widgets_init', 'dazzling_widgets_init' );

include(get_template_directory() . "/inc/popular-posts-widget.php");


/**
 * Enqueue scripts and styles.
 */
function dazzling_scripts() {

  wp_enqueue_style( 'dazzling-bootstrap', get_template_directory_uri() . '/inc/css/bootstrap.min.css' );

  wp_enqueue_style( 'dazzling-icons', get_template_directory_uri().'/inc/css/font-awesome.min.css' );

  if( ( is_home() || is_front_page() ) && of_get_option('dazzling_slider_checkbox') == 1 ) {
  	wp_enqueue_style( 'flexslider-css', get_template_directory_uri().'/inc/css/flexslider.css' );
  }

  if ( class_exists( 'jigoshop' ) ) { // Jigoshop specific styles loaded only when plugin is installed
    wp_enqueue_style( 'jigoshop-css', get_template_directory_uri().'/inc/css/jigoshop.css' );
  }

  wp_enqueue_style( 'dazzling-style', get_stylesheet_uri() );

  wp_enqueue_script('dazzling-bootstrapjs', get_template_directory_uri().'/inc/js/bootstrap.min.js', array('jquery') );

  if( ( is_home() || is_front_page() ) && of_get_option('dazzling_slider_checkbox') == 1 ) {
  	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/inc/js/flexslider.min.js', array('jquery'), '2.2.2', true );
  }

  wp_enqueue_script( 'dazzling-main', get_template_directory_uri() . '/inc/js/main.js', array('jquery') );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
  	wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'dazzling_scripts' );

/**
 * Add HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries
 */
function dazzling_ie_support_header() {
  echo '<!--[if lt IE 9]>'. "\n";
  echo '<script src="' . esc_url( get_template_directory_uri() . '/inc/js/html5shiv.min.js' ) . '"></script>'. "\n";
  echo '<script src="' . esc_url( get_template_directory_uri() . '/inc/js/respond.min.js' ) . '"></script>'. "\n";
  echo '<![endif]-->'. "\n";
}
add_action( 'wp_head', 'dazzling_ie_support_header', 11 );

/*
 * Loads the Options Panel
 *
 * If you're loading from a child theme use stylesheet_directory
 * instead of template_directory
 */
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/admin/' );
require_once dirname( __FILE__ ) . '/inc/admin/options-framework.php';
// Loads options.php from child or parent theme
$optionsfile = locate_template( 'options.php' );
load_template( $optionsfile );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom nav walker
 */
require get_template_directory() . '/inc/navwalker.php';

if ( class_exists( 'woocommerce' ) ) {
/**
 * WooCommerce related functions
 */
require get_template_directory() . '/inc/woo-setup.php';
}

if ( class_exists( 'jigoshop' ) ) {
/**
 * Jigoshop related functions
 */
require get_template_directory() . '/inc/jigoshop-setup.php';
}