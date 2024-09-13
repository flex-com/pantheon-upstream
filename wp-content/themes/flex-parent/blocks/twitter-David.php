<div id="<?php echo $block["id"] ?>" class="twitter block">
	<div class="container">
		<div class="header">
			<div class="left">
				<b>Flex</b> &bull; @Flexintl &bull; <span class="date"></span>
			</div>
			<div class="right">
			</div>
		</div>
		<div class="body"></div>
		<div class="feed">
			<?php echo do_shortcode("[custom-twitter-feeds feed=1]") ?>
		</div>
	</div>
	<script>
		(function($) {
			// Render the latest tweet
			function render() {
				var block = $("#<?php echo $block["id"] ?>");
				// Iterate over all recent tweets
				block.find(".feed .ctf-item").each(function(index, element) {
					// If the tweet has an image
					if ($(element).find(".ctf-tweet-media > a > img").length > 0) {
						var date = $(element).find(".ctf-tweet-date").children().remove().end().text();
						var reply = $(element).find(".ctf-reply").clone();
						var retweet = $(element).find(".ctf-retweet").children("span").remove().end().clone();
						var text = $(element).find(".ctf-tweet-text").children("span").remove().end().clone();
						var image = $("<img>").attr("src", $(element).find(".ctf-tweet-media > a > img").data("full-image"));
						block.find(".header .left .date").empty().append(date);
						block.find(".header .right").empty().append(reply, retweet);
						block.find(".body").empty().append(text, image)
						return false;
					}
				});
			}
			// Render immediately if the page has already loaded (e.g. in the WordPress editor)
			if (document.readyState === "complete") {
				render();
			} else {
				$(window).on("load", function() {
					render();
				});
			}
		})(jQuery);
	</script>
</div>
