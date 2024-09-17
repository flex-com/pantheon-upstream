<?php

$categories = get_field("categories") ?? null;
$content_types = get_field("content_types") ?? null;

$posts = get_posts([
	"post_type" => "resource",
	"posts_per_page" => -1,
	"cat" => $categories,
	"tax_query" => $content_types ? [["taxonomy" => "content-type", "field" => "term_id", "terms" => $content_types]] : null
]);

?>

<div id="<?php echo $block["id"] ?>" class="resource-archive block">
	<div class="container">
		<div class="pagination"></div>
	</div>
	<div class="container show-images">
		<div class="posts">
			<?php foreach($posts as $post) : ?>
			<div class="post" data-content-type="<?php echo get_the_terms($post->ID, "content-type")[0]->slug ?>">
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
				<div class="date">
					<?php echo get_the_date("", $post->ID) ?>
				</div>
				<a title="<?php echo get_the_title($post->ID) ?>" class="title" href="<?php the_permalink($post->ID) ?>">
					<?php echo get_the_title($post->ID) ?>
				</a>
			</div>
			<?php endforeach ?>
		</div>
	</div>
	<div class="container">
		<div class="pagination"></div>
	</div>
	<script>
		(function($) {
			var page = 1;
			var posts_per_page = 12;
			var posts = $(".resource-archive .posts .post");
			function render() {
				// Hide all posts
				posts.hide();
				// Iterate over all posts and show posts on current page
				posts.each(function(i) {
					if (i >= ((page - 1) * posts_per_page) && i < page * posts_per_page) {
						$(this).show();
					} else {
						$(this).hide();
					}
				});
				// Create pagination controls
				$(".resource-archive .pagination").empty();
				for (var i = 0; i < Math.ceil(posts.length / posts_per_page); i++) {
					var control = $("<span>" + (i + 1) + "</span>");
					if (i + 1 === page) {
						control.addClass("selected");
					}
					control.on("click", function() {
						page = parseInt($(this).text());
						$(".resource-archive .pagination span").removeClass("selected");
						$(this).addClass("selected");
						render();
					});
					$(".resource-archive .pagination").append(control);
				}
			}
			// Render on load
			render();
		})(jQuery);
	</script>
</div>