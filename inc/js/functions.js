// first set the body to hide and show everything when fully loaded
document.write("<style>body{display:none;}</style>");

jQuery(document).ready(function(){
	
	// here for each comment reply link of WordPress
	jQuery( '.comment-reply-link' ).addClass( 'btn btn-default' );

	// here for the submit button of the comment reply form
	jQuery( '#submit' ).addClass( 'btn btn-default' );	

	// Style contact form submit button
	jQuery( '.wpcf7-submit' ).addClass( 'btn btn-default' );	

	// Add thumbnail styling
	jQuery( '.wp-caption' ).addClass( 'thumbnail' );

	// Apply styling for regular submit buttons
	jQuery('input[type="submit"]').addClass('btn btn-default');
	
	// Now we'll add some classes for the WordPress default widgets - let's go  
	jQuery( '.widget_rss ul' ).addClass( 'media-list' );

	// Add Bootstrap style for drop-downs 
	jQuery( '.postform' ).addClass( 'form-control' );	

	jQuery( 'table#wp-calendar' ).addClass( 'table table-striped');
	
	jQuery(document.body).show();

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