$ = jQuery;

$("body").removeClass("wp-core-ui");

// Restrict child blocks
wp.hooks.addFilter("blocks.registerBlockType", "dillpixel",	assign_parent);
function assign_parent(settings, name) {
	switch (name) {
		case "acf/column":
			return Object.assign(settings, {parent: ["acf/columns"]});
		case "acf/scroller-slide":
			return Object.assign(settings, {parent: ["acf/scroller"]});
		case "acf/tab":
			return Object.assign(settings, {parent: ["acf/tabs"]});
		default:
			return settings
	}
}

// Remove options from the formatting toolbar
wp.richText.unregisterFormatType("core/code");
wp.richText.unregisterFormatType("core/image");
wp.richText.unregisterFormatType("core/strikethrough");
wp.richText.unregisterFormatType("core/underline");
wp.richText.unregisterFormatType("core/text-color");
wp.richText.unregisterFormatType("core/subscript");
wp.richText.unregisterFormatType("core/superscript");
wp.richText.unregisterFormatType("core/keyboard");

// Update tabs when the content changes
wp.data.subscribe(function () {
	// Dirty hack due to how this has been architected.
	if (
		wp.data.select("core/editor").hasChangedContent() ||
		!wp.data.select("core/editor").isSavingPost() ||
		!wp.data.select("core/editor").isAutosavingPost()
		) {
		if (window.render_tabs) {
			window.render_tabs();
		}
	}
});
