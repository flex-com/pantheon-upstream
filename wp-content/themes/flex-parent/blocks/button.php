<?php

$alignment = get_field("alignment") ? get_field("alignment") : "left";

?>
<div id="<?php echo $block["id"] ?>" class="button block">
	<div class="container <?php echo $alignment ?>">
		<a title="<?php echo get_field("link")["title"] ?>" href="<?php echo get_field("link")["url"] ?>" target="<?php echo get_field("link")["target"] ?>"
		   class="btn-link<?php if (get_field("show_border")) : ?> border<?php endif ?>">
			<?php echo get_field("link")["title"] ?>
			<div class="long-arrow">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.9 9.9" xml:space="preserve">
					<polygon points="15.5,0 14.5,0.9 17.4,4.3 0,4.3 0,5.7 17.4,5.7 14.5,9 15.5,9.9 19.9,5 "/>
				</svg>
				<div class="line"></div>
			</div>
		</a>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Get the block ID
				var id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal(id + " .btn-link", {origin: "bottom", distance: "20px", duration: 1000});
			}(jQuery));
		});
	</script>
</div>