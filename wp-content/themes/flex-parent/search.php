<?php
/**
 * Template Name: Search Page
 */
?>

<?php get_header() ?>
    <div id="search">
        <div class="header">
            <img class="flourish" src="<?php echo get_template_directory_uri() ?>/images/flourish-burst.svg">
            <div class="container">
                <div class="breadcrumb">
                    <a title="Homepage" href="/">Flex</a>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                        <path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
                    </svg>
                    <span>Search</span>
                </div>
                <h1>Search</h1>
            </div>
        </div>
        <div class="content">
            <form method="GET" action="/">
                <input name="s" placeholder="Search" value="<?php echo $_GET["s"] ?>">
            </form>
            <?php if (trim($_GET["s"]) == "") : ?>
                <h2>Please enter search term(s)</h2>
            <?php else : ?>
                <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
                <h2>Search results for "<?php echo get_search_query() ?>"</h2>
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post() ?>
                        <h3>
                            <a href="<?php the_permalink() ?>" title="<?php echo strip_tags(get_the_title()) ?>">
                                <?php the_title() ?>
                            </a>
                        </h3>
                        <p>
                            <?php
                            // Get the Yoast post meta
                            $post_meta_string = get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
                            // If the Yoast post meta is empty, use the excerpt, if excerpt is empty return nothing
                            if (has_excerpt()) {
                                the_excerpt();
                            } else if (!empty($post_meta_string)) {
                                echo $post_meta_string;;
                            } else {
                                $content = get_the_content();
                                $trimmed_content = wp_trim_words($content, 40, '...');
                                if (!empty($trimmed_content)) {
                                    echo $trimmed_content;
                                } else {
                                    echo '';
                                }
                            }
                            ?>
                        </p>
                    <?php endwhile ?>
                    <div class="pagination">
                        <?php echo paginate_links(); ?>
                    </div>
                <?php else : ?>
                    <h3>No results found</h3>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
	<script>
		window.addEventListener('DOMContentLoaded', () => {
			(function ($) {
				// Get the block ID
				var id = "#<?php echo $block["id"] ?>";
				// Reveal the block
				ScrollReveal().reveal("#search .content form", {origin: "bottom", distance: "20px", duration: 1000});
				ScrollReveal().reveal("#search .content h2", {origin: "bottom", distance: "20px", duration: 1000});
				ScrollReveal().reveal("#search .content h3", {origin: "bottom", distance: "20px", duration: 1000});
				ScrollReveal().reveal("#search .content p", {origin: "bottom", distance: "20px", duration: 1000});
			}(jQuery));
		});
	</script>
<?php get_footer() ?>