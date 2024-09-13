<?php

global $post;

$automatic_categories = get_field("automatic_categories") ?? null;
$automatic_content_types = get_field("automatic_content_types") ?? null;

$posts = [];

if (get_field("curated_posts")) {
	$curated_posts = get_posts([
		"post_type" => "resource",
		"post__in" => get_field("curated_posts"),
		"post__not_in" => [$post->ID],
		"orderby" => "post__in",
		"posts_per_page" => -1
	]);
	$posts = array_merge($posts, $curated_posts);
}

if (get_field("automatic_count")) {
	$automatic_posts = get_posts([
		"post_type" => "resource",
		"posts_per_page" => get_field("automatic_count"),
		"meta_query" => array(
			'relation' => 'OR',
			array(
				'key' => 'exclude_from_auto_list',
				'value' => '0',
				'compare' => '='
			),
			array(
				'key' => 'exclude_from_auto_list',
				'compare' => 'NOT EXISTS',
			),
		),
		"post__not_in" => get_field("curated_posts") ? array_merge(get_field("curated_posts"), [$post->ID]) : [$post->ID],
		"cat" => $automatic_categories ?? [],
		"tax_query" => $automatic_content_types ? [["taxonomy" => "content-type", "field" => "term_id", "terms" => $automatic_content_types]] : []
	]);
	$posts = array_merge($posts, $automatic_posts);
}

?>

<div class="sidebar block">
	<div class="container">
		<div class="content">
			<InnerBlocks />
		</div>
		<div class="sidebar">
			<?php foreach($posts as $post) : ?>
			<div class="post">
				<a title="<?php echo get_the_title($post->ID) ?>" class="image" href="<?php the_permalink($post->ID) ?>">
					<?php $image = get_field("featured_image", $post->ID) ?>
					<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["sizes"]["540x304"] ?>">
					<?php $content_type = get_the_terms($post->ID, "content-type")[0]->name ?>
					<?php if (strlen(trim($content_type)) > 0) : ?>
						<div class="label">
							<?php echo $content_type ?>
						</div>
					<?php endif ?>
				</a>
				<a title="<?php echo get_the_title($post->ID) ?>" class="title" href="<?php the_permalink($post->ID) ?>">
					<?php echo get_the_title($post->ID) ?>
				</a>
			</div>
			<?php endforeach ?>
			<?php if (get_field("link")) : ?>
			<div class="button block">
				<div class="container">
					<a title="<?php echo get_field("link")["title"] ?>" href="<?php echo get_field("link")["url"] ?>" target="<?php echo get_field("link")["target"] ?>">
						<?php echo get_field("link")["title"] ?>
						<div class="long-arrow">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.9 9.9" xml:space="preserve">
								<polygon points="15.5,0 14.5,0.9 17.4,4.3 0,4.3 0,5.7 17.4,5.7 14.5,9 15.5,9.9 19.9,5 "/>
							</svg>
							<div class="line"></div>
						</div>
					</a>
				</div>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>