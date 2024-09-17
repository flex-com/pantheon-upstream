<?php
/**
 * Generate a SVG string representing a square.
 *
 * @return string The SVG code for a square.
 */
function squareSVG(): string {
	return '<svg class="square" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M384 32c35.3 0 64 28.65 64 64v320c0 35.3-28.7 64-64 64H64c-35.35 0-64-28.7-64-64V96c0-35.35 28.65-64 64-64h320zm0 48H64c-8.84 0-16 7.16-16 16v320c0 8.8 7.16 16 16 16h320c8.8 0 16-7.2 16-16V96c0-8.84-7.2-16-16-16z"/></svg>';
}

/**
 * Generate a SVG string representing a square check icon.
 *
 * @return string The SVG code for a square check icon.
 */
function squareCheckSVG(): string {
	return '<svg class="square-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M211.8 339.8c-10.9 10.9-28.7 10.9-39.6 0l-64-64c-10.93-10.9-10.93-28.7 0-39.6 10.9-10.9 28.7-10.9 39.6 0l44.2 44.2 108.2-108.2c10.9-10.9 28.7-10.9 39.6 0 10.9 10.9 10.9 28.7 0 39.6l-128 128zM0 96c0-35.35 28.65-64 64-64h320c35.3 0 64 28.65 64 64v320c0 35.3-28.7 64-64 64H64c-35.35 0-64-28.7-64-64V96zm48 0v320c0 8.8 7.16 16 16 16h320c8.8 0 16-7.2 16-16V96c0-8.84-7.2-16-16-16H64c-8.84 0-16 7.16-16 16z"/></svg>';
}

/**
 * @TODO DEBUG CODE - REMOVE
 * Print an array in a formatted way.
 *
 * @param array $array The array to be printed.
 * @return void
 */
function print_array($array) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

/**
 * Get the number of posts in a specific category.
 *
 * @param int $cat_id The ID of the category.
 * @return int The number of posts in the category.
 */
function get_posts_count_by_category($cat_id): int {
	$query = new WP_Query([
		'post_type'      => 'resource',
		'posts_per_page' => -1,
		'cat'            => $cat_id
	]);

	return $query->post_count;
}

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

// Remove subcategories without corresponding posts
$subcategories = array_filter($subcategories, function ($subcategory) {
	return get_posts_count_by_category($subcategory->term_id) > 0;
});

$available_content_types = [];
foreach ($posts as $post) {
	$available_content_types[] = get_the_terms($post, "content-type")[0]->slug;
}
$available_content_types = array_unique($available_content_types);

// Initialize content_type_matrix (content type -> subcategory)
$content_type_matrix['view-all-ct'] = ['view-all-sub' => true];  // Setting 'view-all-sub' to true for 'view-all-ct'
foreach ($subcategories as $subcategory) {
	$content_type_matrix['view-all-ct'][$subcategory->slug] = false;
}
foreach ($available_content_types as $contentType) {
	$content_type_matrix[$contentType] = ['view-all-sub' => false];  // Initialize view-all-sub
	foreach ($subcategories as $subcategory) {
		$content_type_matrix[$contentType][$subcategory->slug] = false;
	}
}

// Initialize subcategory_matrix (subcategory -> content type)
$subcategory_matrix['view-all-sub'] = ['view-all-ct' => true];  // Setting 'view-all-ct' to true for 'view-all-sub'
foreach ($available_content_types as $contentType) {
	$subcategory_matrix['view-all-sub'][$contentType] = false;
}
foreach ($subcategories as $subcategory) {
	$subcategory_matrix[$subcategory->slug] = ['view-all-ct' => false];  // Initialize view-all-ct
	foreach ($available_content_types as $contentType) {
		$subcategory_matrix[$subcategory->slug][$contentType] = false;
	}
}

// Traverse each post to fill the content type matrix
foreach ($posts as $post) {
	$content_type_slug = get_the_terms($post->ID, "content-type")[0]->slug;
	$subcategories_slugs = wp_list_pluck(get_the_terms($post->ID, "category"), 'slug');

	// Ensure content type exists in matrix
	if (!isset($content_type_matrix[$content_type_slug])) {
		$content_type_matrix[$content_type_slug] = [];
	}

	// Fill in content type matrix
	foreach ($subcategories as $subcategory) {
		if (!isset($content_type_matrix[$content_type_slug][$subcategory->slug])) {
			$content_type_matrix[$content_type_slug][$subcategory->slug] = in_array($subcategory->slug, $subcategories_slugs);
		} else {
			$content_type_matrix[$content_type_slug][$subcategory->slug] = $content_type_matrix[$content_type_slug][$subcategory->slug] || in_array($subcategory->slug, $subcategories_slugs);
		}
	}
}

