<div class="homepage-carousel block">
	<?php $indexnum = 1; ?>
	<?php while(have_rows("slides")) : the_row() ?>
		<div class="slide slide-<?php echo $indexnum ?>">
			<div class="container">
				<div class="text">
					<?php if (get_sub_field("title")) : ?>
						<h1><?php echo the_sub_field("title") ?></h1>
					<?php endif ?>
					<?php if (get_sub_field("subtitle")) : ?>
						<p><?php echo the_sub_field("subtitle") ?></p>
					<?php endif ?>
					<?php if (get_sub_field("link")) : ?>
						<div class="button block">
							<div class="container">
								<a title="<?php the_sub_field("title") ?>" href="<?php echo get_sub_field("link")["url"] ?>">
									<span class="mobile">Learn more</span>
									<span class="desktop"><?php echo get_sub_field("link")["title"] ?></span>
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
				<div class="image">
					<img class="background" src="/wp-content/uploads/2023/07/banner-circle-graphic-blue.svg">
					<img class="foreground" src="<?php echo get_sub_field("foreground_image")["url"]?>">
				</div>
			</div>
			<?php $indexnum++; ?>
		</div>
	<?php endwhile ?>
	
	<div class="bars">
		<?php $indexnum = 1; ?>
		<?php while(have_rows("slides")) : the_row() ?>
			<?php if ($indexnum == 1) : ?>
				<div class="bar selected" onclick="change_slide(1)"></div>
			<?php else : ?>
				<div class="bar" onclick="change_slide(<?php echo $indexnum ?>)"></div>
			<?php endif ?>
			<?php $indexnum++; ?>
		<?php endwhile ?>
	</div>
	<script>
		var timeout;
		var change_slide;
		(function($) {
			change_slide = function(slide) {
				clearTimeout(timeout);
				timeout = setTimeout(function() {
					var next_slide = slide + 1;
					if (slide + 1 > $(".homepage-carousel.block .slide").length) {
						next_slide = 1;
					}
					change_slide(next_slide);
				}, 7000);
				$(".homepage-carousel.block .slide").removeClass("visible");
				$(".homepage-carousel.block .bars .bar").removeClass("selected");
				$(".homepage-carousel.block .bars .bar").eq(slide - 1).addClass("selected");
				$(".homepage-carousel.block .bars").addClass("visible");
				$(".homepage-carousel.block .slide-" + slide).addClass("visible");
			};
			// Show the first slide when all images within the first slide have loaded
			var loaded = 0;
			$(".homepage-carousel.block .slide-1 img").each(function() {
				var image = new Image();
				image.onload = function() {
					loaded = loaded + 1;
					if (loaded === $(".homepage-carousel.block .slide-1 img").length) {
						change_slide(1);
					}
				};
				image.src = $(this).attr("src");
			});			
		})(jQuery);
	</script>
</div>