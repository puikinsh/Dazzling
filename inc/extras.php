<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package dazzling
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function dazzling_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'dazzling_page_menu_args' );


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function dazzling_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'dazzling_body_classes' );


/**
 * Mark Posts/Pages as Untiled when no title is used
 */
add_filter( 'the_title', 'dazzling_title' );

function dazzling_title( $title ) {
  if ( $title == '' ) {
    return 'Untitled';
  } else {
    return $title;
  }
}


/**
 * Add Filters
 */
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar


/**
 * Password protected post form
 */
add_filter( 'the_password_form', 'custom_password_form' );

function custom_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$o = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
  <div class="row">
    <div class="col-lg-10">
        <p>' . __( "This post is password protected. To view it please enter your password below:" ,'dazzling') . '</p>
        <label for="' . $label . '">' . __( "Password:" ,'dazzling') . ' </label>
      <div class="input-group">
        <input class="form-control" value="' . get_search_query() . '" name="post_password" id="' . $label . '" type="password">
        <span class="input-group-btn"><button type="submit" class="btn btn-default" name="submit" id="searchsubmit" vvalue="' . esc_attr__( "Submit",'dazzling' ) . '">' . __( "Submit" ,'dazzling') . '</button>
        </span>
      </div>
    </div>
  </div>
</form>';
	return $o;
}


/**
 * Add Bootstrap classes for table
 */
add_filter( 'the_content', 'dazzling_add_custom_table_class' );
function dazzling_add_custom_table_class( $content ) {
  return str_replace( '<table>', '<table class="table table-hover">', $content );
}

if ( ! function_exists( 'dazzling_social_icons' ) ) :
/**
 * Display social links in footer and widgets
 */
function dazzling_social_icons(){
  if ( has_nav_menu( 'social-menu' ) ) {
  	wp_nav_menu(
      array(
        'theme_location'  => 'social-menu',
        'container'       => 'nav',
        'container_id'    => 'social',
        'container_class' => 'social-icon',
        'menu_id'         => 'menu-social-items',
        'menu_class'      => 'social-menu',
        'depth'           => 1,
        'fallback_cb'     => '',
        'link_before'     => '<i class="social_icon fa"><span>',
        'link_after'      => '</span></i>'
      )
    );
  }
}
endif;


if( !function_exists( 'dazzling_social' ) ) :
	/**
	 * Fallback function for the deprecated function dazzling_social
	*/
function dazzling_social(){
  if( of_get_option('footer_social') ) {
    dazzling_social_icons();
  }
}
endif;

/**
 * header menu (should you choose to use one)
 */
function dazzling_header_menu() {
  // display the WordPress Custom Menu if available
  wp_nav_menu(array(
    'menu'              => 'primary',
    'theme_location'    => 'primary',
    'depth'             => 2,
    'container'         => 'div',
    'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
    'menu_class'        => 'nav navbar-nav',
    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
    'walker'            => new wp_bootstrap_navwalker()
  ));
} /* end header menu */


/**
 * footer menu (should you choose to use one)
 */
function dazzling_footer_links() {
  // display the WordPress Custom Menu if available
  wp_nav_menu(array(
    'container'       => '',                              // remove nav container
    'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
    'menu'            => __( 'Footer Links', 'dazzling' ),   // nav name
    'menu_class'      => 'nav footer-nav clearfix',      // adding custom nav class
    'theme_location'  => 'footer-links',             // where it's located in the theme
    'before'          => '',                                 // before the menu
    'after'           => '',                                  // after the menu
    'link_before'     => '',                            // before each link
    'link_after'      => '',                             // after each link
    'depth'           => 0,                                   // limit the depth of the nav
    'fallback_cb'     => 'dazzling_footer_links_fallback'  // fallback function
  ));
} /* end dazzling footer link */


/**
 * Get Post Views - for Popular Posts widget
 */
function dazzling_getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function dazzling_setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = (int)get_post_meta($postID, $count_key, true);
    if($count == 0){
        $count = 1;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, $count);
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


