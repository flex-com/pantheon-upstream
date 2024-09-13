<?php

$file = get_field("file");
$mime_type = $file["mime_type"];
$filename = $file["filename"];

// Set headers
header("Content-Type: $mime_type");
header("Content-Disposition: inline; filename=\"$filename\"");
readfile(get_attached_file($file["id"]));

?>