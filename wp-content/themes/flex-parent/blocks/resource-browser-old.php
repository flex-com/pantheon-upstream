<?php

$categories = get_field("categories") ?? null;
$selected_content_types = $_GET["content_types"] ? explode("_", $_GET["content_types"]) : null;

$posts = get_posts([
	"post_type" => "resource",
	"posts_per_page" => -1,
	"cat" => $categories
]);

$available_content_types = [];
foreach ($posts as $post) {
	$available_content_types[] = get_the_terms($post, "content-type")[0]->slug;
}
$available_content_types = array_unique($available_content_types);

?>

<div class="resource-browser block">
	<div class="container">
		<div class="pagination pg-desktop"></div>
	</div>
	<div class="container">
		<div class="sidebar">
			<div class="term all <?php echo empty($selected_content_types) ? "checked" : "" ?>">
				<svg class="square" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM384 80H64C55.16 80 48 87.16 48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80z"/></svg>
				<svg class="square-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M211.8 339.8C200.9 350.7 183.1 350.7 172.2 339.8L108.2 275.8C97.27 264.9 97.27 247.1 108.2 236.2C119.1 225.3 136.9 225.3 147.8 236.2L192 280.4L300.2 172.2C311.1 161.3 328.9 161.3 339.8 172.2C350.7 183.1 350.7 200.9 339.8 211.8L211.8 339.8zM0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96zM48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80H64C55.16 80 48 87.16 48 96z"/></svg>	
				View all
			</div>
			<?php foreach (get_terms("content-type") as $content_type) : ?>
			<?php if (in_array($content_type->slug, $available_content_types)) : ?>
			<div class="term <?php echo in_array($content_type->slug, $selected_content_types) ? "checked" : "" ?>" data-slug="<?php echo $content_type->slug ?>">
				<svg class="square" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM384 80H64C55.16 80 48 87.16 48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80z"/></svg>
				<svg class="square-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M211.8 339.8C200.9 350.7 183.1 350.7 172.2 339.8L108.2 275.8C97.27 264.9 97.27 247.1 108.2 236.2C119.1 225.3 136.9 225.3 147.8 236.2L192 280.4L300.2 172.2C311.1 161.3 328.9 161.3 339.8 172.2C350.7 183.1 350.7 200.9 339.8 211.8L211.8 339.8zM0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96zM48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80H64C55.16 80 48 87.16 48 96z"/></svg>
				<?php echo $content_type->name ?>
			</div>
			<?php endif ?>
			<?php endforeach ?>
		</div>
		<div class="pagination pg-mobile"></div>
		<div class="posts">
			<?php foreach($posts as $post) : ?>
			<div class="post" data-content-type="<?php echo get_the_terms($post->ID, "content-type")[0]->slug ?>">
				<a title="<?php echo get_the_title($post->ID) ?>" class="image" href="<?php the_permalink($post->ID) ?>">
					<img src="<?php echo get_field("featured_image", $post->ID)["sizes"]["540x304"] ?>">
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
			function render() {
				var url = new URL(window.location.href);
				var posts = [];
				// Filter posts by content type
				var content_types = url.searchParams.get("content_types") ? url.searchParams.get("content_types").split("_") : null;
				$(".resource-browser .posts .post").each(function(index, post) {
					if (!content_types || content_types.indexOf($(post).data("content-type")) > -1) {
						posts.push(post);
					}
				});
				// Hide all posts
				$(".resource-browser .posts .post").hide();
				// Show posts on current page
				for (var i in posts) {
					if (i >= ((page - 1) * posts_per_page) && i < page * posts_per_page) {
						$(posts[i]).show();
					} else {
						$(posts[i]).hide();
					}
				}
				// Create pagination controls
				$(".resource-browser .pagination").empty();
				for (var i = 0; i < Math.ceil(posts.length / posts_per_page); i++) {
					var control = $("<span>" + (i + 1) + "</span>");
					if (i + 1 === page) {
						control.addClass("selected");
					}
					control.on("click", function() {
						page = parseInt($(this).text());
						$(".resource-browser .pagination span").removeClass("selected");
						$(this).addClass("selected");
						render();
					});
					$(".resource-browser .pagination").append(control);
				}
			}
			// Render on load
			render();
			// Handle content type filters
			$(".resource-browser .sidebar .term").on("click", function() {
				var url = new URL(window.location.href);
				if ($(this).is(".all")) {
					$(".resource-browser .sidebar .term").removeClass("checked");
					$(this).addClass("checked");
					url.searchParams.delete("content_types");
				} else {
					var selected_term = $(this).data("slug");
					var content_types = url.searchParams.get("content_types") ? url.searchParams.get("content_types").split("_") : [];
					var index = content_types.indexOf(selected_term);
					if (index > -1) {
						$(this).removeClass("checked");
						content_types.splice(index, 1);
					} else {
						$(this).addClass("checked");
						content_types.push(selected_term);
					}
					if (content_types.length > 0) {
						$(".resource-browser .sidebar .term.all").removeClass("checked");
						url.searchParams.set("content_types", content_types.join("_"));
					} else {
						$(".resource-browser .sidebar .term.all").addClass("checked");
						url.searchParams.delete("content_types");
					}
				}
				window.history.replaceState(null, document.title, url.toString());
				page = 1;
				render();
			});
		})(jQuery);
	</script>
</div>