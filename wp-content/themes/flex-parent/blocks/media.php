<?php

$media_position = get_field("media_position");
$content_position = get_field("content_position");
$media_horizontal_offset = get_field("media_horizontal_offset") ? get_field("media_horizontal_offset") : 0;
$media_width = get_field("media_width") ? get_field("media_width") . "px" : ($media_position == "media-center" ? "100%" : "360px");
$media_type = get_field("media_type");
$crop = get_field("crop") ? get_field("crop") : "";
$gutter_width = get_field("gutter_width") ? get_field("gutter_width") : 36;

?>
<div id="<?php echo $block["id"] ?>" class="media block">
	<div class="container <?php echo $media_position ?> <?php echo $content_position ?>">
		<div class="media" style="left: <?php echo $media_horizontal_offset ?>px; min-width: <?php echo $media_width ?>; max-width: <?php echo $media_width ?>;">
			<?php if ($media_type == "image") : ?>
				<div class="image <?php echo $crop ?>">
					<?php $image = get_field("image") ?>
					<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["sizes"]["1200x9999"] ?>">
				</div>
			<?php elseif ($media_type == "video") : ?>
				<div class="video">
					<iframe src="https://www.youtube.com/embed/<?php echo get_field("youtube_id") ?>?rel=0" frameborder="0" playsinline="0" allow="encrypted-media" allowfullscreen="true"></iframe>
				</div>
			<?php endif ?>
		</div>
		<?php if ($media_position != "media-center") : ?>
			<div class="content" style="margin-right: <?php echo $media_position == "media-left" ? 0 : $gutter_width ?>px; margin-left: <?php echo $media_position == "media-left" ? $gutter_width : 0 ?>px;">
				<InnerBlocks/>
			</div>
		<?php endif ?>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Get the block ID
				var id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal(id + " .container .media", {origin: "bottom", distance: "20px", opacity: 1, duration: 1000});
				ScrollReveal().reveal(id + " .container .content", {origin: "bottom", distance: "20px", opacity: 1, duration: 1000});
			}(jQuery));
		});
	</script>
</div>