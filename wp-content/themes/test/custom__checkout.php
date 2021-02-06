<?php
/**
 * Template Name: Custom checkout
 *
 * @package test
 */

get_header();
?>

	<main id="primary" class="site-main main__checkout">

		<div class="checkout__breadcrumbs"><?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(); ?></div>
		<div class="page-map">
			<div class="page-map__left">1. Корзина</div>
			<div class="page-map__right">2. Оформление заказа</div>
		</div>


		<?php echo do_shortcode( '[woocommerce_checkout]' ); ?>

		<?php echo do_shortcode('[woo_product_slider id="88"]'); ?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
