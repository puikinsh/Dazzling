jQuery(document).ready(function($) {
        // Apply Bootstrap classes for some WordPress components
    $('#submit, .wpcf7-submit, .comment-reply-link, input[type="submit"]').addClass('btn btn-default');
    $('.wp-caption').addClass('thumbnail');
    $('.widget_rss ul').addClass('media-list');
    $('table#wp-calendar').addClass('table table-striped');

        // Scroll to top
        // Makes scroll to top appear only when user starts to scroll down
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });
    // Animation for scroll to top
    $('.scroll-to-top').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    // Load Flexslider and add some options
        if ( $('.flexslider').length) {
        $('.flexslider').flexslider({
            animation: "fade",
            controlNav: true,
            prevText: "",
            nextText: "",
            smoothHeight: true
        });
      }
        // Skip link focus
    ( function() {
        var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
            is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
            is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

        if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
            window.addEventListener( 'hashchange', function() {
                var id = location.hash.substring( 1 ),
                    element;

                if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
                    return;
                }

                element = document.getElementById( id );

                if ( element ) {
                    if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
                        element.tabIndex = -1;
                    }

                    element.focus();
                }
            }, false );
        }
    })();

});