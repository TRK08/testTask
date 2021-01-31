<?php
/**
 * Template Name: First page
 *
 * @package test
 */

get_header();
?>

	<main id="primary" class="site-main">

	 

		<div style="width: 1000px; height: 500px">
			<?php echo do_shortcode("[wpcs id=50]"); ?>
		</div>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
