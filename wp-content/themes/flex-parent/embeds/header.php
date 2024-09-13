<?php

$embed = true;
require_once("../../../../wp-load.php");
header("Access-Control-Allow-Origin: *");

?>
<style type="text/css">
	<?php echo file_get_contents(get_template_directory()."/styles/build/fonts.css") ?>
	<?php echo file_get_contents(get_template_directory()."/styles/build/header.css") ?>
	<?php 
	/**
		BUGHERD OVERIDE HACK FOR IR - REMOVE WHEN FIXED
		Placed here for quick fix to IR still displaying Bugherd tool
	 */
	echo "#bugherd_embed_communication_frame { visibility:none !important; display: none !important; }";
	echo "#bugherd_toggle { visibility:none !important; display: none !important; }";
	echo ".cm_overlay.visible { display: none !important; visibility: none !important;}"
	?>
</style>
<?php include("../header.php") ?>
<script>
	<?php include("../scripts/navigation.js") ?>
</script>