<?php
/**
 * The template for displaying the footer
 *
 * @package test
 */

?>

<!-- Подвал -->
<footer class="footer">
    
    <div class="container">

        <div class="footer__social">
            <a href="#" class="footer__socialLink">
                <img class="footer__socialLink-inst" src="<?php echo get_template_directory_uri() ?>/img/instagram.svg">
            </a>
            <a href="#" class="footer__socialLink">
                <img class="footer__socialLink-inst" src="<?php echo get_template_directory_uri() ?>/img/instagram.svg">
            </a>
            <a href="#" class="footer__socialLink">
                <img class="footer__socialLink-inst" src="<?php echo get_template_directory_uri() ?>/img/instagram.svg">
            </a>
            <a href="#" class="footer__socialLink">
                <img class="footer__socialLink-inst" src="<?php echo get_template_directory_uri() ?>/img/instagram.svg">
                <!-- <img src=    "./img" alt=""> -->
            </a>
        </div>

        <ul class="footer__menu">
            <li class="footer__menu-item">
                <a href="#">SOBRE NOSOTROS</a>
            </li>
            <li class="footer__menu-item">
                <a href="#">TIENDA</a>
            </li>
            <li class="footer__menu-item">
                <a href="#">SERVICIO</a>
            </li>
            <li class="footer__menu-item">
                <a href="#">ENTREGAS</a>
            </li>
            <li class="footer__menu-item">
                <a href="#">BLOG</a>
            </li>
            <li class="footer__menu-item">
                <a href="#">CONTACTO</a>
            </li>
        </ul>

        <div class="footer__logo">
            <a href="#">
                <img src="<?php echo get_template_directory_uri() ?>/img/footer-logo.svg">
            </a>
        </div>
        <div class="col-md-12 text-center footer__copyright">
            <p>@2019 Flordecor</p>
            <span class="footer__copyright-separator"></span>
            <p>Aviso legal</p>
            <span class="footer__copyright-separator"></span>
            <p>Politica de privacidad</p>
            <span class="footer__copyright-separator"></span>
            <p>Politica de cookies</p>
        </div>
        
        
    </div>
</footer>
<!-- /Окончание подвала /footer -->
<?php wp_footer(); ?>


</body>
</html>