if ( ! function_exists( 'dazzling_call_for_action' ) ) :
/**
 * Call for action button & text area
 */
function dazzling_call_for_action() {
  if ( is_front_page() && of_get_option('w2f_cfa_text')!=''){
    echo '<div class="cfa">';
      echo '<div class="container">';
        echo '<div class="col-md-8">';
          echo '<span class="cfa-text">'. of_get_option('w2f_cfa_text').'</span>';
          echo '</div>';
          echo '<div class="col-md-4">';
          echo '<a class="btn btn-lg cfa-button" href="'. of_get_option('w2f_cfa_link'). '">'. of_get_option('w2f_cfa_button'). '</a>';
          echo '</div>';
      echo '</div>';
    echo '</div>';
  } else; {
  //Do nothing
  }
}
endif;


if ( ! function_exists( 'dazzling_featured_slider' ) ) :
/**
 * Featured image slider
 */
function dazzling_featured_slider() {
    if ( is_front_page() && of_get_option('dazzling_slider_checkbox') == 1 ) {
      echo '<div class="flexslider">';
        echo '<ul class="slides">';

          $count = of_get_option('dazzling_slide_number');
          $slidecat = of_get_option('dazzling_slide_categories');

            if ( $count && $slidecat ) {
            $query = new WP_Query( array( 'cat' => $slidecat, 'posts_per_page' => $count ) );
//            print_r($query);
            if ($query->have_posts()) :
              while ($query->have_posts()) : $query->the_post();

              echo '<li>';
                if ( has_post_thumbnail() ) { // Check if the post has a featured image assigned to it.
                  the_post_thumbnail();
                }

                echo '<div class="flex-caption">';
                  echo '<a href="'. get_permalink() .'">';
                    if ( get_the_title() != '' ) echo '<h2 class="entry-title">'. get_the_title().'</h2>';
                    if ( get_the_excerpt() != '' ) echo '<div class="excerpt">' . get_the_excerpt() .'</div>';
                  echo '</a>';
                echo '</div>';

                endwhile;
              endif;

            } else {
                echo "Slider is not properly configured";
            }

            echo '</li>';
        echo '</ul>';
      echo ' </div>';
    }
}
endif;


if ( ! function_exists( 'dazzling_footer_info' ) ) :
/**
 * function to show the footer info, copyright information
 */
function dazzling_footer_info() {
  global $dazzling_footer_info;
  printf( __( 'Theme by %1$s Powered by %2$s', 'dazzling' ) , '<a href="http://colorlib.com/wp/" target="_blank">Colorlib</a>', '<a href="http://wordpress.org/" target="_blank">WordPress</a>');
}
endif;

/**
 * Get custom CSS from Theme Options panel and output in header
 */
