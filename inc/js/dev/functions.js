// first set the body to hide and show everything when fully loaded
jQuery(document).ready(function(){

	// here for the submit button of the comment reply form
	jQuery( '#submit, .wpcf7-submit, .comment-reply-link, input[type="submit"]' ).addClass( 'btn btn-default' );

	// Add thumbnail styling
	jQuery( '.wp-caption' ).addClass( 'thumbnail' );

	// Now we'll add some classes for the WordPress default widgets - let's go
	jQuery( '.widget_rss ul' ).addClass( 'media-list' );

	// Add styling for WordPress calendar
	jQuery( 'table#wp-calendar' ).addClass( 'table table-striped');

});

// jQuery powered scroll to top

jQuery(document).ready(function(){

	//Check to see if the window is top if not then display button
	jQuery(window).scroll(function(){
		if (jQuery(this).scrollTop() > 100) {
			jQuery('.scroll-to-top').fadeIn();
		} else {
			jQuery('.scroll-to-top').fadeOut();
		}
	});

	//Click event to scroll to top
	jQuery('.scroll-to-top').click(function(){
		jQuery('html, body').animate({scrollTop : 0},800);
		return false;
	});

});

// Load flexslider in front page
jQuery(document).ready(function ($) {
  $(window).load(function() {
    $('.flexslider').flexslider({
      animation: "fade"
    });
  });
});

//skip link focus fix
( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
					element.tabIndex = -1;

				element.focus();
			}
		}, false );
	}
})();