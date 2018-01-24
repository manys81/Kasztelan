<?php

/***** ŚCIEŻKI I STAŁE *****/
define('THEMEUMNAME', wp_get_theme()->get( 'Name' ));
define('THMCSS', get_template_directory_uri().'/css/');
define('THMJS', get_template_directory_uri().'/js/');
define('THMIMG', get_template_directory_uri().'/img/');
define('THMINC', get_template_directory_uri().'/inc/');




/***** INCLUDOWANIE SKRYPTÓW *****/
require_once('inc/wp_bootstrap_navwalker.php');
require_once('inc/wp_quicks_walker.php');





/***** CSS i JS *****/
function bw2015_scripts() {
 if(in_category('galeria')){ wp_enqueue_style('homepage',THMCSS.'homepage.css?v=2017-10-11');}
    wp_enqueue_style('google-web-fonts','https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet');
    wp_enqueue_style('google-web-fonts-open-sans','https://fonts.googleapis.com/css?family=Open+Sans:400,800,700,300&subset=latin,latin-ext');
    wp_enqueue_style('bootstrap',THMCSS.'bootstrap.css?v=2017-10-18');
    wp_enqueue_style('animate',THMCSS.'animate.css');


    wp_enqueue_script('jquery',THMJS.'vendor/jquery-1.11.3.min.js',array(),'1.11.3',true);
    wp_enqueue_script('bootstrap',THMJS.'vendor/bootstrap.min.js',array(),'3.3.5',true);
    //wp_enqueue_script('jquery-countdown',THMJS.'vendor/jquery.countdown.min.js',array(),'2017-01-12',true);
    wp_enqueue_script('main',THMJS.'main.js',array(),'2016-06-16',true);
}
add_action('wp_enqueue_scripts','bw2015_scripts');


/***** FUNKCJONALNOŚCI SZABLONU *****/
function custom_theme_features()  {
    // formaty wpisów
    add_theme_support( 'post-formats', array( 'quote', 'gallery', 'image', 'video', 'link' ) );
    // miniaturki postów
    add_theme_support( 'post-thumbnails' );
    if ( function_exists( 'add_image_size' ) ) {
        add_image_size( 'header-thumb', 1920,300,true);
    }
    // oznaczenia semantyczne HTML5
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    // obsługa TITLE
    add_theme_support( 'title-tag' );
    // własny wygląd w edytorze treści
    add_editor_style( 'css/editor-style.css' );
    // wsparcie tłumaczeń
    load_theme_textdomain( 'kasztelan', get_template_directory() . '/language' );
}
add_action( 'after_setup_theme', 'custom_theme_features' );



/***** BIEŻĄCY JĘZYK *****/
add_filter('body_class', 'body_lang_class', 10, 2);
function body_lang_class($classes) {
    $classes[] = get_bloginfo('language');
    return $classes;
}



/***** DEKLARACJE MENU *****/
function custom_navigation_menus() {
    $locations = array(
        'main-menu' => __( 'Menu górne', 'kasztelan' ),
        'quicks-menu' => __( 'Trzy szybkie linki', 'kasztelan' ),
        'footer-menu1' => __( 'Menu w stopce (pomoc)', 'kasztelan' ),
        'footer-menu2' => __( 'Menu w stopce (na skróty)', 'kasztelan' )
    );
    register_nav_menus($locations);
}
add_action( 'init', 'custom_navigation_menus' );


/***** Sprawdzanie czy SSL *****/
function checkProtocol(){
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';

    return $protocol;
}

