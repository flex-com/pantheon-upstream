<?php
// Press release JSON feed
$url = "https://investors.flex.com/feed/PressRelease.svc/GetPressReleaseList?languageId=1&year=-1&pageSize=-1&bodyType=3&includeTags=true&pressReleaseDateFilter=1";

// Attempt to get data from object cache first
$press_releases = wp_cache_get('cached_press_releases');

// If not in object cache, fall back to transients
if (!$press_releases) {
	$press_releases = get_transient('cached_press_releases');
}

// If still not found, fetch the data
if (!$press_releases) {
	// Fetch data using cURL
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
	$response = curl_exec($ch);
	curl_close($ch);

	try {
		$decoded_response = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

		if (isset($decoded_response["GetPressReleaseListResult"])) {
			$press_releases = $decoded_response;

			// Save to object cache
			wp_cache_set('cached_press_releases', $press_releases, '', 300); // 300 seconds

			// Also cache the response using transients for 5 minutes (300 seconds)
			set_transient('cached_press_releases', $press_releases, 300);
		}

	} catch (JsonException $e) {
		// Handle exception if needed
	}
}
// Uncomment the next line if needed to display the fetched data, whether cached or new.
// echo json_encode($press_releases);

// Get display limits
$pr_posts_per_page = get_field("limit_type") == "number" ? get_field("limit_number") - 1 : -1;
$pr_date_query = get_field("limit_type") == "months" ? ["column" => "post_date_gmt", "after" => get_field("limit_months") . " months ago"] : null;

?>
<div id="<?php echo $block["id"] ?>" class="press-releases block">
	<div class="container">
		<div class="posts">
			<?php for ($i = 0; $i <= $pr_posts_per_page; $i++) { ?>
				<div class="post">
					<div class="date">
						<?php
						$pr_date = strtotime($press_releases["GetPressReleaseListResult"][$i]["PressReleaseDate"]);
						echo date('F d, Y', $pr_date);
						?>
					</div>
					<a title="<?php echo($press_releases["GetPressReleaseListResult"][$i]["Headline"]); ?>" class="title" href="<?php echo("https://investors.flex.com" . $press_releases["GetPressReleaseListResult"][$i]["LinkToDetailPage"]); ?>">
						<?php echo($press_releases["GetPressReleaseListResult"][$i]["Headline"]); ?>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Get the block ID
				let id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal(id + " .post", {origin: "bottom", distance: "20px", duration: 1000});
			}(jQuery));
		});
	</script>
</div>