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

if( !function_exists( 'dazzling_header_menu' ) ) :
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
    'container_id'	=> 'navbar',
    'menu_class'        => 'nav navbar-nav',
    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
    'walker'            => new wp_bootstrap_navwalker()
  ));
} /* end header menu */
endif;

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
          echo '<span class="cfa-text">'. esc_html( of_get_option('w2f_cfa_text') ).'</span>';
          echo '</div>';
          echo '<div class="col-md-4">';
          echo '<a class="btn btn-lg cfa-button" href="'. esc_url( of_get_option('w2f_cfa_link') ). '">'. esc_html( of_get_option('w2f_cfa_button') ). '</a>';
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
    if ( ! is_front_page() || 1 != of_get_option( 'dazzling_slider_checkbox' ) ) {
        return;
    }

    $count = absint( of_get_option( 'dazzling_slide_number', 3 ) );
    if ( ! $count ) {
        $count = 3;
    }

    $args = array(
        'posts_per_page'      => $count,
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
        /*
         * Only posts that can actually fill a slide. Without this a post with no
         * featured image produced a slide with no image, and the slider cycled
         * through a blank pane.
         */
        'meta_query'          => array(
            array(
                'key'     => '_thumbnail_id',
                'compare' => 'EXISTS',
            ),
        ),
    );

    /*
     * The category is optional. It used to be required -- the slider rendered only
     * when a category AND a count were both set -- so ticking "enable slider"
     * without choosing one printed "Slider is not properly configured" to visitors
     * rather than showing anything. With no category chosen, show latest posts.
     */
    $slidecat = of_get_option( 'dazzling_slide_categories' );
    if ( $slidecat ) {
        $args['cat'] = $slidecat;
    }

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        wp_reset_postdata();
        return;
    }

    echo '<div class="flexslider">';
    echo '<ul class="slides">';

    while ( $query->have_posts() ) :
        $query->the_post();

        echo '<li>';
        /*
         * An explicit size. the_post_thumbnail() with no argument serves the
         * default thumbnail, which the slider then stretched to full width --
         * the cause of the blurry slides.
         */
        the_post_thumbnail( 'full' );

        echo '<div class="flex-caption">';
        echo '<a href="' . esc_url( get_permalink() ) . '">';
        if ( '' !== get_the_title() ) {
            echo '<h2 class="entry-title">' . esc_html( get_the_title() ) . '</h2>';
        }
        if ( '' !== get_the_excerpt() ) {
            echo '<div class="excerpt">' . esc_html( get_the_excerpt() ) . '</div>';
        }
        echo '</a>';
        echo '</div>';
        echo '</li>';

    endwhile;

    echo '</ul>';
    echo '</div>';

    wp_reset_postdata();
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
  
if ( ! function_exists( 'dazzling_sanitize_css_color' ) ) {
	/**
	 * Return a value that is safe to print as a CSS colour, or ''.
	 *
	 * @param mixed $value Raw stored value.
	 * @return string Validated colour, or '' when the value is not one.
	 */
	function dazzling_sanitize_css_color( $value ) {
		if ( ! is_string( $value ) ) {
			return '';
		}

		$value = trim( $value );

		if ( '' === $value ) {
			return '';
		}

		// #rgb / #rrggbb
		if ( preg_match( '/^#(?:[0-9a-f]{3}|[0-9a-f]{6})$/i', $value ) ) {
			return $value;
		}

		// rgb() / rgba()
		if ( preg_match( '/^rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}\s*(?:,\s*(?:0|1|0?\.\d+)\s*)?\)$/', $value ) ) {
			return $value;
		}

		// Bare CSS colour keyword, e.g. "transparent" or "red".
		if ( preg_match( '/^[a-z]{3,20}$/i', $value ) ) {
			return $value;
		}

		return '';
	}
}

if ( ! function_exists( 'dazzling_css_color' ) ) {
	/**
	 * Return a theme option as a CSS colour that is safe to print, or ''.
	 *
	 * Every colour printed into the inline <style> block goes through this. Options
	 * saved before the Customizer sanitiser was tightened may still hold arbitrary
	 * text, so the value is re-validated at output time rather than trusted from
	 * storage.
	 *
	 * @param string $name Option name.
	 * @return string Validated colour, or '' when the stored value is not one.
	 */
	function dazzling_css_color( $name ) {
		return dazzling_sanitize_css_color( of_get_option( $name ) );
	}
}

