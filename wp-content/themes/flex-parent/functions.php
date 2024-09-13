<?php
$version = 106;

// Define an array of allowed origins for Cross-Origin Resource Sharing (CORS).
// This array includes all domains that are permitted to request resources from your server.
// This should encompass all your production, staging, and development domains.
$allowed_origins = [
	'https://cn.flex.com',
	'https://flex.com',
	'https://www.flex.com',
	'https://flex-main.lndo.site',
	'https://localhost',
	'https://dev-flex-main.pantheonsite.io',
	'https://test-flex-main.pantheonsite.io',
	'https://content-flex-main.pantheonsite.io',
	'https://ben-flex-main.pantheonsite.io',
	'https://investors.flex.com',
	'https://onelink-translations.com',
	'https://www.onelink-translations.com',
	'https://zhcn-dev-flex-redesign.onelink-translations.com',
	'https://infinex.com',
	'https://www.infinex.com',
	'https://ninfinex.lndo.site',
	'https://dev-ninfinex.pantheonsite.io',
	'https://test-ninfinex.pantheonsite.io',
	'http://flex-custom.lndo.site/'
];

// Content-Security-Policy (CSP) configuration.
// CSP helps in mitigating cross-site scripting (XSS) and data injection attacks.
$csp = "default-src 'self'; " . // Restricts all default loading sources to the same origin.
	"script-src 'self' https://www.google-analytics.com https://www.googletagmanager.com https://cdnjs.cloudflare.com; " . // Specifies allowed sources for JavaScript.
	"style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " . // Specifies allowed sources for stylesheets.
	"img-src 'self' https://www.google-analytics.com; " . // Specifies allowed sources for images.
	"upgrade-insecure-requests;"; // Instructs browsers to treat all of a site's insecure URLs as though they have been replaced with secure URLs.

// Check if the Origin header is present in the HTTP request and if it matches the list of allowed origins.
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
	// If a match is found, set the Access-Control-Allow-Origin header to allow CORS from the requesting origin.
	header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
}

// Send the constructed Content-Security-Policy header.
// Disabled for now while CSP reports are being generated.
// header("Content-Security-Policy: $csp");

// Content-Security-Policy-Report-Only header.
// This header is used to gather reports on potential CSP violations, but it does not block them.
// It's useful for testing a new policy or changes to an existing policy.
header("Content-Security-Policy-Report-Only: $csp");

// X-Content-Type-Options header.
// Prevents browsers from MIME-sniffing the response away from the declared content-type.
// This reduces the risk of drive-by download attacks.
header('X-Content-Type-Options: nosniff');

// Access-Control-Allow-Methods header.
// Specifies the methods allowed when accessing the resource in response to a preflight request.
header('Access-Control-Allow-Methods: GET, POST, PUT');

// Access-Control-Allow-Headers header.
// Indicates which headers can be used during the actual request.
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

//====================================================================================================
// Additional Theme Support and Functions
//====================================================================================================

/**
 * Check if a given CDN link is accessible.
 *
 * @param string $link The CDN link to check.
 * @return bool Whether the CDN link is accessible or not.
 */
function flex_parent_check_cdn($link): bool {
	return ( bool )@fopen($link, 'r');
}

// Enqueue front-end assets
add_action("wp_enqueue_scripts", "flex_parent_enqueue_assets");
/**
 * Enqueues the necessary assets for the theme.
 *
 * @return void
 */
function flex_parent_enqueue_assets() {
	global $version;
	// Styles
	wp_enqueue_style("fonts", get_stylesheet_directory_uri() . "/styles/build/fonts.css", null, $version);
	wp_enqueue_style("main", get_stylesheet_directory_uri() . "/styles/build/main.css", ["fonts"], $version);
	wp_enqueue_style("admin", get_stylesheet_directory_uri() . "/styles/build/admin.css", null, $version);

	// Scripts
	$scrollrevealCheckCDN = flex_parent_check_cdn('https://cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/4.0.9/scrollreveal.min.js');
	if ($scrollrevealCheckCDN) {
		wp_register_script('scrollreveal', 'https://cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/4.0.9/scrollreveal.min.js', null, null, true);
		wp_enqueue_script('scrollreveal');
	} else {
		wp_enqueue_script("scrollreveal", get_stylesheet_directory_uri() . "/scripts/scrollreveal.js", [], $version, true);
	}

	$jscookieflexCheckCDN = flex_parent_check_cdn('https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js');
	if ($jscookieflexCheckCDN) {
		wp_register_script('js-cookie', 'https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js', null, null, true);
		wp_enqueue_script('js-cookie');
	} else {
		wp_enqueue_script("js-cookie", get_stylesheet_directory_uri() . "/scripts/build/js-cookie.js", [], $version, true);
	}
	wp_enqueue_script("navigation", get_stylesheet_directory_uri() . "/scripts/build/navigation.js", ["jquery"], $version, true);
	wp_enqueue_script("global", get_stylesheet_directory_uri() . "/scripts/build/global.js", ["jquery", "js-cookie"], $version, true);
}

