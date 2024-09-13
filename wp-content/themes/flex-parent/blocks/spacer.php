<?php

$rule_color = get_field("rule_color") ? get_field("rule_color") : "transparent";
$rule_opacity = get_field("rule_opacity") ? get_field("rule_opacity") / 100 : 1;

?>
<div class="spacer block" style="height: <?php echo get_field("height") ?>px;">
	<?php if (get_field("show_rule")) : ?>
	<div class="rule" style="background-color: <?php echo $rule_color ?>; opacity: <?php echo $rule_opacity; ?>;"></div>
	<?php endif ?>
</div>