function get_dazzling_theme_options(){

    echo '<style type="text/css">';

    if ( dazzling_css_color( 'link_color' )) {
      echo 'a, #infinite-handle span {color:' . dazzling_css_color( 'link_color' ) . '}';
    }
    if ( dazzling_css_color( 'link_hover_color' )) {
      echo 'a:hover, a:focus {color: '.dazzling_css_color( 'link_hover_color' ).';}';
    }
    if ( dazzling_css_color( 'link_active_color' )) {
      echo 'a:active {color: '.dazzling_css_color( 'link_active_color' ).';}';
    }
    if ( dazzling_css_color( 'element_color' )) {
      echo '.btn-default, .label-default, .flex-caption h2, .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus, .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus, .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a {background-color: '.dazzling_css_color( 'element_color' ).'; border-color: '.dazzling_css_color( 'element_color' ).';} .btn.btn-default.read-more, .entry-meta .fa, .site-main [class*="navigation"] a, .more-link { color: '.dazzling_css_color( 'element_color' ).'}';
    }
    if ( dazzling_css_color( 'element_color_hover' )) {
	  echo '.btn-default:hover, .btn-default:focus, .label-default[href]:hover, .label-default[href]:focus, #infinite-handle span:hover, #infinite-handle span:focus-within, .btn.btn-default.read-more:hover, .btn.btn-default.read-more:focus, .btn-default:hover, .btn-default:focus, .scroll-to-top:hover, .scroll-to-top:focus, .btn-default:focus, .btn-default:active, .btn-default.active, .site-main [class*="navigation"] a:hover, .site-main [class*="navigation"] a:focus, .more-link:hover, .more-link:focus, #image-navigation .nav-previous a:hover, #image-navigation .nav-previous a:focus, #image-navigation .nav-next a:hover, #image-navigation .nav-next a:focus { background-color: '.dazzling_css_color( 'element_color_hover' ).'; border-color: '.dazzling_css_color( 'element_color_hover' ).'; }';
    }
    if ( dazzling_css_color( 'cfa_bg_color' )) {
      echo '.cfa { background-color: '.dazzling_css_color( 'cfa_bg_color' ).'; } .cfa-button:hover {color: '.dazzling_css_color( 'cfa_bg_color' ).';}';
    }
    if ( dazzling_css_color( 'cfa_color' )) {
      echo '.cfa-text { color: '.dazzling_css_color( 'cfa_color' ).';}';
    }
    if ( dazzling_css_color( 'cfa_btn_color' )) {
      echo '.cfa-button {border-color: '.dazzling_css_color( 'cfa_btn_color' ).';}';
    }
    if ( dazzling_css_color( 'cfa_btn_txt_color' )) {
      echo '.cfa-button {color: '.dazzling_css_color( 'cfa_btn_txt_color' ).';}';
    }
    if ( dazzling_css_color( 'heading_color' )) {
      echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .entry-title {color: '.dazzling_css_color( 'heading_color' ).';}';
    }
    if ( dazzling_css_color( 'top_nav_bg_color' )) {
      echo '.navbar.navbar-default {background-color: '.dazzling_css_color( 'top_nav_bg_color' ).';}';
    }
    if ( dazzling_css_color( 'top_nav_link_color' )) {
      echo '.navbar-default .navbar-nav > li > a { color: '.dazzling_css_color( 'top_nav_link_color' ).';}';
    }
    if ( dazzling_css_color( 'top_nav_dropdown_bg' )) {
      echo '.dropdown-menu, .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus {background-color: '.dazzling_css_color( 'top_nav_dropdown_bg' ).';}';
    }
    if ( dazzling_css_color( 'top_nav_dropdown_item' )) {
      echo '.navbar-default .navbar-nav .open .dropdown-menu > li > a { color: '.dazzling_css_color( 'top_nav_dropdown_item' ).';}';
    }
    if ( dazzling_css_color( 'footer_bg_color' )) {
      echo '#colophon {background-color: '.dazzling_css_color( 'footer_bg_color' ).';}';
    }
    if ( dazzling_css_color( 'footer_text_color' )) {
      echo '#footer-area, .site-info {color: '.dazzling_css_color( 'footer_text_color' ).';}';
    }
    if ( dazzling_css_color( 'footer_widget_bg_color' )) {
      echo '#footer-area {background-color: '.dazzling_css_color( 'footer_widget_bg_color' ).';}';
    }
    if ( dazzling_css_color( 'footer_link_color' )) {
      echo '.site-info a, #footer-area a {color: '.dazzling_css_color( 'footer_link_color' ).';}';
    }
    if ( dazzling_css_color( 'social_color' )) {
      echo '#social a {color: '.dazzling_css_color( 'social_color' ).' !important ;}';
    }
    if ( dazzling_css_color( 'social_hover_color' )) {
      echo '#social a:hover, #social a:focus {color: '.dazzling_css_color( 'social_hover_color' ).'!important ;}';
    }
    global $typography_options, $typography_defaults;

    $typography = of_get_option('main_body_typography', $typography_defaults);

    if ( $typography ) {
      $font_family = isset( $typography_options['faces'][$typography['face']] ) ? $typography_options['faces'][$typography['face']] : $typography_options['faces'][$typography_defaults['face']];
      $font_size = isset( $typography['size'] ) ? $typography['size'] : $typography_defaults['size'];
      $font_style = isset( $typography['style'] ) ? $typography['style'] : $typography_defaults['style'];
      $font_color = isset( $typography['color'] ) ? $typography['color'] : $typography_defaults['color'];
      echo '.entry-content {font-family: ' . esc_attr( $font_family ) . '; font-size:' . esc_attr( $font_size ) . '; font-weight: ' . esc_attr( $font_style ) . '; color:' . dazzling_sanitize_css_color( $font_color ) . ';}';
    }
    if ( of_get_option('custom_css')) {
      /*
       * html_entity_decode() used to run here, which turned an escaped
       * "</style><script>" back into live markup. Strip tags instead, so a value
       * stored in Theme Options cannot break out of the <style> element.
       */
      echo wp_strip_all_tags( of_get_option( 'custom_css', '' ) );
    }
      echo '</style>';
  }
}
add_action('wp_head','get_dazzling_theme_options',10);

?>
