<?php
/**
 * Template Name: Team
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<?php get_header(); ?>
<div class="container post-page team-page">

    <h2 class=""><?php the_title(); ?></h2>
    <?php if ( has_post_thumbnail() ) : ?>
        <img src="<?php the_post_thumbnail_url(); ?>"/>
    <?php endif; ?>
    <ul class="team-sort-list">
        <li class="filterBy active" data-show="all">Wszyscy</li>
        <li class="filterBy" data-show="spiker">Atakujący</li>
        <li class="filterBy" data-show="setter">Rozgrywający</li>
        <li class="filterBy" data-show="middle">Środkowi</li>
        <li class="filterBy" data-show="libero">Libero</li>
        <li class="filterBy" data-show="reciver">Przyjmujący</li>
        <li class="filterBy" data-show="coach">Trenerzy</li>
    </ul>
    <div class="team-container row">
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="spiker">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_lpisarek.png" >
                    <div class="name">Łukasz Pisarek</div>
                    <div class="birthday"></div>
                </div>
            </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="reciver">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_aziemba.png" >
                <div class="name">Artur Ziemba</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="reciver">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_mzygmunt.png" >
                <div class="name">Marcin Zygmunt</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="setter">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_knowakowski.png" >
                <div class="name">Krzysztof Nowakowski</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="libero">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_kpisarek.png" >
                <div class="name">Krzysztof Pisarek</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="middle">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_rstasiak.png" >
                <div class="name">Robert Stasiak</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="middle">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_kmikolajewski.png" >
                <div class="name">Jakub Mikołajewski</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="spiker">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_bgaj.png" >
                <div class="name">Bartosz Gaj</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="libero">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_peczek.png" >
                <div class="name">Mateusz Pęczek</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="middle">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_kkowalewski.png" >
                <div class="name">Konrad Kowalewski</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="middle">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_msendalski.png" >
                <div class="name">Michał Sendalski</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="reciver">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_bswirski.png" >
                <div class="name">Bartosz Świrski</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="setter">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_akabzinski.png" >
                <div class="name">Artur Kabziński</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="middle">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_mmarkiewicz.png" >
                <div class="name">Mateusz Markiewicz</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="coach">
            <div class="single-person-inside" >
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_pkowalczyk.png" >
                <div class="name">Paweł Kowalczyk</div>
                <div class="birthday"></div>
            </div>
        </div>
        <div class="single-person col-md-3 col-sm-4 col-xs-6" data-filter="coach">
            <div class="single-person-inside">
                <img src="<?php echo get_template_directory_uri (); ?>/images/players/a_jjanas.png" >
                <div class="name">Jarosław Janas</div>
                <div class="birthday"></div>
            </div>
        </div>
    </div>

</div>

<?php get_footer(); ?>

