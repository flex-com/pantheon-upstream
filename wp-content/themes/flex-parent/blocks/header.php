<?php

$background_color = get_field("background_color");
$background_image_desktop = get_field("background_image_desktop") ? get_field("background_image_desktop")["url"] : null;
$content_width = get_field("content_width");

// Determine the content style
if ($background_image_desktop) {
	$content_style = "light-content";
} else {
	if (in_array(strtolower($background_color), ["#ffffff", "#eaeef4"])) {
		$content_style = "dark-content";
	} else {
		$content_style = "light-content";
	}
}

// Define an array of classes
$classes = [$content_style];
if ($background_image_desktop) {
	$classes[] = "has-background-image";
}

?>
<div id="<?php echo $block["id"] ?>" class="header block <?php echo implode(" ", $classes) ?>" style="background-color: <?php echo $background_color ?>;">
	<?php if ($background_image_desktop) : ?>
		<div class="background-image" style="background-image: url(<?php echo $background_image_desktop ?>);"></div>
	<?php endif ?>
	<div class="container">
		<div class="content" style="max-width: <?php echo $content_width ?>px;">
			<InnerBlocks/>
		</div>
	</div>
	<script>
		let id = "#<?php echo $block["id"] ?>";

		(function ($) {

			$(id + " .content h1").addClass("fade-in");
			$(id + " .content h2").addClass("fade-in");
			$(id + " .content p").addClass("fade-in");
			// Fade in the content

			// Fade in the background image
			if ($(id).children(".background-image").length > 0) {
				var image = new Image();
				image.onload = function () {
					$(id).children(".background-image").addClass("visible");
					$(id).children(".container").addClass("visible");
				};
				image.src = "<?php echo $background_image_desktop ?>";
			} else {
				$(id).children(".container").addClass("visible");
			}
		})(jQuery);

		window.addEventListener('DOMContentLoaded', () => {
			ScrollReveal().reveal(id + " .fade-in", {origin: "left", distance: "24px", interval: 100});
		});
	</script>
</div>