// Traverse each post to fill the subcategory matrix (only those present in content_type_matrix)
foreach ($posts as $post) {
	$content_type_slug = get_the_terms($post->ID, "content-type")[0]->slug;
	$subcategories_slugs = wp_list_pluck(get_the_terms($post->ID, "category"), 'slug');

	// Filter out subcategories that aren't present in content_type_matrix
	$filtered_subcategories = array_intersect($subcategories_slugs, array_keys($content_type_matrix[$content_type_slug]));

	foreach ($filtered_subcategories as $subcategory_slug) {
		if (!isset($subcategory_matrix[$subcategory_slug])) {
			$subcategory_matrix[$subcategory_slug] = [];
			// Initialize all content types with false
			foreach ($available_content_types as $type) {
				$subcategory_matrix[$subcategory_slug][$type] = false;
			}
		}

		$subcategory_matrix[$subcategory_slug][$content_type_slug] = true;
	}
}

// Check and update all values under 'view-all-ct' in $content_type_matrix
if (isset($content_type_matrix['view-all-ct'])) {
	foreach ($content_type_matrix['view-all-ct'] as $key => $value) {
		$content_type_matrix['view-all-ct'][$key] = true;
	}
}

// Check and update all values under 'view-all-sub' in $subcategory_matrix
if (isset($subcategory_matrix['view-all-sub'])) {
	foreach ($subcategory_matrix['view-all-sub'] as $key => $value) {
		$subcategory_matrix['view-all-sub'][$key] = true;
	}
}

/**
 * @TODO DEBUG CODE - REMOVE
 */
