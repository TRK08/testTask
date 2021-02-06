<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package test
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<header class="header">
		<div class="header__topLine">
			<span>ENTREGA EN 24 HRS O ELIGE LA FECHA</span>
			<span>CONSULTA TU CODIGO POSTAL PARA ENTREGAS</span>
			<span>PAGO SEGURO TARJETA DE CREDITO Y PAYPAL</span>
		</div>

		<nav id="site-navigation" class="main-navigation">
			
		</nav>
		</nav><!-- #site-navigation -->

			<div class="header-body">
				<div class="header__burger-menu">
					<span></span>
					<span></span>
					<span></span>
				</div>

				<a href="http://localhost:8000" class="header__logo">
					<img src="<?php echo get_template_directory_uri() ?>/img/header-logo.svg" alt="" >
				</a>

				<div class="header__shop">
					<a class="header-shop__icon header-shop__icon-like" href="">
						<img src="<?php echo get_template_directory_uri() ?>/img/profile-icon.svg" alt="">
					</a>
					<a class="header-shop__icon header-shop__icon-profile" href="">
						<img src="<?php echo get_template_directory_uri() ?>/img/like-icon.svg" alt="">
					</a>
					
					<a class="header-shop__icon header-shop__icon-cart" href="http://localhost:8000/cart">
						<img src="<?php echo get_template_directory_uri() ?>/img/cart-icon.svg" alt="">
						<div class="header-shop__counter">
							<?php echo sprintf('%d', WC()->cart->cart_contents_count); ?>
						</div>

						<a id="minicart" href="<?php echo WC()->cart->get_cart_url(); ?>" class="cart icon red relative">
							<div id="cartcontents">
								<div class="widget_shopping_cart_content">
									<?php woocommerce_mini_cart(); ?>
								</div>
							</div>
						</a>
					</a>
				</div>
			</div>

			<div class="header__bottom-text">
				BOUTIQUE ONLINE DE FLORES Y REGALOS DE LUJO EN BARCELONA 
			</div>

			<div class="header__bottom-line"></div>

			

			

	</header><!-- #masthead -->


	<script>

	</script>




	


	
