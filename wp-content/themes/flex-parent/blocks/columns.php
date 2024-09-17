<?php

$alignment = get_field("alignment") ? get_field("alignment") : "align-top";
$gutter_width = get_field("gutter_width") ? get_field("gutter_width") : 36;
$mobile_break_point = get_field("mobile_break_point") ? get_field("mobile_break_point") : 1272;
$max_column_width = get_field("max_column_width") ? get_field("max_column_width") : 600;
$mobile_space_between_columns = get_field("mobile_space_between_columns") ? get_field("mobile_space_between_columns") : 36;
$rule_color = get_field("rule_color") ? get_field("rule_color") : "#262626";
$rule_opacity = get_field("rule_opacity") ? (get_field("rule_opacity")/100) : 0.2;

if ($rule_color == "#ffffff") {
	$rule_color_rgba = "255, 255, 255,";
} else if ($rule_color == "#eaeef4") {
	$rule_color_rgba = "234, 238, 244,";
} else if ($rule_color == "#262626") {
	$rule_color_rgba = "38, 38, 38,";
} else if ($rule_color == "#ba257d") {
	$rule_color_rgba = "186, 37, 125,";
} else if ($rule_color == "#7f1e5e") {
	$rule_color_rgba = "127, 30, 94,";
} else if ($rule_color == "#f1b52c") {
	$rule_color_rgba = "241, 181, 44,";
} else if ($rule_color == "#ce6d28") {
	$rule_color_rgba = "206, 109, 40,";
} else if ($rule_color == "#82bc00") {
	$rule_color_rgba = "130, 188, 0,";
} else if ($rule_color == "#006432") {
	$rule_color_rgba = "0, 100, 50,";
} else if ($rule_color == "#009add") {
	$rule_color_rgba = "0, 154, 221,";
} else if ($rule_color == "#005486") {
	$rule_color_rgba = "0, 84, 134,";
}

$classes = [$alignment];

if (get_field("show_rules")) {
	$classes[] = "show-rules";
}

$block_id = uniqid('id-');

?>
<div id="<?php echo $block_id ?>" class="columns block">
	<style>
		#<?php echo $block_id ?> .column, #<?php echo $block_id ?> .wp-block-acf-column {
			padding: 0 <?php echo $gutter_width / 2 ?>px;
		}
		
		#<?php echo $block_id ?> > .container.show-rules .column+.column, #<?php echo $block_id ?> > .container.show-rules .wp-block-acf-column+.wp-block-acf-column {
			border-color: rgba(<?php echo $rule_color_rgba ?> <?php echo $rule_opacity ?>);
		}
		
		@media (max-width: <?php echo $mobile_break_point ?>px) {
			#<?php echo $block_id ?> > .container {
				display: block;
				max-width: <?php echo $max_column_width ?>px;
			}
		}
		@media (max-width: <?php echo $mobile_break_point ?>px) {
			#<?php echo $block_id ?> > .container > .column, #<?php echo $block_id ?> > .container > .wp-block-acf-column {
				padding: <?php echo $mobile_space_between_columns ?>px 0 0 0 !important;
			}
		}
		@media (max-width: <?php echo $mobile_break_point ?>px) {
			#<?php echo $block_id ?> > .container > .column:first-child, #<?php echo $block_id ?> > .container > .wp-block-acf-column:first-child {
				padding: 0 !important;
			}
		}
		@media (max-width: <?php echo $mobile_break_point ?>px) {
			#<?php echo $block_id ?> > .container.show-rules .column+.column, #<?php echo $block_id ?> > .container.show-rules .wp-block-acf-column+.wp-block-acf-column {
				border-left: none;
				border-top: 1px solid rgba(<?php echo $rule_color_rgba ?> <?php echo $rule_opacity ?>);
				padding: 30px 0 0 0 !important;
				margin-top: 30px;
			}
		}
	</style>
	<div class="container <?php echo implode(" ", $classes) ?>">
		<InnerBlocks allowedBlocks="<?php echo esc_attr(wp_json_encode(["acf/column"])) ?>" />
	</div>
</div>