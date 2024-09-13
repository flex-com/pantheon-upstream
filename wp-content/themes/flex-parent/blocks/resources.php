<?php

$automatic_categories = get_field("automatic_categories") ?? null;
$automatic_content_types = get_field("automatic_content_types") ?? null;

$posts = [];
$curated_posts = [];

if (get_field("curated_posts")) {
	$curated_posts = get_posts([
		"post_type" => "resource",
		"post__in" => get_field("curated_posts"),
		"orderby" => "post__in",
		"posts_per_page" => -1
	]);
	$posts = array_merge($posts, $curated_posts);
}

if (get_field("automatic_count")) {
	$automatic_posts = get_posts([
		"post_type" => "resource",
		"posts_per_page" => get_field("automatic_count"),
		"post__not_in" => $curated_posts,
		"cat" => $automatic_categories,
		"tax_query" => $automatic_content_types ? [["taxonomy" => "content-type", "field" => "term_id", "terms" => $automatic_content_types]] : null
	]);
	$posts = array_merge($posts, $automatic_posts);
}

?>

<div id="<?php echo $block["id"] ?>" class="resources block">
	<div class="container <?php echo get_field("show_images") ? "show-images" : "" ?>">
		<div class="posts">
			<?php foreach ($posts as $post) : ?>
				<div class="post">
					<?php if (get_field("show_images")) : ?>
						<a title="<?php echo get_the_title($post->ID) ?>" class="image" href="<?php the_permalink($post->ID) ?>">
							<?php $image = get_field("featured_image", $post->ID) ?>
							<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["sizes"]["760x428"] ?>">
							<?php $content_type = get_the_terms($post->ID, "content-type")[0]->name ?>
							<?php if (strlen(trim($content_type)) > 0) : ?>
								<div class="label">
									<?php echo $content_type ?>
								</div>
							<?php endif ?>
						</a>
					<?php endif ?>
					<?php if (get_field("show_dates")) : ?>
						<div class="date">
							<?php echo get_the_date("", $post->ID) ?>
						</div>
					<?php endif ?>
					<a title="<?php echo get_the_title($post->ID) ?>" class="title" href="<?php the_permalink($post->ID) ?>">
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
				ScrollReveal().reveal(id + " .post", {origin: "bottom", distance: "20px", duration: 1000, viewFactor: 0.2, interval: 100, reset: false});
			}(jQuery));
		});
	</script>
</div>