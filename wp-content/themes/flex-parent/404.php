<?php get_header() ?>
	<div id="page-404">
	<div class="header">
		<img class="flourish" src="<?php echo get_template_directory_uri() ?>/images/flourish-burst.svg">
		<div class="container">
			<div class="breadcrumb">
				<a title="Homepage" href="/">Flex</a>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
					<path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
				</svg>
				<span>404</span>
			</div>
			<h1>404</h1>
		</div>
	</div>
	<div class="content">
		<h2>Page Not Found</h2>
		<p>
			We couldn't find the page you were looking for.
			This may be the result of an old link or a moved page.
			We apologize for the inconvenience.
		</p>
		<p>
			Please <a href="/contact-us">contact us</a> for more information.
		</p>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Get the block ID
				var id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal("#page-404 .content h2", {origin: "bottom", distance: "20px", duration: 1000});
				ScrollReveal().reveal("#page-404 .content p", {origin: "bottom", distance: "20px", duration: 1000});
			}(jQuery));
		});
	</script>
<?php get_footer() ?>