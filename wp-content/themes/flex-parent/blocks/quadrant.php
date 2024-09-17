<div id="<?php echo $block["id"] ?>" class="quadrant block">
	<div class="container">
		<?php while (have_rows("quadrants")) : the_row() ?>
			<div class="quadrant">
				<div class="icon">
					<?php $image = get_sub_field("image") ?>
					<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["sizes"]["336x336"] ?>">
				</div>
				<div class="content">
					<?php if (get_sub_field("title")) : ?>
						<h2><?php echo the_sub_field("title") ?></h2>
					<?php endif ?>
					<?php if (get_sub_field("text")) : ?>
						<p><?php echo the_sub_field("text") ?></p>
					<?php endif ?>
					<?php if (get_sub_field("link")) : ?>
						<div class="link">
							<a title="<?php the_sub_field("title") ?>" href="<?php the_sub_field("link") ?>">
								Find out more
							</a>
						</div>
					<?php endif ?>
				</div>
			</div>
		<?php endwhile ?>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Get the block ID
				var id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal(id + " .quadrant .icon", {origin: "bottom", distance: "20px", duration: 1000});
				ScrollReveal().reveal(id + " .quadrant .content", {origin: "bottom", distance: "20px", duration: 1000});
			}(jQuery));
		});
	</script>
</div>