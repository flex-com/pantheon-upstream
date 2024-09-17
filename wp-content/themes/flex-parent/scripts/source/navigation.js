$ = jQuery;

var dropdown = $(".desktop.menu .dropdown");
var perspective_origin = null;

// Create a handle for the dropdown and create a virtual copy of the dropdown to facilitate layout measurements
var virtual_dropdown = dropdown.clone().addClass("virtual").css({opacity: 0, pointerEvents: "none"}).appendTo(".desktop.menu");

// Divide long dropdown menus into 2 columns
$(".desktop.menu ul.menu > li > ul.sub-menu").each(function() {
	if ($(this).find("li").length > 10) {
		$(this).css({columnCount: 2});
	}
});

// Handle the mouse entering top-level menu items
$(".desktop.menu ul.menu > li").on("mouseenter", function(event) {
	// If the menu item is not already active and the event did not fire on page load
	if (!$(this).is(".active") && event.relatedTarget) {
		var side = "right";
		if (event.offsetX < $(this).width() / 2) {
			side = "left";
		}
		// Show the animated line
		$("ul.menu > li").removeClass("active");
		$(this).addClass("active");
		// If the menu item has a sub-menu
		if ($(this).is(".menu-item-has-children")) {
			var submenu = $(this).find("ul.sub-menu").clone();
			var position = $(this).position();
			show_dropdown(submenu, position, side);
		} else {
			hide_dropdown();
		}
	}
});

// Handle the mouse leaving the top-level menu
$(".desktop.menu ul.menu, .desktop.menu .dropdown").on("mouseleave", function(event) {
	// If the mouse has not entered another part of the menu
	if (!$(event.relatedTarget).is(".menu, .menu-item, .dropdown")) {
		// Hide the animated line
		$("ul.menu > li").removeClass("active");
		// Hide the dropdown
		hide_dropdown();
	}
});

// Show the dropdown
function show_dropdown(submenu, position, side) {
	// Insert the sub-menu into the virtual dropdown
	virtual_dropdown.find(".content").html(submenu);
	// Store the width and height
	var width = virtual_dropdown.width();
	var height = virtual_dropdown.height();
	// Update the perspective origin
	perspective_origin = (position.left + (width / 2)) + "px";
	$(".desktop.menu").css({perspectiveOrigin: perspective_origin});
	// Insert the new content
	var content = virtual_dropdown.find(".content").clone();
	content.css({position: "absolute", opacity: 0});
	dropdown.append(content);
	// If the dropdown is already visible
	if (dropdown.is(".visible")) {
		// Prepare the new content for animation
		content.css({transform: side == "right" ? "translateX(-12px)" : "translateX(12px)"});
		// Wait for the next animation frame
		requestAnimationFrame(function() {
			// Fade out the old content
			$(".desktop.menu .dropdown:not(.virtual) .content").css({opacity: 0, transform: side == "right" ? "translateX(12px)" : "translateX(-12px)"})
			// Fade in the new content
			$(content).css({opacity: 1, transform: "translateX(0px)"});
			// Remove the old content after the animation is complete
			setTimeout(function() {
				$(".desktop.menu .dropdown:not(.virtual) .content:not(:last-child)").remove();
			}, 500);
		});
		// Prepare the dropdown animation
		dropdown.css({transition: "left 500ms cubic-bezier(0.19, 1, 0.22, 1), width 500ms cubic-bezier(0.19, 1, 0.22, 1), height 500ms cubic-bezier(0.19, 1, 0.22, 1)"});
	}
	// If the dropdown is not already visible
	else {
		// Remove the old content immediately
		$(".desktop.menu .dropdown .content:not(:last-child)").remove();
		// Fade in the new content
		content.css({opacity: 1});
		// Set up the dropdown animation
		dropdown.css({transition: "transform 500ms cubic-bezier(0.19, 1, 0.22, 1), opacity 500ms cubic-bezier(0.19, 1, 0.22, 1)"});
		// Show the dropdown
		dropdown.addClass("visible");
	}
	// Update the position and width of the dropdown
	dropdown.css({left: position.left, width: width, height: height});
}

// Hide the dropdown
function hide_dropdown() {
	// Prepare the dropdown animation
	$(".desktop.menu").css({perspectiveOrigin: perspective_origin});
	dropdown.css({transition: "transform 500ms cubic-bezier(0.19, 1, 0.22, 1), opacity 500ms cubic-bezier(0.19, 1, 0.22, 1)"});
	// Hide the dropdown
	dropdown.removeClass("visible");
}

// Handle the search bar
$("#flex-header .search").on("click", function() {
	$(this).toggleClass("open");
	$(this).find("input").focus();
});

// Update language switcher
function update_language_switcher() {
	$("#flex-header .language a").each(function() {
		$(this).attr("href", location.href.replace(location.origin, $(this).data("root")));
	});
	$("#flex-header .mobile-language a").each(function() {
		$(this).attr("href", location.href.replace(location.origin, $(this).data("root")));
	});
}

// Update language switcher on page load
update_language_switcher();

// Update language switcher on hash change
addEventListener("hashchange", function() {
	update_language_switcher();
});

// Show the languages dropdown
$("#flex-header .languages").on("mouseenter", function() {
	$(this).find("div.l-menu-wrapper").addClass("visible");
});

// Hide the languages dropdown
$("#flex-header .languages").on("mouseleave", function() {
	$(this).find("div.l-menu-wrapper").removeClass("visible");
});

// Show the languages dropdown
$("#flex-header .mobile-languages").on("mouseenter", function() {
	$(this).find("div.l-menu-wrapper").addClass("visible");
});

// Hide the languages dropdown
$("#flex-header .mobile-languages").on("mouseleave", function() {
	$(this).find("div.l-menu-wrapper").removeClass("visible");
});

// Show the companies dropdown
$("#flex-header .companies").on("mouseenter", function() {
	$(this).find("ul.menu").addClass("visible");
});

// Hide the companies dropdown
$("#flex-header .companies").on("mouseleave", function() {
	$(this).find("ul.menu").removeClass("visible");
});

// Mobile navigation menu
$("#flex-header .mobile-menu-toggle").on("click", function() {
	$(this).find(".bar").toggleClass("close");
	$("#flex-header nav.mobile").toggleClass("visible");
});