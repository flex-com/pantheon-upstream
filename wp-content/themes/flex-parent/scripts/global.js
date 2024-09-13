$ = jQuery;

//====================================================================================================
// Fonts
//====================================================================================================

// Render the page once the fonts have loaded
if (document.fonts) {
	document.fonts.ready.then(function () {
		$("body").addClass("fonts-loaded");
	});
} else {
	$("body").addClass("fonts-loaded");
}

// Set a session cookie indicating that fonts have been loaded once and are likely cached
Cookies.set("wp-fonts-loaded", "true");

//====================================================================================================
// Cookie Notice
//====================================================================================================

function dismiss_cookie_notice() {
	$("#cookie-notice").css({bottom: -$("#cookie-notice").outerHeight() + "px"});
	// Set a session cookie to prevent the cookie notice from being shown again
	Cookies.set("wp-cookie-notice", "false");
}

// Dismiss the cookie notice on click
$("#cookie-notice a[href='#dismiss']").on("click", function (event) {
	event.preventDefault();
	dismiss_cookie_notice();
});

// Dismiss the cookie notice on scroll
$(window).on("scroll", function () {
	dismiss_cookie_notice();
});