// Output matrices (for demonstration purposes)
//echo '// After matrix population' . PHP_EOL;;
//echo 'Content type matrix: ' . PHP_EOL;
//print_array($content_type_matrix);
//echo 'Subcategory matrix:' . PHP_EOL;
//print_array($subcategory_matrix);
?>
<div class="resource-browser block">
	<div class="container">
		<div class="pagination pg-desktop"></div>
	</div>
	<div class="container">
		<div class="sidebar">
			<?php if (count($available_content_types) > 0) : ?>
				<div class="sidebar-heading">Content Type</div>
			<?php endif ?>
			<div class="term-ct all-ct <?php echo empty($selected_content_types) ? "checked" : "" ?>" data-slug="view-all-ct">
				<?php echo squareSVG() . squareCheckSVG() ?> View all
			</div>

			<?php foreach (get_terms("content-type") as $content_type) : ?>
				<?php if (in_array($content_type->slug, $available_content_types, true)) : ?>
					<div class="term-ct <?php echo in_array($content_type->slug, $selected_content_types, true) ? "checked" : "" ?>" data-slug="<?php echo $content_type->slug ?>">
						<?php echo squareSVG() . squareCheckSVG() . $content_type->name ?>
					</div>
				<?php endif ?>
			<?php endforeach ?>

			<?php if (count($subcategories) > 0) : ?>
				<div class="sidebar-heading second">Category</div>
				<div class="term-sub all-sub <?php echo empty($selected_subcategories) ? "checked" : "" ?>" data-slug="view-all-sub">
					<?php echo squareSVG() . squareCheckSVG() ?> View all
				</div>
			<?php endif ?>

			<?php foreach ($subcategories as $subcategory) : ?>
				<div class="term-sub <?php echo in_array($subcategory->slug, $selected_subcategories, true) ? "checked" : "" ?>" data-slug="<?php echo $subcategory->slug ?>">
					<?php echo squareSVG() . squareCheckSVG() . $subcategory->name ?>
				</div>
			<?php endforeach ?>
		</div>

		<div class="pagination pg-mobile"></div>
		<div class="posts">
			<div class="no-results">No resources found. Please make a new selection.</div>
			<?php foreach ($posts as $post) : ?>
				<div class="post" data-content-type="<?php echo get_the_terms($post->ID, "content-type")[0]->slug ?>"
					 data-subcategories="<?php echo implode(', ', wp_list_pluck(get_the_terms($post->ID, "category"), 'slug')) ?>">
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
			let page = 1;
			const posts_per_page = 12;
			const content_type_matrix =<?php echo json_encode($content_type_matrix, JSON_THROW_ON_ERROR)?>;
			const subcategory_matrix =<?php echo json_encode($subcategory_matrix, JSON_THROW_ON_ERROR)?>;
			console.log("Content type matrix: ", content_type_matrix);
			console.log("Subcategory matrix: ", subcategory_matrix);

			/**
			 * Render the resource browser.
			 *
			 * @return {void}
			 */
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

			render();

			/**
			 *
			 * @param matrix
			 * @param selectedTerms
			 * @param allClass
			 * @param termClass
			 */
			function updateEnabledState(matrix, selectedTerms, allClass, termClass) {
				let combinedState = {};
				selectedTerms.forEach(term => {
					// console.log("Processing term: ", term);
					if (matrix[term]) {
						// console.log("Found term in matrix: ", term, matrix[term]);
						for (let [subTerm, state] of Object.entries(matrix[term])) {
							combinedState[subTerm] = combinedState[subTerm] || state;
						}
					} else {
						// console.log("Term not found in matrix: ", term);
					}
				});
				if (selectedTerms.length === 0) {
					/**
					 * Combine multiple states into a single state object.
					 *
					 * @param {Object[]} states - An array of state objects.
					 * @return {Object} - A single state object containing merged states.
					 */
					combinedState = matrix["view-all-ct"] || matrix["view-all-sub"] || {};
				}
				// console.log("Combined state: ", combinedState);
				for (let [subTerm, state] of Object.entries(combinedState)) {
					if (subTerm !== "view-all-sub" && subTerm !== "view-all-ct") {
						// console.log("Setting state for ", subTerm, " to ", state);
						let elem = $(".resource-browser .sidebar [data-slug='" + subTerm + "']");
						elem.prop('disabled', !state);
						if (!state) {
							elem.addClass('disabled').removeClass('checked');
						} else {
							elem.removeClass('disabled');
						}
					}
				}
			}

			/**
			 * Handles the click event on a term in the resource browser sidebar.
			 *
			 * @param {string} termType - The type of term being clicked.
			 * @param {string} urlParam - The URL parameter associated with the term.
			 * @param {object} opposingMatrix - The matrix of opposing terms.
			 * @param {string} opposingAllClass - The class for all opposing terms.
			 * @param {string} opposingTermClass - The class for individual opposing terms.
			 */
			function handleTermClick(termType, urlParam, opposingMatrix, opposingAllClass, opposingTermClass) {
				let allClass = `.all-${termType}`;
				let termClass = `.term-${termType}`;
				let url = new URL(window.location.href);
				let terms = url.searchParams.get(urlParam) ? url.searchParams.get(urlParam).split("_") : [];
				terms.forEach(term => {
					$(".resource-browser .sidebar .term-" + termType + "[data-slug='" + term + "']").addClass("checked");
				});
				updateEnabledState(opposingMatrix, terms, opposingAllClass, opposingTermClass);
				$(".resource-browser .sidebar").on("click", termClass, function () {
					if ($(this).hasClass("disabled")) {
						return;
					}
					let selectedTerm = $(this).data("slug");
					let index = terms.indexOf(selectedTerm);
					if ($(this).is(allClass)) {
						$(".resource-browser .sidebar " + termClass).removeClass("checked");
						$(this).addClass("checked");
						terms = [];
						url.searchParams.delete(urlParam);
					} else {
						if (index > -1) {
							$(this).removeClass("checked");
							terms.splice(index, 1);
						} else {
							$(this).addClass("checked");
							terms.push(selectedTerm);
						}
						if (terms.length > 0) {
							$(".resource-browser .sidebar " + allClass).removeClass("checked");
							url.searchParams.set(urlParam, terms.join("_"));
						} else {
							$(".resource-browser .sidebar " + allClass).addClass("checked");
							url.searchParams.delete(urlParam);
						}
					}
					window.history.replaceState(null, document.title, url.toString());
					page = 1;
					updateEnabledState(opposingMatrix, terms, opposingAllClass, opposingTermClass);
					render();
				});
			}

			handleTermClick("ct", "content_types", content_type_matrix, ".all-sub", ".term-sub");
			handleTermClick("sub", "subcategories", subcategory_matrix, ".all-ct", ".term-ct");

			ScrollReveal().delegate()
		})(jQuery);
	</script>
</div>