if (!function_exists('get_dazzling_theme_options'))  {
  function get_dazzling_theme_options(){

    echo '<style type="text/css">';

    if ( of_get_option('link_color')) {
      echo 'a, #infinite-handle span {color:' . of_get_option('link_color') . '}';
    }
    if ( of_get_option('link_hover_color')) {
      echo 'a:hover {color: '.of_get_option('link_hover_color', '#000').';}';
    }
    if ( of_get_option('link_active_color')) {
      echo 'a:active {color: '.of_get_option('link_active_color', '#000').';}';
    }
    if ( of_get_option('element_color')) {
      echo '.btn-default, .label-default, .flex-caption h2, .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus, .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a {background-color: '.of_get_option('element_color', '#000').'; border-color: '.of_get_option('element_color', '#000').';} .btn.btn-default.read-more, .entry-meta .fa, .site-main [class*="navigation"] a, .more-link { color: '.of_get_option('element_color', '#000').'}';
    }
    if ( of_get_option('element_color_hover')) {
      echo '.btn-default:hover, .label-default[href]:hover, .label-default[href]:focus, #infinite-handle span:hover, .btn.btn-default.read-more:hover, .btn-default:hover, .scroll-to-top:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .site-main [class*="navigation"] a:hover, .more-link:hover, #image-navigation .nav-previous a:hover, #image-navigation .nav-next a:hover  { background-color: '.of_get_option('element_color_hover', '#000').'; border-color: '.of_get_option('element_color_hover', '#000').'; }';
    }
    if ( of_get_option('cfa_bg_color')) {
      echo '.cfa { background-color: '.of_get_option('cfa_bg_color', '#000').'; } .cfa-button:hover {color: '.of_get_option('cfa_bg_color', '#000').';}';
    }
    if ( of_get_option('cfa_color')) {
      echo '.cfa-text { color: '.of_get_option('cfa_color', '#000').';}';
    }
    if ( of_get_option('cfa_btn_color')) {
      echo '.cfa-button {border-color: '.of_get_option('cfa_btn_color', '#000').';}';
    }
    if ( of_get_option('cfa_btn_txt_color')) {
      echo '.cfa-button {color: '.of_get_option('cfa_btn_txt_color', '#000').';}';
    }
    if ( of_get_option('heading_color')) {
      echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .entry-title {color: '.of_get_option('heading_color', '#000').';}';
    }
    if ( of_get_option('top_nav_bg_color')) {
      echo '.navbar.navbar-default {background-color: '.of_get_option('top_nav_bg_color', '#000').';}';
    }
    if ( of_get_option('top_nav_link_color')) {
      echo '.navbar-default .navbar-nav > li > a { color: '.of_get_option('top_nav_link_color', '#000').';}';
    }
    if ( of_get_option('top_nav_dropdown_bg')) {
      echo '.dropdown-menu, .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus {background-color: '.of_get_option('top_nav_dropdown_bg', '#000').';}';
    }
    if ( of_get_option('top_nav_dropdown_item')) {
      echo '.navbar-default .navbar-nav .open .dropdown-menu > li > a { color: '.of_get_option('top_nav_dropdown_item', '#000').';}';
    }
    if ( of_get_option('footer_bg_color')) {
      echo '#colophon {background-color: '.of_get_option('footer_bg_color', '#000').';}';
    }
    if ( of_get_option('footer_text_color')) {
      echo '#footer-area, .site-info {color: '.of_get_option('footer_text_color', '#000').';}';
    }
    if ( of_get_option('footer_widget_bg_color')) {
      echo '#footer-area {background-color: '.of_get_option('footer_widget_bg_color', '#000').';}';
    }
    if ( of_get_option('footer_link_color')) {
      echo '.site-info a, #footer-area a {color: '.of_get_option('footer_link_color', '#000').';}';
    }
    if ( of_get_option('social_color')) {
      echo '#social a {color: '.of_get_option('social_color', '#000').' !important ;}';
    }
    if ( of_get_option('social_hover_color')) {
      echo '#social a:hover {color: '.of_get_option('social_hover_color', '#000').'!important ;}';
    }
    global $typography_options, $typography_defaults;

    $typography = of_get_option('main_body_typography', $typography_defaults);

    if ( $typography ) {
      $font_family = isset( $typography_options['faces'][$typography['face']] ) ? $typography_options['faces'][$typography['face']] : $typography_options['faces'][$typography_defaults['face']];
      $font_size = isset( $typography['size'] ) ? $typography['size'] : $typography_defaults['size'];
      $font_style = isset( $typography['style'] ) ? $typography['style'] : $typography_defaults['style'];
      $font_color = isset( $typography['color'] ) ? $typography['color'] : $typography_defaults['color'];
      echo '.entry-content {font-family: ' . $font_family . '; font-size:' . $font_size . '; font-weight: ' . $font_style . '; color:'.$font_color . ';}';
    }
    if ( of_get_option('custom_css')) {
      echo html_entity_decode( of_get_option( 'custom_css', 'no entry' ) );
    }
      echo '</style>';
  }
}
add_action('wp_head','get_dazzling_theme_options',10);

?>
