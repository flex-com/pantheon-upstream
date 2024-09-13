<?php

$categories = get_field("categories") ?? null;
$selected_content_types = isset($_GET["content_types"]) ? explode("_", $_GET["content_types"]) : [];
$selected_subcategories = isset($_GET["subcategories"]) ? explode("_", $_GET["subcategories"]) : [];

$posts = get_posts([
	"post_type"      => "resource",
	"posts_per_page" => -1,
	"cat"            => $categories
]);

$subcategories = [];
foreach ($categories as $category) {
	$subcategories = array_merge($subcategories, get_terms("category", ["parent" => $category]));
}

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
			<?php if (count($available_content_types) > 0) : ?>
				<div class="sidebar-heading">
					Content Type
				</div>
			<?php endif ?>
			<div class="term-ct all-ct <?php echo empty($selected_content_types) ? "checked" : "" ?>">
				<svg class="square" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
					<path d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM384 80H64C55.16 80 48 87.16 48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80z"/>
				</svg>
				<svg class="square-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
					<path d="M211.8 339.8C200.9 350.7 183.1 350.7 172.2 339.8L108.2 275.8C97.27 264.9 97.27 247.1 108.2 236.2C119.1 225.3 136.9 225.3 147.8 236.2L192 280.4L300.2 172.2C311.1 161.3 328.9 161.3 339.8 172.2C350.7 183.1 350.7 200.9 339.8 211.8L211.8 339.8zM0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96zM48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80H64C55.16 80 48 87.16 48 96z"/>
				</svg>
				View all
			</div>
			<?php foreach (get_terms("content-type") as $content_type) : ?>
				<?php if (in_array($content_type->slug, $available_content_types)) : ?>
					<div class="term-ct <?php echo in_array($content_type->slug, $selected_content_types) ? "checked" : "" ?>" data-slug="<?php echo $content_type->slug ?>">
						<svg class="square" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
							<path d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM384 80H64C55.16 80 48 87.16 48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80z"/>
						</svg>
						<svg class="square-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
							<path d="M211.8 339.8C200.9 350.7 183.1 350.7 172.2 339.8L108.2 275.8C97.27 264.9 97.27 247.1 108.2 236.2C119.1 225.3 136.9 225.3 147.8 236.2L192 280.4L300.2 172.2C311.1 161.3 328.9 161.3 339.8 172.2C350.7 183.1 350.7 200.9 339.8 211.8L211.8 339.8zM0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96zM48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80H64C55.16 80 48 87.16 48 96z"/>
						</svg>
						<?php echo $content_type->name ?>
					</div>
				<?php endif ?>
			<?php endforeach ?>

			<?php if (count($subcategories) > 0) : ?>
				<div class="sidebar-heading second">
					Category
				</div>
				<div class="term-sub all-sub <?php echo empty($selected_subcategories) ? "checked" : "" ?>">
					<svg class="square" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
						<path d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM384 80H64C55.16 80 48 87.16 48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80z"/>
					</svg>
					<svg class="square-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
						<path d="M211.8 339.8C200.9 350.7 183.1 350.7 172.2 339.8L108.2 275.8C97.27 264.9 97.27 247.1 108.2 236.2C119.1 225.3 136.9 225.3 147.8 236.2L192 280.4L300.2 172.2C311.1 161.3 328.9 161.3 339.8 172.2C350.7 183.1 350.7 200.9 339.8 211.8L211.8 339.8zM0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96zM48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80H64C55.16 80 48 87.16 48 96z"/>
					</svg>
					View all
				</div>
			<?php endif ?>
			<?php foreach ($subcategories as $subcategory) : ?>
				<div class="term-sub <?php echo in_array($subcategory->slug, $selected_subcategories) ? "checked" : "" ?>" data-slug="<?php echo $subcategory->slug ?>">
					<svg class="square" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
						<path d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM384 80H64C55.16 80 48 87.16 48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80z"/>
					</svg>
					<svg class="square-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
						<path d="M211.8 339.8C200.9 350.7 183.1 350.7 172.2 339.8L108.2 275.8C97.27 264.9 97.27 247.1 108.2 236.2C119.1 225.3 136.9 225.3 147.8 236.2L192 280.4L300.2 172.2C311.1 161.3 328.9 161.3 339.8 172.2C350.7 183.1 350.7 200.9 339.8 211.8L211.8 339.8zM0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96zM48 96V416C48 424.8 55.16 432 64 432H384C392.8 432 400 424.8 400 416V96C400 87.16 392.8 80 384 80H64C55.16 80 48 87.16 48 96z"/>
					</svg>
					<?php echo $subcategory->name ?>
				</div>
			<?php endforeach ?>
		</div>

		<div class="pagination pg-mobile"></div>
		<div class="posts">
			<div class="no-results">No resources found. Please make a new selection.</div>
			<?php foreach ($posts as $post) : ?>
				<div class="post" data-content-type="<?php echo get_the_terms($post->ID, "content-type")[0]->slug ?>"
					 data-subcategories="<?php echo join(', ', wp_list_pluck(get_the_terms($post->ID, "category"), 'slug')) ?>">
					<a title="<?php echo get_the_title($post->ID) ?>" class="image" href="<?php the_permalink($post->ID) ?>">
						<?php $image = get_field("featured_image", $post->ID) ?>
						<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["sizes"]["540x304"] ?>">
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
		(function ($) {
			var page = 1;
			var posts_per_page = 12;

			function render() {
				var url = new URL(window.location.href);
				var posts = [];
				// Filter posts by content type & subcategory
				// Get search terms from url
				var content_types = url.searchParams.get("content_types") ? url.searchParams.get("content_types").split("_") : null;
				var subcategories = url.searchParams.get("subcategories") ? url.searchParams.get("subcategories").split("_") : null;
				// Iterate over all posts
				$(".resource-browser .posts .post").each(function (index, post) {
					// Initially all posts set to not be included
					var include = false;
					// If any content type in search string
					if (content_types) {
						// Iterate over content types
						for (var content_type of content_types) {
							// If content type associated with resource equals content type in search string include on page
							if ($(post).data("content-type").indexOf(content_type) > -1) {
								include = true;
							}
						}
						// If no content types in search string include all posts
					} else {
						include = true;
					}
					// If post is included based on content type
					if (include) {
						// If no subcategory in search string then include stays equal to true
						// If any subcategory in search string
						if (subcategories) {
							// Initially all posts set to not be included
							include = false;
							// Iterate over subcategories
							for (var subcategory of subcategories) {
								// If subcategory associated with resource equals subcategory in search string include on page
								if ($(post).data("subcategories").indexOf(subcategory) > -1) {
									include = true;
								}
							}
						}
					}
					// If include equals true then show post on page
					if (include) {
						posts.push(post)
					}
				});
				// Hide no results message
				$(".resource-browser .posts .no-results").hide();
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
				// Show zero results message
				if (posts.length < 1) {
					$(".resource-browser .posts .no-results").show();
				}
				// Create pagination controls
				$(".resource-browser .pagination").empty();
				for (var i = 0; i < Math.ceil(posts.length / posts_per_page); i++) {
					var control = $("<span>" + (i + 1) + "</span>");
					if (i + 1 === page) {
						control.addClass("selected");
					}
					control.on("click", function () {
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
			$(".resource-browser .sidebar .term-ct").on("click", function () {
				var url = new URL(window.location.href);
				if ($(this).is(".all-ct")) {
					$(".resource-browser .sidebar .term-ct").removeClass("checked");
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
						$(".resource-browser .sidebar .term-ct.all-ct").removeClass("checked");
						url.searchParams.set("content_types", content_types.join("_"));
					} else {
						$(".resource-browser .sidebar .term-ct.all-ct").addClass("checked");
						url.searchParams.delete("content_types");
					}
				}
				window.history.replaceState(null, document.title, url.toString());
				page = 1;
				render();
			});
			// Handle subcategory filters
			$(".resource-browser .sidebar .term-sub").on("click", function () {
				var url = new URL(window.location.href);
				if ($(this).is(".all-sub")) {
					$(".resource-browser .sidebar .term-sub").removeClass("checked");
					$(this).addClass("checked");
					url.searchParams.delete("subcategories");
				} else {
					var selected_term = $(this).data("slug");
					var subcategories = url.searchParams.get("subcategories") ? url.searchParams.get("subcategories").split("_") : [];
					var index = subcategories.indexOf(selected_term);
					if (index > -1) {
						$(this).removeClass("checked");
						subcategories.splice(index, 1);
					} else {
						$(this).addClass("checked");
						subcategories.push(selected_term);
					}
					if (subcategories.length > 0) {
						$(".resource-browser .sidebar .term-sub.all-sub").removeClass("checked");
						url.searchParams.set("subcategories", subcategories.join("_"));
					} else {
						$(".resource-browser .sidebar .term-sub.all-sub").addClass("checked");
						url.searchParams.delete("subcategories");
					}
				}
				window.history.replaceState(null, document.title, url.toString());
				page = 1;
				render();
			});
		})(jQuery);
	</script>
</div>