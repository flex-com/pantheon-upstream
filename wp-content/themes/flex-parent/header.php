<?php

$body_classes = [];
$announcement = get_field("announcement", "option");

if (!empty($_COOKIE["wp-fonts-loaded"])) {
	$body_classes[] = "fonts-loaded";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Design, Manufacturing and Supply Chain Logistics &bull; Flex</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="<?php echo get_template_directory_uri() ?>/images/icon.png" sizes="32x32"/>
	<?php wp_head() ?>
</head>
<body <?php body_class($body_classes) ?>>
<div id="flex-header">
	<div class="top">
		<?php if (!empty($announcement)) : ?>
			<div class="left">
				<a title="<?php echo $announcement["title"] ?>" href="<?php echo $announcement["url"] ?>" target="<?php echo $announcement["target"] ?>">
					<b>[flex-parent theme] ANNOUNCEMENT</b>
					<div class="bar"></div>
					<?php echo $announcement["title"] ?>
				</a>
			</div>
		<?php endif ?>
		<div class="right">
			<div class="search">
				<form action="<?php echo site_url() ?>" method="get">
					<input type="text" name="s" placeholder="Search" data-swplive="true"/>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
						<path fill="currentColor"
							  d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path>
					</svg>
				</form>
			</div>
			<div class="companies">
				Flex companies
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
					<path d="M4.251 181.1C7.392 177.7 11.69 175.1 16 175.1c3.891 0 7.781 1.406 10.86 4.25l197.1 181.1l197.1-181.1c6.5-6 16.64-5.625 22.61 .9062c6 6.5 5.594 16.59-.8906 22.59l-208 192c-6.156 5.688-15.56 5.688-21.72 0l-208-192C-1.343 197.7-1.749 187.6 4.251 181.1z"/>
				</svg>
				<?php wp_nav_menu(array("theme_location" => "companies", "container" => false)) ?>
			</div>
		</div>
	</div>
	<div class="bottom">
		<div class="container">
			<a title="Homepage" class="logo" href="/">
				<img alt="Flex logo" src="<?php echo get_template_directory_uri() ?>/images/logo.svg">
			</a>
			<div class="desktop menu">
				<?php wp_nav_menu(array("theme_location" => "main", "container" => false)) ?>
				<div class="dropdown">
					<div class="content"></div>
				</div>
			</div>
		</div>
		<a title="Contact us" class="button" href="/contact-us">
			Contact us
			<div class="long-arrow">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.9 9.9" xml:space="preserve">
						<polygon points="15.5,0 14.5,0.9 17.4,4.3 0,4.3 0,5.7 17.4,5.7 14.5,9 15.5,9.9 19.9,5 "/>
					</svg>
				<div class="line"></div>
			</div>
		</a>
		<div class="mobile-right">
			<div class="mobile-search">
				<a title="Search" href="<?php echo site_url() ?>?s">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
						<path fill="currentColor"
							  d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path>
					</svg>
				</a>
			</div>
			<div class="mobile-menu-toggle">
				<div class="bar top"></div>
				<div class="bar middle"></div>
				<div class="bar bottom"></div>
			</div>
		</div>
	</div>
	<nav class="mobile">
		<?php wp_nav_menu(array("theme_location" => "main", "container" => false)) ?>
		<a title="Contact us" class="mobile-menu-extra-link" href="/contact-us">
			Contact us
		</a>
		<ul>
			<li>
				<a title="Flex companies" href="/company/brands">Flex companies</a>
				<?php wp_nav_menu(array("theme_location" => "companies", "container" => false)) ?>
			</li>
		</ul>
	</nav>
</div>