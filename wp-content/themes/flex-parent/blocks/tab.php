<?php
$language = substr(get_locale(), 0, 2);
$visibility = get_field("visibility");
?>
<?php if (empty($visibility) || in_array($language, $visibility)) : ?>
	<?php
	if (function_exists('trp_translate')) {
		$label = strip_tags(trp_translate(get_field("label")));
	} else {
		$label = get_field("label");
	}
	?>
	<div class="tab block" data-slug="<?php echo get_field("slug") ?>" data-label="<?php echo $label ?>">
		<div class="container">
			<InnerBlocks/>
		</div>
	</div>
<?php endif ?>