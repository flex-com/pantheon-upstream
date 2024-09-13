<?php

switch (get_field("columns")) {
	case "two-column":
		$image_size = "1176x784";
		break;
	case "three-column":
		$image_size = "768x512";
		break;
	case "four-column":
		$image_size = "564x376";
		break;
}

?>

<div id="<?php echo $block["id"] ?>" class="tiles block">
	<div class="container <?php echo get_field("columns") ?>">
		<?php while (have_rows("tiles")) : the_row() ?>
			<div class="tile">
				<a title="<?php the_sub_field("title") ?>" class="image" href="<?php the_sub_field("link") ?>">
					<?php $image = get_sub_field("image") ?>
					<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["sizes"][$image_size] ?>">
				</a>
				<div>
					<a title="<?php the_sub_field("title") ?>" class="title" href="<?php the_sub_field("link") ?>">
						<?php the_sub_field("title") ?>
					</a>
					<a title="<?php the_sub_field("title") ?>" class="long-arrow" href="<?php the_sub_field("link") ?>">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 10" xml:space="preserve">
						<polygon class="st0" points="15.5,0 14.5,0.9 17.6,4.5 4.5,4.5 4.5,5.8 17.5,5.8 14.5,9.1 15.5,10 20,5.1"/>
							<rect y="4.5" class="st0" width="2.6" height="1.3"/>
					</svg>
					</a>
				</div>
				<?php if (get_sub_field("text")) : ?>
					<div class="tiles-text">
						<p><?php the_sub_field("text") ?></p>
					</div>
				<?php endif ?>
			</div>
		<?php endwhile ?>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Get the block ID
				var id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal(id + " .tile", {origin: "bottom", distance: "20px", duration: 1000, viewFactor: 0.2, interval: 100, reset: false});
			}(jQuery));
		});
	</script>
</div>