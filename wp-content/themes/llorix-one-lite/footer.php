<?php
if (function_exists( 'ot_get_option' ) ) {
    $sponsors = ot_get_option('sponsors');
}

$menuLocations = get_nav_menu_locations();
$footerMenu1 = wp_get_nav_menu_object($menuLocations['footer-menu1']);
$footerMenu2 = wp_get_nav_menu_object($menuLocations['footer-menu2']);

$news = new WP_Query(
    array (
        'post_type'              => array( 'post' ),
        'post_status'            => array( 'publish' ),
        'pagination'             => false,
        'ignore_sticky_posts'    => true,
        'cache_results'          => true
    )
);
?>




<footer id="footer" role="contentinfo">
    <div class="partner-box">
            <img  src="<?php echo get_template_directory_uri (); ?>/images/kasztelan_logo_small.png">
            <p>Partnerzy</p>
        <div class="parntners-container">
            <a><img  src="<?php echo get_template_directory_uri (); ?>/images/rolbud1.png" width="100px" ></a>
            <a target="_blank" href="http://gimnazjum-rozprza.pl"><img  src="<?php echo get_template_directory_uri (); ?>/images/jan_pawel1.png" height="70px"></a>
           <a target="_blank"  href="http://rozprza.pl"><img  src="<?php echo get_template_directory_uri (); ?>/images/gmina1.png" height="70px"></a>
           <a target="_blank" href="http://www.elanda.pl"><img  src="<?php echo get_template_directory_uri (); ?>/images/logo_elanda.png" width="100px" ></a>
           <a target="_blank" href="https://www.facebook.com/djorson.michalorski"><img  src="<?php echo get_template_directory_uri (); ?>/images/djorson.png" width="100px" ></a>
        </div>
    </div>
    <div class="social-media">
        <p>LUMKS KASZTELAN social media</p>
        <div class="social-icons">
            <a target="_blank" href="https://www.facebook.com/kasztelanrozprza/"><span class="icon-facebook"></span></a>
            <a target="_blank" href="https://www.youtube.com/channel/UCAPEHse2P_pm0Er0dHXtjQQ"><span class="icon-youtube2"></span></a>
        </div>
    </div>
    <div class="copyright-footer">
        <div class="container">&copy LUMKS Kasztelan Rozprza 2016</div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
