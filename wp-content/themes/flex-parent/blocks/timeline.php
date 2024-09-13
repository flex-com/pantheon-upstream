<?php

$max_width = get_field("max_width") ? get_field("max_width") : 1200;
$gutter_width = get_field("gutter_width");
$circle_size = get_field("circle_size");
$circle_background_color = get_field("circle_background_color") ? get_field("circle_background_color") : "transparent";

// Determine the circle text style
if (get_field("circle_image")) {
	$circle_text_style = "light-content";
} else {
	if (in_array(strtolower($circle_background_color), ["#ffffff", "#eaeef4"])) {
		$circle_text_style = "dark-content";
	} else {
		$circle_text_style = "light-content";
	}
}

?>
<div class="timeline block">
	<div class="container" style="max-width: <?php echo $max_width ?>px;">
		<div class="timeline" style="margin-right: <?php echo $gutter_width ?>px;">
			<div class="circle <?php echo $circle_text_style ?>" style="min-width: <?php echo $circle_size ?>px; max-width: <?php echo $circle_size ?>px; height: <?php echo $circle_size ?>px; background-color: <?php echo $circle_background_color ?>;">
				<?php if (get_field("circle_image")) : ?>
				<?php $image = get_field("circle_image") ?>
				<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["url"] ?>">
				<?php endif ?>
				<?php if (get_field("circle_text")) : ?>
				<span><?php echo get_field("circle_text") ?></span>
				<?php endif ?>
			</div>
			<?php if (get_field("show_line")) : ?>
			<div class="line" style="top: <?php echo $circle_size ?>px;"></div>
			<?php endif ?>
		</div>
		<div class="content">
			<InnerBlocks />
		</div>
	</div>
</div>