<?php

$background_color = get_field("background_color");
$horizontal_padding = get_field("horizontal_padding");

$classes = [$horizontal_padding ? "with-horizontal-padding" : "no-horizontal-padding"];

// Determine the content style
if (in_array(strtolower($background_color), ["#ffffff", "#eaeef4"])) {
	$classes[] = "dark-content";
} else {
	$classes[] = "light-content";
}

?>
<div id="<?php echo $block["id"] ?>" class="quote block <?php echo implode(" ", $classes) ?>">
	<div class="container" style="background-color: <?php echo $background_color ?>;">
		<div class="quote-lines-top"></div>
		<div class="quote-marks-top" style="background-color: <?php echo $background_color ?>;">
			<svg viewBox="0 0 33 27" xmlns="http://www.w3.org/2000/svg"><path d="m33 20.8c0-3.9-2.9-6.3-6.4-6.3-1.1 0-1.8.3-2.1.5.1-4.3 3.3-9 8-10.1v-4.9c-6 .6-14.2 5.9-14.2 18.2 0 5.9 3.6 8.8 7.8 8.8 3.9 0 6.9-2.8 6.9-6.2zm-18.3 0c0-3.9-2.9-6.3-6.4-6.3-1.1 0-1.8.3-2.1.5.1-4.3 3.3-9 8-10.1v-4.9c-6 .6-14.2 5.9-14.2 18.2 0 5.9 3.6 8.8 7.8 8.8 3.9 0 6.9-2.8 6.9-6.2z" fill="#fff"/></svg>
		</div>
		<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode(["acf/media", "acf/spacer", "core/paragraph"])) ?>" />
		<div class="quote-lines-bottom"></div>
		<div class="quote-marks-bottom" style="background-color: <?php echo $background_color ?>;">
			<svg viewBox="0 0 33 27" xmlns="http://www.w3.org/2000/svg"><path d="m0 6.2c0 3.9 2.9 6.3 6.4 6.3 1.1 0 1.8-.3 2.1-.5-.1 4.3-3.3 9-8 10.1v4.9c6-.6 14.2-5.9 14.2-18.2 0-5.9-3.6-8.8-7.8-8.8-3.9 0-6.9 2.8-6.9 6.2zm18.3 0c0 3.9 2.9 6.3 6.4 6.3 1.1 0 1.8-.3 2.1-.5-.1 4.3-3.3 9-8 10.1v4.9c6-.6 14.2-5.9 14.2-18.2 0-5.9-3.6-8.8-7.8-8.8-3.9 0-6.9 2.8-6.9 6.2z" fill="#fff"/></svg>
		</div>
	</div>
</div>