<?php

$posts = get_posts([
	"post_type"   => "resource",
	"author"      => $author,
	"numberposts" => -1
]);

?>
<?php get_header() ?>
	<div class="author">
		<div class="header">
			<img class="flourish" src="<?php echo get_template_directory_uri() ?>/images/flourish-burst.svg">
			<div class="container">
				<div class="breadcrumb">
					<a title="Homepage" href="/">Flex</a>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
						<path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
					</svg>
					<a title="Company" href="/company">Company</a>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
						<path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
					</svg>
					<a title="Leadership" href="/company/leadership">Leadership</a>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
						<path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
					</svg>
					<span><?php echo the_author_meta("display_name") ?></span>
				</div>
				<h1>Leadership</h1>
			</div>
		</div>
		<div class="about">
			<div class="container">
				<div class="left">
					<?php $image = get_field("photo", "user_" . $author) ?>
					<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["url"] ?>">
				</div>
				<div class="right">
					<h1>
						<?php echo the_author_meta("display_name") ?>
					</h1>
					<div class="title">
						<?php echo get_field("title", "user_" . $author) ?>
					</div>
					<?php if (get_the_author_meta("linkedin") or get_field("pdf_link", "user_" . $author)) : ?>
						<div class="social">
							<?php if (get_the_author_meta("linkedin")) : ?>
								<a title="<?php echo the_author_meta("display_name") ?> on LinkedIn" class="linkedin" href="<?php echo the_author_meta("linkedin") ?>" target="_blank">
									<svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
										<path fill="#ffffff"
											  d="m100.28 448h-92.88v-299.1h92.88zm-46.49-339.9c-29.7 0-53.79-24.6-53.79-54.3a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zm394.11 339.9h-92.68v-145.6c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7v148.1h-92.78v-299.1h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3v164.3z"/>
									</svg>
								</a>
							<?php endif ?>
							<?php if (get_field("pdf_link", "user_" . $author)) : ?>
								<a title="<?php echo the_author_meta("display_name") ?> profile in pdf" class="author-pdf" href="<?php echo get_field("pdf_link", "user_" . $author) ?>" target="_blank">
									<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
										<path fill="#ffffff" d="m0 64c0-35.3 28.7-64 64-64h160v128c0 17.7 14.3 32 32 32h128v144h-208c-35.3 0-64 28.7-64 64v144h-48c-35.3 0-64-28.7-64-64zm384 64h-128v-128zm-208 224h32c30.9 0 56 25.1 56 56s-25.1 56-56 56h-16v32c0 8.8-7.2 16-16 16s-16-7.2-16-16v-48-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-16v48zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48h-32c-8.8 0-16-7.2-16-16v-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16v-64c0-8.8-7.2-16-16-16h-16v96zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16h-32v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16h-32v48c0 8.8-7.2 16-16 16s-16-7.2-16-16v-64z"/>
									</svg>
								</a>
							<?php endif ?>
						</div>
					<?php endif ?>
					<div class="bio intro">
						<?php echo get_field("bio_intro", "user_" . $author) ?>
					</div>
					<?php if (get_field("bio_continued", "user_" . $author)) : ?>
						<div class="button-wrapper">
							<span class="open-it">Read more +</span>
							<span class="close-it">Read more &#8211;</span>
						</div>
					<?php endif ?>
					<div class="bio continued">
						<?php echo get_field("bio_continued", "user_" . $author) ?>
					</div>
				</div>
			</div>
		</div>
		<?php if (count($posts) > 0) : ?>
			<div class="posts">
				<div class="container">
					<?php foreach ($posts as $post) : ?>
						<div class="post">
							<a title="<?php echo get_the_title($post->ID) ?>" class="image" href="<?php the_permalink($post->ID) ?>">
								<?php $image = get_field("featured_image", $post->ID) ?>
								<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["sizes"]["760x428"] ?>">
								<?php $content_type = get_the_terms($post->ID, "content-type")[0]->name ?>
								<?php if (strlen(trim($content_type)) > 0) : ?>
									<div class="label">
										<?php echo $content_type ?>
									</div>
								<?php endif ?>
							</a>
							<div class="date">
								<?php echo get_the_date("", $post->ID) ?>
							</div>
							<div class="author">
								<?php echo the_author_meta("display_name") ?>
							</div>
							<a title="<?php echo get_the_title($post->ID) ?>" class="title" href="<?php the_permalink($post->ID) ?>">
								<?php echo get_the_title($post->ID) ?>
							</a>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		<?php endif ?>
		<script>
			window.addEventListener('DOMContentLoaded', () => {
				(function ($) {
					$(".button-wrapper span").on("click", function () {
						$(".about .container .right").toggleClass("active");
					});
					// Reveal the block
					ScrollReveal().reveal(".author .left", {origin: "bottom", distance: "20px", duration: 1000});
					ScrollReveal().reveal(".author .right", {origin: "bottom", distance: "20px", duration: 1000});
					ScrollReveal().reveal(".author .post", {origin: "bottom", distance: "20px", duration: 1000, viewFactor: 0.2, interval: 100, reset: false});
				})(jQuery);
			});
		</script>
	</div>
<?php get_footer() ?>