// Enqueue back-end admin assets
add_action("admin_enqueue_scripts", "flex_parent_enqueue_admin_assets");

/**
 * Enqueue admin assets.
 *
 * Enqueues the necessary stylesheet and scripts for the admin area.
 *
 * @return void
 * @global string $version
 */
function flex_parent_enqueue_admin_assets() {
	global $version;
	// Styles
	wp_enqueue_style("admin", get_stylesheet_directory_uri() . "/styles/build/admin.css", null, $version);
	// Scripts
	$scrollrevealCheckCDN = flex_parent_check_cdn('https://cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/4.0.9/scrollreveal.min.js');
	if ($scrollrevealCheckCDN) {
		wp_register_script('scrollreveal', 'https://cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/4.0.9/scrollreveal.min.js', null, null, true);
		wp_enqueue_script('scrollreveal');
	} else {
		wp_enqueue_script("scrollreveal", get_stylesheet_directory_uri() . "/scripts/scrollreveal.js", [], $version, true);
	}
}

// Enqueue back-end editor assets
add_action("enqueue_block_editor_assets", "flex_parent_enqueue_editor_assets");
/**
 * Enqueues the editor assets.
 *
 * @return void
 * @global string $version The current version.
 *
 */
function flex_parent_enqueue_editor_assets() {
	global $version;
	// Scripts
	wp_enqueue_script("admin", get_stylesheet_directory_uri() . "/scripts/build/editor.js", [], $version, true);
}

// Use front-end styles in the editor
add_theme_support("editor-styles");
add_editor_style("styles/build/editor.css");

//====================================================================================================
// Images
//====================================================================================================

// Add custom image sizes
add_action("after_setup_theme", "flex_parent_add_custom_image_sizes");
/**
 * Adds custom image sizes.
 *
 * @return void
 */
function flex_parent_add_custom_image_sizes() {
	// 1:1
	add_image_size("336x336", 336, 336, true);
	// 3:2
	add_image_size("564x376", 564, 376, true);
	add_image_size("768x512", 768, 512, true);
	add_image_size("1176x784", 1176, 784, true);
	// 16:9
	add_image_size("540x304", 540, 304, true);
	add_image_size("760x428", 760, 428, true);
	// Uncropped
	add_image_size("1200x9999", 1200, 9999, false);
}

// Disable automatic rescaling of uploaded images
add_filter("big_image_size_threshold", "__return_false");

// Set JPEG compression quality
add_filter("jpeg_quality", "flex_parent_custom_jpeg_quality");
/**
 * Sets the quality of custom JPEG images.
 *
 * @param int $quality The quality of the custom JPEG image. Must be between 0 and 100.
 * @return int The JPEG quality value that has been set.
 */
function flex_parent_custom_jpeg_quality($quality) {
	return 80;
}

//====================================================================================================
// Post Types
//====================================================================================================

/**
 * Register a custom post type for 'downloads'.
 */