/***** SPRAWDZANIE TYPU STRONY/WPISU/POSTA *****/
function current_page_type_check() {
    global $wp_query;
    $loop = 'notfound';

    if ( $wp_query->is_page ) {
        $loop = is_front_page() ? 'front' : 'page';
    } elseif ( $wp_query->is_home ) {
        $loop = 'home';
    } elseif ( $wp_query->is_single ) {
        $loop = ( $wp_query->is_attachment ) ? 'attachment' : 'single';
    } elseif ( $wp_query->is_category ) {
        $loop = 'category';
    } elseif ( $wp_query->is_tag ) {
        $loop = 'tag';
    } elseif ( $wp_query->is_tax ) {
        $loop = 'tax';
    } elseif ( $wp_query->is_archive ) {
        if ( $wp_query->is_day ) {
            $loop = 'day';
        } elseif ( $wp_query->is_month ) {
            $loop = 'month';
        } elseif ( $wp_query->is_year ) {
            $loop = 'year';
        } elseif ( $wp_query->is_author ) {
            $loop = 'author';
        } else {
            $loop = 'archive';
        }
    } elseif ( $wp_query->is_search ) {
        $loop = 'search';
    } elseif ( $wp_query->is_404 ) {
        $loop = 'notfound 404';
    }

    return $loop;
}



/***** ZWRACANIE BIEŻĄCEGO URL (TEŻ POZA PĘTLĄ) *****/
function current_page_url() {
    $pageURL = 'http';
    if( isset($_SERVER["HTTPS"]) ) {
        if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    }
    $pageURL .= "://";
//    if ($_SERVER["SERVER_PORT"] != "80") {
//        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
//    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
//    }
    return $pageURL;
}




