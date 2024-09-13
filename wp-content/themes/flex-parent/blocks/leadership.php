<div id="<?php echo $block["id"] ?>" class="leadership block">
	<div class="container <?php echo get_field("columns") ?>">
		<?php foreach (get_field("users") as $user) : ?>
			<a title="<?php echo $user["display_name"] ?>" class="user" href="/leadership/<?php echo $user["user_nicename"] ?>">
				<?php $image = get_field("photo", "user_" . $user["ID"]) ?>
				<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["sizes"]["336x336"] ?>">
				<div class="name"><?php echo $user["display_name"] ?></div>
				<div class="title"><?php echo get_field("title", "user_" . $user["ID"]) ?></div>
			</a>
		<?php endforeach ?>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Get the block ID
				var id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal(id + " .user", {origin: "bottom", distance: "20px", duration: 1000, viewFactor: 0.2, interval: 100, reset: false});
			}(jQuery));
		});
	</script>
</div>