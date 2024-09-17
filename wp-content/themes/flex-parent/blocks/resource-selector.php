<?php

$categories = [];

/**
 * Get all Level 1 categories
 */
foreach (get_terms(["taxonomy" => "category", 'exclude' => [85], "parent" => 0, "meta_key" => "order", "orderby" => "meta_value_num"]) as $category) {
	$category->children = [];
	$categories[$category->term_id] = $category;
}

/**
 * Get all Level 2 categories (Industries)
 */
foreach (get_terms(["taxonomy" => "category", 'exclude' => [85], "meta_key" => "order", "orderby" => "meta_value_num"]) as $category) {
	if (!empty($categories[$category->parent])) {
		$categories[$category->parent]->children[] = $category;
	}
}

/**
 * Get all content types
 */
$content_types = get_terms("content-type");

/**
 * Get the current language code
 */
global $TRP_LANGUAGE;
$current_language = substr($TRP_LANGUAGE,0,2);
?>
<div class="resource-selector block">
	<div class="container">
		<div class="columns">
			<div class="level-1-category column">
				<div class="step">Step 1</div>
				<div class="instruction">Select category:</div>
				<div class="terms">
					<?php foreach ($categories as $category) : ?>
						<div class="term" data-id="<?php echo $category->term_id ?>">
							<?php echo $category->name ?>
						</div>
					<?php endforeach ?>
				</div>
			</div>
			<div class="level-2-category column">
				<div class="step">Step 2</div>
				<div class="instruction">Select topic:</div>
				<div class="terms">
					<?php foreach ($categories as $category) : ?>
						<?php if (!empty($category->children)) : ?>
							<?php foreach ($category->children as $child) : ?>
								<div class="term" data-id="<?php echo $child->term_id ?>" data-parent="<?php echo $child->parent ?>" data-content-types="<?php echo implode(",", get_field("content_types", $child)) ?>"
									 data-destination="<?php the_field("destination", $child) ?>">
									<?php echo $child->name ?>
								</div>
							<?php endforeach ?>
						<?php endif ?>
					<?php endforeach ?>
				</div>
			</div>
			<div class="content-type column">
				<div class="step">Step 3</div>
				<div class="instruction">Select content type for results:</div>
				<div class="terms">
					<div class="term">
						View all
						<div class="long-arrow">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.9 9.9" xml:space="preserve">
								<polygon points="15.5,0 14.5,0.9 17.4,4.3 0,4.3 0,5.7 17.4,5.7 14.5,9 15.5,9.9 19.9,5 "/>
							</svg>
							<div class="line"></div>
						</div>
					</div>
					<?php foreach ($content_types as $content_type) : ?>
						<div class="term" data-id="<?php echo $content_type->term_id ?>" data-slug="<?php echo $content_type->slug ?>">
							<?php echo $content_type->name ?>
							<div class="long-arrow">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.9 9.9" xml:space="preserve">
								<polygon points="15.5,0 14.5,0.9 17.4,4.3 0,4.3 0,5.7 17.4,5.7 14.5,9 15.5,9.9 19.9,5 "/>
							</svg>
								<div class="line"></div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
	<script>
		(function ($) {
			/**
			 * Handle clicks on level 1 categories
			 */
			$(".resource-selector.block .level-1-category .term").on("click", function () {
				// Deselect all level 1 categories
				$(".resource-selector.block .level-1-category .term").removeClass("selected");
				// Select the current level 1 category
				$(this).addClass("selected");
				// Deselect and hide all level 2 categories
				$(".resource-selector.block .level-2-category .term").removeClass("selected").hide();
				// Show only corresponding level 2 categories
				$(".resource-selector.block .level-2-category .term[data-parent=" + $(this).data("id") + "]").show();
				// Trigger a click on the first level 2 category
				$(".resource-selector.block .level-2-category .term:visible").first().trigger("click");
			})

			/**
			 * Handle clicks on level 2 categories
			 */
			$(".resource-selector.block .level-2-category .term").on("click", function () {
				// Deselect all level 2 categories
				$(".resource-selector.block .level-2-category .term").removeClass("selected");
				// Select the current level 2 category
				$(this).addClass("selected");
				// Hide all content types
				$(".resource-selector.block .content-type .term:not(:first-child)").hide();
				// Show only corresponding content types
				for (let id of $(this).data("content-types").toString().split(",")) {
					$(".resource-selector.block .content-type .term[data-id=" + id + "]").show();
				}
			})

			// ORIGINAL - Handle clicks on content types
			// $(".resource-selector.block .content-type .term").on("click", function () {
			// 	var url = new URL($(".resource-selector.block .level-2-category .term.selected").data("destination"), window.location.origin);
			// 	if ($(this).data("slug")) {
			// 		url.searchParams.append("content_types", $(this).data("slug"));
			// 	}
			// 	window.location.href = url.toString();
			// });

			/**
			 * Handle clicks on content types
			 */
			$(".resource-selector.block .content-type .term").on("click", function () {
				// Get the base URL from the selected level-2 category
				var baseUrl = $(".resource-selector.block .level-2-category .term.selected").data("destination");
				var currentUrl = new URL(window.location.href);
				var currentPath = currentUrl.pathname;

				// Check if the current URL contains a language code
				var langCode = currentPath.split('/')[1];
				var knownLangCodes = ['<?php echo $current_language?>']; // Add more language codes as necessary
				if (knownLangCodes.includes(langCode)) {
					// Prepend the language code to the base URL
					baseUrl = '/' + langCode + baseUrl;
				}

				// Construct the full URL
				var url = new URL(baseUrl, window.location.origin);
				if ($(this).data("slug")) {
					url.searchParams.append("content_types", $(this).data("slug"));
				}
				window.location.href = url.toString();
			});

			// Select the first level 1 category on load
			$(".resource-selector.block .level-1-category .term").first().trigger("click");
		})(jQuery);
	</script>
</div>