register_post_type("download",
	[
		"menu_icon"    => "dashicons-download", // Set a custom menu icon for the 'downloads' post type in the WordPress admin menu.

		// Define labels for the 'downloads' post type.
		"labels"       => [
			"name"                  => "Downloads",
			"singular_name"         => "Download",
			"add_new_item"          => "Add New Download",
			"edit_item"             => "Edit Download",
			"new_item"              => "New Downloads",
			"view_item"             => "View Download",
			"view_items"            => "View Downloads",
			"search_items"          => "Search Downloads",
			"not_found"             => "No downloads found",
			"not_found_in_trash"    => "No downloads found in Trash",
			"all_items"             => "All Downloads",
			"archives"              => "Download Archives",
			"attributes"            => "Download Attributes",
			"insert_into_item"      => "Insert into download",
			"uploaded_to_this_item" => "Uploaded to this download"
		],
		"public"       => true, // Make the 'downloads' post type publicly accessible.
		"show_in_rest" => true, // Enable support for the WordPress REST API.
		"supports"     => ["title", "revisions"], // Specify the supported features for the 'downloads' post type.
		"taxonomies"   => ["category"], // Associate the 'downloads' post type with the 'category' taxonomy.
		"has_archive"  => false, // Disable archive page for the 'downloads' post type.
		"rewrite"      => ["slug" => "downloads"] // Define custom URL structure by setting the slug to "downloads".
	]
);

/**
 * Register a custom post type for 'news'.
 */
register_post_type("news",
	[
		"menu_icon"    => "dashicons-megaphone", // Set a custom menu icon for the 'news' post type in the WordPress admin menu.

		// Define labels for the 'news' post type.
		"labels"       => [
			"name"                  => "News",
			"singular_name"         => "News",
			"add_new_item"          => "Add News",
			"edit_item"             => "Edit News",
			"new_item"              => "New News",
			"view_item"             => "View News",
			"view_items"            => "View News",
			"search_items"          => "Search News",
			"not_found"             => "No news found",
			"not_found_in_trash"    => "No news found in Trash",
			"all_items"             => "All News",
			"archives"              => "News Archives",
			"attributes"            => "News Attributes",
			"insert_into_item"      => "Insert into news",
			"uploaded_to_this_item" => "Uploaded to this news"
		],
		"public"       => true, // Make the 'news' post type publicly accessible.
		"show_in_rest" => true, // Enable support for the WordPress REST API.
		"supports"     => ["title", "revisions"], // Specify the supported features for the 'news' post type.
		"taxonomies"   => ["category"], // Associate the 'news' post type with the 'category' taxonomy.
		"has_archive"  => false // Disable archive page for the 'news' post type.
	]
);

/**
 * Register a custom post type for 'resource'.
 */
register_post_type("resource",
	[
		"menu_icon" => "dashicons-media-document", // Set a custom menu icon for the 'resource' post type in the WordPress admin menu.

		// Labels for the 'resource' post type.
		"labels" => [
			"name" => "Resources",
			"singular_name" => "Resource",
			"add_new_item" => "Add New Resource",
			"edit_item" => "Edit Resource",
			"new_item" => "New Resources",
			"view_item" => "View Resource",
			"view_items" => "View Resources",
			"search_items" => "Search Resources",
			"not_found" => "No resources found",
			"not_found_in_trash" => "No resources found in Trash",
			"all_items" => "All Resources",
			"archives" => "Resource Archives",
			"attributes" => "Resource Attributes",
			"insert_into_item" => "Insert into resource",
			"uploaded_to_this_item" => "Uploaded to this resource"
		],

		"public" => true, // Make the 'resource' post type publicly accessible.
		"show_in_rest" => true, // Enable support for the WordPress REST API.
		"supports" => ["title", "editor", "author", "thumbnail", "revisions"], // Specify the supported features for the 'resource' post type.
		"has_archive" => false, // Disable archive page for the 'resource' post type.
		"taxonomies" => ["category", "post_tag"], // Associate the 'resource' post type with taxonomies.
		"rewrite" => ["slug" => "resources"] // Define custom URL structure by setting the slug to "resources".
	]
);


//====================================================================================================
// Taxonomies
//====================================================================================================

add_action("init", "flex_parent_register_category_resource");
/**
 * Registers the "category" taxonomy for the "resource" custom post type.
 *
 * @return void
 */
function flex_parent_register_category_resource() {
	register_taxonomy_for_object_type("category", "resource");
}

add_action("init", "flex_parent_register_category_download");
/**
 * Registers the category taxonomy for the download post type.
 *
 * @return void
 */
function flex_parent_register_category_download() {
	register_taxonomy_for_object_type("category", "download");
}

add_action("init", "flex_parent_register_category_news");
/**
 * Registers the "category" taxonomy for the "news" object type.
 *
 * @return void
 */