/***** EXCERPT Z ... I LIMITEM LICZBY WYRAZÓW *****/
function get_limited_excerpt($limit) {
    $excerpt = explode(' ', html_entity_decode(get_the_excerpt(),ENT_HTML5,UTF-8), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}




/***** UKRYWANIE ZBĘDNYCH POZYCJI W ADMINIE *****/
function remove_menus(){
    // remove_menu_page( 'index.php' );                  //Dashboard
    // remove_menu_page( 'edit.php' );                   //Posts
    // remove_menu_page( 'upload.php' );                 //Media
    // remove_menu_page( 'edit.php?post_type=page' );    //Pages
    remove_menu_page( 'edit-comments.php' );          //Comments
    // remove_menu_page( 'themes.php' );                 //Appearance
    // remove_menu_page( 'plugins.php' );                //Plugins
    // remove_menu_page( 'users.php' );                  //Users
    // remove_menu_page( 'tools.php' );                  //Tools
    // remove_menu_page( 'options-general.php' );        //Settings
}
add_action( 'admin_menu', 'remove_menus' );






/***** WYKASTROWANIE Z KOMENTARZY *****/

function require_comment_name($fields) {

    if ($fields['comment_author'] == '')
        wp_die('Error: please enter a valid name.');

    return $fields;
}
add_filter('preprocess_comment', 'require_comment_name');


//function df_disable_comments_post_types_support() { // wyłącza obsługę komentarzy w postach
//    $post_types = get_post_types();
//    foreach ($post_types as $post_type) {
//        if(post_type_supports($post_type, 'comments')) {
//            remove_post_type_support($post_type, 'comments');
//            remove_post_type_support($post_type, 'trackbacks');
//        }
//    }
//}
//add_action('admin_init', 'df_disable_comments_post_types_support');
//
//function df_disable_comments_status() { // wyłącza kod komentarzy we frontendzie
//    return false;
//}
//add_filter('comments_open', 'df_disable_comments_status', 20, 2);
//add_filter('pings_open', 'df_disable_comments_status', 20, 2);
//
//function df_disable_comments_hide_existing_comments($comments) { // ukrywa istniejące już komentarze
//    $comments = array();
//    return $comments;
//}
//add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);
//
//function df_disable_comments_admin_menu() { // usuwa stronę komentarzy w menu admina
//    remove_menu_page('edit-comments.php');
//}
//add_action('admin_menu', 'df_disable_comments_admin_menu');
//
//function df_disable_comments_admin_menu_redirect() { // redirect gdy ktoś próbuje dostać się na stronę komentarzy
//    global $pagenow;
//    if ($pagenow === 'edit-comments.php') {
//        wp_redirect(admin_url()); exit;
//    }
//}
//add_action('admin_init', 'df_disable_comments_admin_menu_redirect');
//
//function df_disable_comments_dashboard() { // usuwa metabox komentarzy w panelu admina
//    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
//}
//add_action('admin_init', 'df_disable_comments_dashboard');
//
//function df_disable_comments_admin_bar() { // usuwa linki do komentarzy w pasku admina
//    if (is_admin_bar_showing()) {
//        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
//    }
//}
//add_action('init', 'df_disable_comments_admin_bar');

//Dodanie Rejestracji do menu
//add_filter( 'wp_nav_menu_items', 'add_item_to_nav', 10, 2 );
//
//function add_item_to_nav( $items, $args )
//{
//    if ($args->menu_id == 'menu-glowne')
//    $items .= '<li id="menu-item-registration" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-85"><a title="Rejestracja" href="'. ot_get_option('register_url') .'">Rejestracja</a></li>';
//
//    return $items;
//}

function dateV($format,$timestamp=null){
    $to_convert = array(
        'l'=>array('dat'=>'N','str'=>array('Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota','Niedziela')),
        'F'=>array('dat'=>'n','str'=>array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień')),
        'f'=>array('dat'=>'n','str'=>array('stycznia','lutego','marca','kwietnia','maja','czerwca','lipca','sierpnia','września','października','listopada','grudnia'))
    );
    if ($pieces = preg_split('#[:/.\-, ]#', $format)){
        if ($timestamp === null) { $timestamp = time(); }
        foreach ($pieces as $datepart){
            if (array_key_exists($datepart,$to_convert)){
                $replace[] = $to_convert[$datepart]['str'][(date($to_convert[$datepart]['dat'],$timestamp)-1)];
            }else{
                $replace[] = date($datepart,$timestamp);
            }
        }
        $result = strtr($format,array_combine($pieces,$replace));
        return $result;
    }
}

//add_filter( 'wp_nav_menu_items','add_search_box', 10, 2 );
//function add_search_box( $items, $args ) {
//
//    if ($args->menu_id == 'menu-glowne')
//    $items .= '<li id="menu-item-search" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-85"><a><span class="glyphicon glyphicon-search"></span>
//                        <span class="mobileSearch visible-xs visible-sm">
//                            <form role="search" method="get" class="search-form" action="/">
//                                <input autocomplete="off" class="searchInput" type="text" name="s" placeholder="Szukaj">
//                            </form>
//                        </span>
//                    </a>
//                </li>';
//
//    return $items;
//}

//SVG Support

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function my_acf_google_map_api( $api ){

    $api['key'] = 'AIzaSyDgQ63Nq0mdmslDPJiSBOyVJ9DAvdNiHJ0';

    return $api;

}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
add_action( 'wp_ajax_nopriv_my_matches_ajax', 'my_matches_ajax' );
add_action( 'wp_ajax_my_matches_ajax', 'my_matches_ajax' );

function my_matches_ajax() {
    $out = '';
    $number =$_POST['number'];
    $args = array(
        'post_type'   => 'matches',
        'category_name' =>'single_round_2017',
        'posts_per_page'   => 25,
        'post_status'      => 'private'
    );
    $latest_books = get_posts( $args );
     foreach ($latest_books as $post):
         $round_val= get_cfc_meta( 'round_number', $post ->ID );
         if ($round_val[0]['round_number_field']== $number):
              $meta_values = get_cfc_meta( 'mecze', $post ->ID );
             foreach ($meta_values as $match):
                 $out .= '<div class="single-match">';
                   $out .= '<div class="team-name">';
                 $out .= '<p>'.$match['team_home'].'</p>';
                 $url=wp_get_attachment_image_src($match['home_logo']);
                       $out .= '<img  src="'.$url[0].'">';
                 $out .= '</div>';
                 $out .= '<div class="matches-score">';
                 $out .= '<p>'.$match['sets_home'].':'.$match['sets_guest'].'</p>';
                 $out .= '</div>';
                 $out .= '<div class="team-name team-name-right">';
                 $url=wp_get_attachment_image_src($match['guest_logo']);
                 $out .= '<img  src="'.$url[0].'">';
                 $out .= '<p>'.$match['team_guest'].'</p>';
                 $out .= '</div>';
                 $out .= '</div>';
              endforeach;
          endif;
      endforeach;
die($out);
}
