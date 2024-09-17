<?php

$top_background_color = get_field("top_background_color");
$bottom_background_color = get_field("bottom_background_color");
$max_text_width = get_field("max_text_width") ? get_field("max_text_width") : 792;
$link = get_field("link") ? get_field("link") : ["url" => "/contact-us", "target" => "_self", "title" => "Contact us"];

?>

<div id="<?php echo $block["id"] ?>" class="banner block">
	<div class="container">
		<div class="banner-text" style="max-width: <?php echo $max_text_width ?>px;">
			<?php the_field("text") ?>
		</div>
		<a title="<?php echo $link["title"] ?>" class="button" href="<?php echo $link["url"] ?>" target="<?php echo $link["target"] ?>">
			<?php echo $link["title"] ?>
			<div class="long-arrow">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.9 9.9" xml:space="preserve">
					<polygon points="15.5,0 14.5,0.9 17.4,4.3 0,4.3 0,5.7 17.4,5.7 14.5,9 15.5,9.9 19.9,5 "/>
				</svg>
				<div class="line"></div>
			</div>
		</a>
	</div>
	<div class="top left background" style="background-color: <?php echo $top_background_color ?>;"></div>
	<div class="right background"></div>
	<div class="bottom left background" style="background-color: <?php echo $bottom_background_color ?>;"></div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Get the block ID
				var id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal(id + " .banner-text", {origin: "bottom", distance: "20px", duration: 1000});
				ScrollReveal().reveal(id + " .button", {origin: "bottom", distance: "20px", duration: 1000});
			}(jQuery));
		});
	</script>
</div>