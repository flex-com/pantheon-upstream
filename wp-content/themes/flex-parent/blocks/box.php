<?php

$full_width = get_field("full_width");
$background_color = get_field("background_color") ? get_field("background_color") : "transparent";
$background_opacity = $background_color == "transparent" ? "" : dechex((get_field("background_opacity") ? get_field("background_opacity") : 100) * 255 / 100);
$background_image_desktop = get_field("background_image_desktop") ? "url(".get_field("background_image_desktop")["url"].")" : "none";
$top_padding = get_field("top_padding") ? get_field("top_padding") : 0;
$right_padding = get_field("right_padding") ? get_field("right_padding") : 0;
$bottom_padding = get_field("bottom_padding") ? get_field("bottom_padding") : 0;
$left_padding = get_field("left_padding") ? get_field("left_padding") : 0;
$left_margin = get_field("left_margin") ? get_field("left_margin") : 0;
$right_margin = get_field("right_margin") ? get_field("right_margin") : 0;
$match_height = get_field("match_height");
$language = substr(get_locale(), 0, 2);
$visibility = get_field("visibility");

$classes = [$full_width ? "full-width" : "content-width"];

if ($match_height) {
	$classes[] = "match-height";
}

// Determine the default content style
if (in_array(strtolower($background_color), ["transparent", "#ffffff", "#eaeef4"])) {
	$classes[] = "dark-content";
} else {
	$classes[] = "light-content";
}

$block_id = uniqid('id-');

?>
<?php if (empty($visibility) || in_array($language, $visibility)) : ?>
<div id="<?php echo $block_id ?>" class="box block <?php echo implode(" ", $classes) ?> <?php echo $language ?> <?php echo $visibility ?>" style="background-color: <?php echo $full_width ? $background_color.$background_opacity : "transparent" ?>; background-image: <?php echo $background_image_desktop ?>;">
	<style>
		#<?php echo $block_id ?> > .container > .content {
			background-color: <?php echo $background_color.$background_opacity ?>;
			position: relative;
			padding-top: <?php echo $top_padding ?>px;
			padding-right: <?php echo $right_padding ?>px;
			padding-bottom: <?php echo $bottom_padding ?>px;
			padding-left: <?php echo $left_padding ?>px;
			margin-left: <?php echo $left_margin ?>px;
			margin-right: <?php echo $right_margin ?>px;
		}
		@media (max-width: 1272px) {
			#<?php echo $block_id ?>.box.block.full-width > .container > .content {
				padding-left: 0 !important;
				padding-right: 0 !important;
				margin: 0 !important;
			}
		}
		@media (max-width: 960px) {
			#<?php echo $block_id ?> > .container > .content {
				//padding-top: <?php echo $top_padding / 2 ?>px;
				padding-right: <?php echo $right_padding / 2 ?>px;
				//padding-bottom: <?php echo $bottom_padding / 2 ?>px;
				padding-left: <?php echo $left_padding / 2 ?>px;
			}
		}
	</style>
	<div class="container">
		<div class="content">
			<InnerBlocks />
		</div>
	</div>
</div>
<?php endif ?>