function flex_parent_register_category_news() {
	register_taxonomy_for_object_type("category", "news");
}

add_action("init", "flex_parent_register_category_page");
/**
 * Register the page object type for the category taxonomy.
 *
 * @return void
 */
function flex_parent_register_category_page() {
	register_taxonomy_for_object_type("category", "page");
}

add_action("init", "flex_parent_register_tag_resource");
/**
 * Register the "post_tag" taxonomy for the "resource" object type.
 *
 * @return void
 */
function flex_parent_register_tag_resource() {
	register_taxonomy_for_object_type("post_tag", "resource");
}

add_action("init", "flex_parent_create_custom_taxonomies");
/**
 * Creates custom taxonomies.
 *
 * @return void
 */
function flex_parent_create_custom_taxonomies() {
	// Content Type
	register_taxonomy("content-type", ["resource"], [
		"labels"       => [
			"name"              => "Content Types",
			"singular_name"     => "Content Type",
			"search_items"      => "Search Content Types",
			"all_items"         => "All Content Types",
			"parent_item"       => "Parent Content Type",
			"parent_item_colon" => "Parent Content Type:",
			"edit_item"         => "Edit Content Type",
			"update_item"       => "Update Content Type",
			"add_new_item"      => "Add New Content Type",
			"new_item_name"     => "New Content Type Name",
			"menu_name"         => "Content Types"
		],
		"hierarchical" => true,
		"show_in_rest" => true,
		"public"       => true
	]);
}

//====================================================================================================
// Blocks
//====================================================================================================

// Allow only supported block types
add_filter("allowed_block_types_all", "flex_parent_define_allowed_block_types");
/**
 * Defines the allowed block types.
 *
 * @return array The array of allowed block types.
 */
function flex_parent_define_allowed_block_types() {
	return [
		"acf/banner",
		"acf/box",
		"acf/button",
		"acf/code",
		"acf/column",
		"acf/columns",
		"acf/header",
		"acf/homepage-carousel",
		"acf/leadership",
		"acf/line",
		"acf/media",
		"acf/news",
		"acf/press-releases",
		"acf/quadrant",
		"acf/quote",
		"acf/resource-archive",
		"acf/resource-browser",
		"acf/resource-header",
		"acf/resource-selector",
		"acf/resources",
		"acf/sidebar",
		"acf/spacer",
		"acf/tab",
		"acf/tabs",
		"acf/tiles",
		"acf/timeline",
		"acf/twitter",
		"component-selector/component-selector",
		"core/heading",
		"core/list",
		"core/list-item",
		"core/table",
		"core/paragraph"
	];
}

// Disable unneeded functionality
remove_theme_support("block-templates");
remove_theme_support("core-block-patterns");

//====================================================================================================
// Custom WYSIWYG Toolbar
//====================================================================================================

// Customize the toolbar options
add_filter("tiny_mce_before_init", "flex_parent_customize_tinymce_toolbar_options");
/**
 * Customize the toolbar options for TinyMCE.
 *
 * @param array $options The current toolbar options.
 * @return array The updated toolbar options.
 */
function flex_parent_customize_tinymce_toolbar_options($options) {
	$options["block_formats"] = "Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4";
	return $options;
}

// Create the minimal toolbar
add_filter("acf/fields/wysiwyg/toolbars", "flex_parent_create_minimal_toolbar");
/**
 * Creates a minimal toolbar.
 *
 * @param array $toolbars The existing toolbars.
 * @return array The modified toolbars with the minimal toolbar added.
 */
function flex_parent_create_minimal_toolbar($toolbars) {
	$toolbars["Minimal"] = [];
	$toolbars["Minimal"][1] = ["bold", "italic", "link"];
	return $toolbars;
}

//====================================================================================================
// Menus
//====================================================================================================

// Register navigation menus
add_action("init", "flex_parent_register_menus");
/**
 * Registers the menus for the theme.
 *
 * @return void
 */
function flex_parent_register_menus() {
	register_nav_menu("main", "Main");
	register_nav_menu("companies", "Companies");
	register_nav_menu("languages", "Languages");
}

// Add an options page
acf_add_options_page();

//====================================================================================================
// Typography
//====================================================================================================

