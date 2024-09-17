<div class="tabs block">
	<div class="container">
		<div class="spacer"></div>
		<div class="tabs-container">
			<div class="tabs"></div>
		</div>
		<div class="content">
			<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode(["acf/tab"])) ?>"/>
		</div>
	</div>
	<script>
		/**
		 * Renders tabs based on the hash in the URL and tab content. This function is specifically designed to support
		 * WordPress editor adjustments and dynamic navigation updates. It is structured to work within the WordPress
		 * editing environment and updates both the navigation tabs and the content tabs based on the URL's hash.
		 *
		 * NOTE: This function is only used in the WordPress editor and for some reason yet to be determined must sit
		 * outside the self-invoking function.
		 */
		var render_tabs = function () {
			var $ = jQuery; // Use the jQuery global object for easier usage throughout the function.

			var $tabsBlock   = $(".tabs.block"); // Select the main block element that contains tabs and their respective navigation and content.
			var $navTabs     = $tabsBlock.find(".tabs");  // Selects the navigation container within the tabs block.
			var $contentTabs = $tabsBlock.find(".content .tab");  // Selects the content of each tab within the block.

			var currentHash   = window.location.hash.replace("#", ""); // Obtain the current URL hash (without the '#' symbol) for determining the active tab.
			var hash_selector = currentHash ? $(".tab.block[data-slug='" + currentHash + "']") : null; // If there's a hash, find the tab corresponding to this hash, otherwise set to null.

			// If the WordPress block editor is in use, adjust the hash selector to point to the parent `.wp-block`.
			if (window.wp && window.wp.blocks && hash_selector) {
				hash_selector = hash_selector.parents(".wp-block");
			}

			// Default active tab index. It will be used to mark one of the tabs as active.
			var active_index = 0;
			// If a tab corresponding to the hash was found, set its index as the active tab index.
			if (hash_selector && hash_selector.length) {
				active_index = hash_selector.index();
			}

			// Build the HTML for each tab. This array will store HTML strings for all tabs.
			var tabsHtml = [];
			$contentTabs.each(function (index) {
				var $this    = $(this);
				var isActive = index === active_index; // Check if the current tab should be active based on its index.
				tabsHtml.push('<div class="tab' + (isActive ? ' active' : '') + '">' + $this.data("label") + '</div>'); // Append the HTML string for the tab to the tabsHtml array.
			});

			// Empty the navigation container and then add all tabs HTML to it.
			// This is done in one operation to improve performance.
			$navTabs.empty().html(tabsHtml.join(""));
			$contentTabs.hide().eq(active_index).show(); // Hide all content tabs, then only show the content for the active tab.

			// Set up a click event handler on each tab in the navigation.
			// First, remove any existing click handlers to prevent duplicate bindings.
			$navTabs.off("click").on("click", ".tab", function () {
				var index = $(this).index();  // Get the index of the clicked tab.
				// Set a local storage item to control scrolling behavior on hash change, then update the URL hash.
				window.localStorage.setItem("scroll_on_hash_change", "false");
				window.location.hash = $contentTabs.eq(index).data("slug");
			});
		};

		/**
		 * Self-invoking function to encapsulate and run the script when the DOM is ready.
		 * This pattern helps in avoiding global scope pollution and conflicts with other scripts.
		 */
		(function ($) {
			$(document).ready(function () {
				var isEditor     = document.body.classList.contains('block-editor-page') || !!window.wp?.blocks; // Determine if the current page is the WordPress editor page, which affects how tabs are rendered.
				var $tabsBlock   = $(".tabs.block"); // Select the main container of the tabs. This is the primary block where all tabs and their content are contained.
				var $contentTabs = $tabsBlock.find(".content .tab"); // Find all content elements of the tabs. These are the contents that will be shown/hidden based on active tab.
				var $navTabs     = $tabsBlock.find(".tabs"); // Locate the container of the tab navigation buttons/links.

				/**
				 * Initializes the tab structure on the frontend (not in the WordPress editor).
				 * This function creates navigation tabs corresponding to each content tab and sets up their click handlers.
				 */
				var init_frontend_tabs = function () {
					$contentTabs.each(function (index) {
						// Create a div for each tab in the navigation, using the 'label' data attribute for its text.
						var $tab = $("<div>").addClass("tab").html($(this).data("label"));
						$navTabs.append($tab); // Append this new navigation tab to the tabs container.

						// Attach click event handler to each navigation tab.
						$tab.on("click", function () {
							// On click, update the URL hash to reflect the clicked tab and prevent auto-scrolling.
							window.localStorage.setItem("scroll_on_hash_change", "false");
							window.location.hash = $contentTabs.eq(index).data("slug");
						});
					});
				};

				/**
				 * Sets the active tab based on the URL hash, or defaults to the first tab if no hash is present.
				 * This function updates the appearance and visibility of tabs and their contents accordingly.
				 */
				var set_active_frontend_tab = function () {
					var $navTabsActive = $tabsBlock.find(".tabs div.tab"); // Select all navigation tabs.
					var activeIndex    = 0; // Default to the first tab if no specific hash is found.

					// If the URL has a hash, find the corresponding tab and set it as active.
					if (window.location.hash) {
						var hash          = window.location.hash.replace("#", ""); // Remove '#' from the hash.
						var $hashSelector = $tabsBlock.find(".tab.block[data-slug='" + hash + "']"); // Find the tab content that matches the hash.

						// If a matching content tab is found, update the activeIndex to match its position.
						if ($hashSelector.length > 0) {
							activeIndex = $hashSelector.index();
						}
					}

					// Set the active class on the appropriate navigation tab and display the corresponding tab content.
					$navTabsActive.removeClass("active").eq(activeIndex).addClass("active");
					$contentTabs.hide().eq(activeIndex).show();
				};

				// If the current context is not the editor, initialize and set active tabs for the frontend.
				if (!isEditor) {
					init_frontend_tabs();
					set_active_frontend_tab();
					// Trigger any scroll animations or reveals for the newly displayed tabs.
					setTimeout(() => ScrollReveal().delegate(), 100);
				} else {
					// In the WordPress editor, call a separate function to render tabs.
					render_tabs();
				}

				// Event listener to handle changes in the URL hash (when a user clicks a tab).
				window.addEventListener("hashchange", function () {
					// Reset active tabs on hash change, differentiating between frontend and editor.
					if (!isEditor) {
						set_active_frontend_tab();
						setTimeout(() => ScrollReveal().delegate(), 100);
					} else {
						render_tabs();
					}

					// Scroll adjustment to ensure the content is properly aligned after a tab change.
					var $containerContent = $(".tabs.block > .container .content");
					var offsetTop         = $containerContent.offset().top - $('#flex-header').height() - $(".tabs.block > .container .tabs-container").height() - 68;
					// Animate the scroll to the calculated position for a smooth transition.
					$([document.documentElement, document.body]).animate({scrollTop: offsetTop}, 500);
				});
			});
		})(jQuery); // Pass jQuery as an argument to ensure no conflict in jQuery usage.
	</script>
</div>