<?php

$posts = get_posts([
	"post_type" => "news",
	"posts_per_page" => get_field("limit_type") == "number" ? get_field("limit_number") : -1,
	"date_query" => get_field("limit_type") == "months" ? ["column" => "post_date_gmt", "after" => get_field("limit_months") . " months ago"] : null
]);

?>

<div id="<?php echo $block["id"] ?>" class="news block">
	<div class="container">
		<div class="posts">
			<?php foreach ($posts as $post) : ?>
				<div class="post">
					<div class="date">
						<?php echo get_the_date("", $post->ID) ?>
					</div>
					<a title="<?php echo get_the_title($post->ID) ?>" class="title" href="<?php echo get_field("link", $post->ID) ?>">
						<?php echo get_the_title($post->ID) ?>
					</a>
				</div>
			<?php endforeach ?>
		</div>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Get the block ID
				var id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal(id + " .post", {origin: "bottom", distance: "20px", duration: 1000});
			}(jQuery));
		});
	</script>
</div>