/**
 * Removes the last word from a given text if the text contains at least 3 words.
 *
 * @param string $text The input text to remove the orphans from.
 * @return string The modified text after removing the orphan word(s).
 */
function flex_parent_remove_orphans($text) {
	$output = $text;
	$words = explode(" ", $text);
	if (count($words) >= 3) {
		$words[count($words) - 2] .= "&nbsp;" . $words[count($words) - 1];
		array_pop($words);
		$output = implode(" ", $words);
	}
	return $output;
}

//====================================================================================================
// SEO
//====================================================================================================
add_filter("wpseo_robots", "flex_parent_customize_robots_meta");
/**
 * Customize the robots meta tag value based on the current post's language.
 *
 * @param string $robots The value of the robots meta tag.
 * @return string The updated value of the robots meta tag.
 */
function flex_parent_customize_robots_meta($robots) {
	global $post;
	$current_language = substr(get_locale(), 0, 2);
	$supported_languages = get_field("languages", $post->ID) ?? ["en"];
	// If the current post supports the current language
	if (in_array($current_language, $supported_languages)) {
		return $robots;
	} else {
		return "noindex, nofollow";
	}
}

//====================================================================================================
// Yoast
//====================================================================================================
// UNCOMMENT WHEN SWITCHING TO REDIRECTION PLUGIN
/**
 * Remove the 'wpseo_redirects' submenu page from the 'wpseo_dashboard' parent menu.
 *
 * @return void
 */
function flex_parent_remove_redirects_submenu_page() {
	remove_submenu_page('wpseo_dashboard', 'wpseo_redirects');
}

add_action('admin_menu', 'flex_parent_remove_redirects_submenu_page');

// Disable automatic redirects
add_filter("Yoast\WP\SEO\post_redirect_slug_change", "__return_true");
add_filter("Yoast\WP\SEO\term_redirect_slug_change", "__return_true");
add_filter('Yoast\WP\SEO\enable_notification_post_trash', '__return_false');
add_filter('Yoast\WP\SEO\enable_notification_post_slug_change', '__return_false');
add_filter('Yoast\WP\SEO\enable_notification_term_delete', '__return_false');
add_filter('Yoast\WP\SEO\enable_notification_term_slug_change', '__return_false');

//====================================================================================================
// Yoast - Featured Images
//====================================================================================================

add_theme_support('post-thumbnails', array(
	'post',
	'page',
	'resource',
));

//====================================================================================================
// SearchWP XPDF Integration
//====================================================================================================

/**
 * Returns the path to the xpdf executable "pdftotext".
 *
 * @return string The path to the xpdf executable.
 */
function flex_parent_searchwp_xpdf(): string {
	return '/code/xpdf/pdftotext';
}

add_filter('searchwp_xpdf_path', 'flex_parent_searchwp_xpdf');

/**
 * Sets the number of posts per page for search queries in the main query of the WordPress site.
 *
 * This function checks if the provided query object is a search query, the main query, and if the user is not in the admin area.
 * If all these conditions are met, the function sets the 'posts_per_page' parameter of the query to 10.
 *
 * @param WP_Query $query The query object to modify.
 *
 * @return void
 */
function flex_parent_search_posts_per_page($query) {
	if ($query->is_search() && $query->is_main_query() && !is_admin()) {
		$query->set('posts_per_page', '10');
	}
}

add_filter('pre_get_posts', 'flex_parent_search_posts_per_page');

/**
 * Modifies the main query object for search queries on the website.
 *
 * This function checks if the user is not in the admin area and if the provided query object is the main query.
 * If these conditions are met, the function further checks if the query object represents a search query.
 * If it does, the function sets the 'paged' parameter of the query to the value of the 'paged' query variable (or 1 if it is not set),
 * and sets the 'posts_per_page' parameter of the query to 10.
 *
 * @param WP_Query $query The query object to modify.
 *
 * @return void
 */
function flex_parent_search_filter($query) {
	if (!is_admin() && $query->is_main_query()) {
		if ($query->is_search) {
			$query->set('paged', (get_query_var('paged')) ? get_query_var('paged') : 1);
			$query->set('posts_per_page', 10);
		}
	}
}

add_action('pre_get_search', 'flex_parent_search_filter');

