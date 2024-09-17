<div class="homepage-carousel block">
	<div class="slide slide-1">
		<div class="container">
			<div class="text">
				<h1>Driving toward our 2030 sustainability strategy and goals</h1>
				<p>Flex’s 2024 sustainability report showcases our global sustainability performance from calendar year 2023.</p>
				<div class="button block">
					<div class="container">
						<a href="/downloads/2024-sustainability-report" title="2024 Sustainability Report" target="_blank">
							<span class="mobile">View the report</span>
							<span class="desktop">View the report</span>
							<div class="long-arrow">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.9 9.9" xml:space="preserve">
									<polygon points="15.5,0 14.5,0.9 17.4,4.3 0,4.3 0,5.7 17.4,5.7 14.5,9 15.5,9.9 19.9,5 "/>
								</svg>
								<div class="line"></div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="image">
				<img class="foreground dsktp" alt="Sustainable green x" src="/wp-content/uploads/2024/08/homepage-X-sustainability-green-leaves-cut-off-v2.png">
				<img class="foreground mbl" alt="Sustainable green x" src="/wp-content/uploads/2024/08/homepage-X-sustainability-green-leaves.png">
			</div>
		</div>
	</div>
	
	<div class="slide slide-2">
		<div class="container">
			<div class="text">
				<h1>Manufacturing data center infrastructure</h1>
				<p>Powering AI innovation at&nbsp;scale</p>
				<div class="button block">
					<div class="container">
						<a href="/industries/cloud/data-center-power-compute" title="Data Center Power and Compute">
							<span class="mobile">Learn more</span>
							<span class="desktop">Learn more</span>
							<div class="long-arrow">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.9 9.9" xml:space="preserve">
									<polygon points="15.5,0 14.5,0.9 17.4,4.3 0,4.3 0,5.7 17.4,5.7 14.5,9 15.5,9.9 19.9,5 "/>
								</svg>
								<div class="line"></div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="image">
				<img class="background" src="/wp-content/uploads/2024/07/banner-fiber-graphic-flex-blue.svg">
				<img class="foreground" alt="Data center" src="/wp-content/uploads/2024/07/Homepage-Data-Center-v2.png">
			</div>
		</div>
	</div>
	
	<div class="slide slide-3">
		<div class="container">
			<div class="text">
				<h1>Integrated <nobr>end-to-end</nobr> lifecycle&nbsp;services</h1>
				<p>Delivering value beyond traditional&nbsp;EMS</p>
				<div class="button block">
					<div class="container">
						<a href="/solutions-and-services" title="Our product lifecycle services">
							<span class="mobile">Learn more</span>
							<span class="desktop">Learn more</span>
							<div class="long-arrow">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.9 9.9" xml:space="preserve">
									<polygon points="15.5,0 14.5,0.9 17.4,4.3 0,4.3 0,5.7 17.4,5.7 14.5,9 15.5,9.9 19.9,5 "/>
								</svg>
								<div class="line"></div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="image">
				<img class="background" src="/wp-content/uploads/2023/10/banner-graphic-ripple-flex-blue.svg">
				<img class="foreground" alt="Robotic arm" src="/wp-content/uploads/2024/07/Homepage-Services-v2-sm-box.png">
			</div>
		</div>
	</div>
	
	<div class="slide slide-4">
		<div class="container">
			<div class="text">
				<h1>Regionalization strategies to deliver with&nbsp;speed</h1>
				<p>Mitigating risk and complexity</p>
				<div class="button block">
					<div class="container">
						<a href="/solutions-and-services/supply-chain#resilience" title="Your Trusted and Resilient Global Supply Chain Partner">
							<span class="mobile">Learn more</span>
							<span class="desktop">Learn more</span>
							<div class="long-arrow">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 19.9 9.9" xml:space="preserve">
									<polygon points="15.5,0 14.5,0.9 17.4,4.3 0,4.3 0,5.7 17.4,5.7 14.5,9 15.5,9.9 19.9,5 "/>
								</svg>
								<div class="line"></div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="image">
				<img class="background" src="/wp-content/uploads/2023/11/banner-graphic-connected-dots-flex-blue.svg">
				<img class="foreground" alt="Laptop displaying world map" src="/wp-content/uploads/2024/07/Homepage-Regionalization.png">
			</div>
		</div>
	</div>
	<div class="bars">
		<div class="bar selected" onclick="change_slide(1)"></div>
		<div class="bar" onclick="change_slide(2)"></div>
		<div class="bar" onclick="change_slide(3)"></div>
		<div class="bar" onclick="change_slide(4)"></div>
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