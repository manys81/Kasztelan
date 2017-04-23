<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="profile" href="<?php echo checkProtocol(); ?>gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!--    <meta property="og:url"           content="http://www.kasztelanrozprza.pl" />-->
<!--    <meta property="og:type"          content="website" />-->
<!--    <meta property="og:title"         content="LUMKS KASZTELAN ROZPRZA" />-->
<!--    <meta property="og:image"         content="http://kasztelanrozprza.pl/wp-content/themes/llorix-one-lite/images/kasztelan_logo1.png" />-->
<!--    <meta property="og:description"   content="Oficjalna strona LUMKS KASZTELAN ROZPRZA" />-->
<!--    <meta name="google-site-verification" content="nJ2sd6KiJebvCKZBdHduMf1n_2P2VnGqAw3wUHAhCQc" />-->
<!--    <meta name="theme-color" content="#ffffff">-->
    <script async src="<?php echo THMJS; ?>vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri (); ?>/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri (); ?>/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri (); ?>/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri (); ?>/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri (); ?>/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri (); ?>/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri (); ?>/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri (); ?>/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri (); ?>/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri (); ?>/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri (); ?>/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri (); ?>/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri (); ?>/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri (); ?>/images/favicon/manifest.json">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!--<div class="se-pre-con"></div>-->
<?php include_once("analyticstracking.php") ?>
<script>
    jQuery(document).ready(function() {
        window.fbAsyncInit = function () {
            FB.init({
                appId: '588451604697207',
                xfbml: true,
                version: 'v2.8'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/pl_PL/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    });
</script>
<?php if(is_single()): ?>
<?php if(in_category('galeria')): ?>
    <div class="se-pre-con"></div>
<?php endif; ?>
<?php endif; ?>
<header id="header">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="header-flex-container">
                <div>
                    <a class="logo-container" href="<?php echo get_site_url(); ?>">
                    <img  src="<?php echo get_template_directory_uri (); ?>/images/kasztelan_logo_small.png">
                    <div>
                        <p class="logo-text-topline">Oficjalny serwis</p>
                        <h1 class="logo-text-bottomline">LUMKS KASZTELAN ROZPRZA</h1>
                    </div>
                    </a>
                </div>

                <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu-collapse" aria-expanded="false">
                            <span class="sr-only">Menu</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                </div>

                    <?php
                        wp_nav_menu( array(
                                'menu'              => 'main-menu',
                                'theme_location'    => 'main-menu',
                                'depth'             => 3,
                                'menu_id'           =>  'menu-glowne',
                                'container'         => 'div',
                                'container_class'   => 'collapse navbar-collapse',
                                'container_id'      => 'main-menu-collapse',
                                'menu_class'        => 'nav navbar-nav navbar-right',
                                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                                'walker'            => new wp_bootstrap_navwalker())
                        );
                    ?>
            </div>
        </div>
    </nav>

<!--    Search Input-->
<!--    <div id="searchContainer" class="container-fluid hidden-xs hidden-sm">-->
<!--        <div class="container">-->
<!--            <div class="col-md-12">-->
<!--                <form role="search" method="get" class="search-form" action="/">-->
<!--                    <input autocomplete="off" class="searchInput" type="text" name="s" placeholder="Szukaj">-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

</header>