<?php

global $post;
$author = $post->post_author;

?>
<div id="overscroll-top" style="background-color: #eaeef4;"></div>
<div class="resource-header block">
	<div class="container">
		<div class="breadcrumb">
			<a title="Homepage" href="/">Flex</a>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M365.3 256l-22.6 22.6-192 192L128 493.3 82.7 448l22.6-22.6L274.7 256 105.4 86.6 82.7 64 128 18.7l22.6 22.6 192 192L365.3 256z"/></svg>
			<a title="Resources" href="/resources">Resources</a>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M365.3 256l-22.6 22.6-192 192L128 493.3 82.7 448l22.6-22.6L274.7 256 105.4 86.6 82.7 64 128 18.7l22.6 22.6 192 192L365.3 256z"/></svg>
			<a title="<?php the_title() ?>"><?php the_title() ?></a>
		</div>
		<h1><?php the_title() ?></h1>
		<?php if (get_field("show_author") || get_field("show_date")) : ?>
		<div class="separator"></div>
		<div class="details">
			<?php if (get_field("show_author")) : ?>
			<div class="author detail">
				<div>
					<div class="image">
						<?php $image = get_field("photo", "user_$author") ?>
						<img alt="<?php echo $image['alt'] ? $image['alt'] : $image['title'] ?>" src="<?php echo $image["sizes"]["336x336"] ?>">
					</div>
				</div>
				<div>
					by <a title="<?php the_author_meta("display_name", $author) ?>" href="/leadership/<?php the_author_meta("user_nicename", $author) ?>"><?php the_author_meta("display_name", $author) ?></a><br>
					<?php echo get_field("title", "user_$author") ?>
				</div>
			</div>
			<?php endif ?>
			<?php if (get_field("show_date")) : ?>
			<div class="date detail">
				Posted on<br>
				<?php echo get_the_date() ?>
			</div>
			<?php endif ?>
			<div class="categories">
				<?php $ctypes = get_the_terms($post->ID, "content-type") ?>
				<?php $ctypes = empty($ctypes) ? [] : $ctypes ?>
				<?php foreach ($ctypes as $ctype) : ?>
					<?php if ($ctype->name == "Webinar") : ?>
						<a class="cat-tag" href="/webinars"><?php echo $ctype->name ?></a>
					<?php elseif ($ctype->name == "Event") : ?>
						<a class="cat-tag" href="/events"><?php echo $ctype->name ?></a>
					<?php elseif ($ctype->name == "News") : ?>
						<a class="cat-tag" href="/newsroom/news"><?php echo $ctype->name ?></a>
					<?php elseif ($ctype->name == "Press Release") : ?>
						<a class="cat-tag" href="https://investors.flex.com/news/default.aspx"><?php echo $ctype->name ?></a>
					<?php else : ?>
						<span class="cat-tag"><?php echo $ctype->name ?></span>
					<?php endif ?>
				<?php endforeach ?>
				
				<?php $terms = get_the_terms($post->ID, "category") ?>
				<?php $terms = empty($terms) ? [] : $terms ?>
				<?php foreach ($terms as $term) : ?>
					
					<?php
					$args = array(
						'format' => 'slug',
						'link' => false,
						'inclusive' => false,
					);
					$parents = explode( '/', get_term_parents_list( $term, "category", $args ) );
					$level = count($parents);
					?>
					
					<?php if ($level == "1") : ?>
						<span class="cat-tag" data-cat-level="<?php echo $level ?>"><?php echo $term->name ?></span>
					<?php else : ?>
						<?php if (strlen(trim((get_field("destination", $term)))) > 0 ) : ?>
							<a class="cat-tag" data-cat-level="<?php echo $level ?>" data-destination="<?php echo trim((the_field("destination", $term))) ?>" href="<?php echo trim((the_field("destination", $term))) ?>"><?php echo $term->name ?></a>
						<?php else : ?>
							<span class="cat-tag" data-cat-level="<?php echo $level ?>" data-destination="<?php echo trim((the_field("destination", $term))) ?>"><?php echo $term->name ?></span>
						<?php endif ?>
					<?php endif ?>
					
				<?php endforeach ?>
			</div>
		</div>
		<?php endif ?>
	</div>
</div>
