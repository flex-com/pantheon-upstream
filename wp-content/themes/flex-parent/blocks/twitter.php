<div id="<?php echo $block["id"] ?>" class="twitter block">
	<div class="container <?php echo get_field("columns") ?>">
		<div class="tweet post-0">
			<div class="text-wrapper">
				<div class="header">
					<div class="left">
						<b>Flex</b> &bull; @Flexintl &bull; <span class="date"></span>
					</div>
					<div class="right">
					</div>
				</div>
				<div class="body"></div>
			</div>
		</div>
		<div class="tweet post-1">
			<div class="text-wrapper">
				<div class="header">
					<div class="left">
						<b>Flex</b> &bull; @Flexintl &bull; <span class="date"></span>
					</div>
					<div class="right">
					</div>
				</div>
				<div class="body"></div>
			</div>
		</div>
		<div id="tweet-2" class="tweet post-2">
			<div class="text-wrapper">
				<div class="header">
					<div class="left">
						<b>Flex</b> &bull; @Flexintl &bull; <span class="date"></span>
					</div>
					<div class="right">
					</div>
				</div>
				<div class="body"></div>
			</div>
		</div>
		<div class="feed">
			<?php echo do_shortcode("[custom-twitter-feeds feed=1]") ?>
		</div>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Render the latest tweet
				function render() {
					var block = $("#<?php echo $block["id"] ?>");
					// Iterate over all recent tweets
					block.find(".feed .ctf-item").each(function (index, element) {
						var date = $(element).find(".ctf-tweet-date").children().remove().end().text();
						var reply = $(element).find(".ctf-reply").clone();
						var retweet = $(element).find(".ctf-retweet").children("span").remove().end().clone();
						var text = $(element).find(".ctf-tweet-text").children("span").remove().end().clone();
						var image = $("<img>").attr("src", $(element).find(".ctf-tweet-media > a > img").data("full-image"));
						block.find(".post-" + index + " .text-wrapper .header .left .date").empty().append(date);
						block.find(".post-" + index + " .text-wrapper .header .right").empty().append(reply, retweet);
						block.find(".post-" + index + " .text-wrapper .body").empty().append(text, image)
						block.find(".post-" + index + " .text-wrapper").append(image)
						if ($(element).is("#tweet-2")) {
							return false;
						}
					});
				}

				// Render immediately if the page has already loaded (e.g. in the WordPress editor)
				if (document.readyState === "complete") {
					render();
				} else {
					$(window).on("load", function () {
						render();
					});
				}
				// Get the block ID
				var id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal(id + " .tweet", {origin: "bottom", distance: "20px", duration: 1000, viewFactor: 0.2, interval: 100, reset: false});
			})(jQuery);
		});
	</script>
</div>
