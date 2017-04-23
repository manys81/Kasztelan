<?php
/**
 * Template Name: Home
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<?php

//$startTimeString = "2017-03-31 18:00";
//$startTimeObj = DateTime::createFromFormat('Y-m-d H:i', $startTimeString);
//$startTime = 0;
//if(!empty($startTimeString)){
//    date_default_timezone_set('Europe/Warsaw');
//    $startTime = strtotime($startTimeString) - time();
//    $days = floor($startTime/86400);
//    $hours = floor(($startTime-($days*86400))/3600);
//    $mins = floor (($startTime-($days*86400)-($hours*3600))/60);
//    $secs = floor ($startTime-($days*86400)-($hours*3600)-($mins*60));
//    $hours = sprintf('%02d', $hours);
//    $mins = sprintf('%02d', $mins);
//    $secs = sprintf('%02d', $secs);
//}

$args = array(
    'post_type'   => 'matches',
    'category_name' =>'final_3_liga',
    'posts_per_page'   => 3,
    'post_status'      => 'private',
    'order'         =>'ASC'
);
$final = get_posts( $args );
?>
<?php
get_header(); ?>
<?php include_once("single-matches.php"); ?>
<?php
$myposts = get_posts( array(
    'category'       => 3,
    'numberposts'  => 3
) );
$i=0;
?>
    <div class=" gallery">

        <?php foreach($myposts as $i=>$post) : ?>
            <?php  $fields = get_fields($myposts->ID); ?>
            <?php if($i==0): ?>
                <div class="big-img-gallery">
                    <div class="article" style="background-image: url('<?php the_post_thumbnail_url(); ?>')">
                        <div class="article-description">
                            <a href="<?php the_permalink(); ?>">
                                <div class="article-text">
                                    <h2><?php echo $fields['post_title']; ?></h2>
                                    <p><?php echo $fields['short_description']; ?></p>
                                    <span>Zobacz</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <?php if($i==1){echo '<div class="small-img-container">';} ?>
                <div style="background-image: url('<?php the_post_thumbnail_url(); ?>')" class="article">
                    <div class="article-description">
                        <a href="<?php the_permalink(); ?>">
                            <div class="article-text">
                                <h2><?php echo $fields['post_title']; ?></h2>
                                <p><?php echo $fields['short_description']; ?></p>
                                <span>Zobacz</span>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <?php $i++; ?>
        <?php endforeach; ?>
    </div>
    </div>
<!--    <div>-->
<!--        <section style="background-image: url('/*/images/tlo.jpg')" id="timer" data-time="*/">-->
<!--            <div class="container">-->
<!--                <div class="row">-->
<!--                    <div class="timer col-xs-12 col-md-8">-->
<!--                        <div class="timeBlock">-->
<!--                            <span class="days value">--><?php //echo $days; ?><!--</span>-->
<!--                            <span class="days text">--><?php //_e('dni');?><!--</span>-->
<!--                        </div>-->
<!--                        <div class="separator"></div>-->
<!--                        <div class="timeBlock">-->
<!--                            <span class="hours value">--><?php //echo $hours; ?><!--</span>-->
<!--                            <span class="hours text">--><?php //_e('godzin');?><!--</span>-->
<!--                        </div>-->
<!--                        <div class="separator"></div>-->
<!--                        <div class="timeBlock">-->
<!--                            <span class="minuts value">--><?php //echo $mins; ?><!--</span>-->
<!--                            <span class="minuts text">--><?php //_e('minut');?><!--</span>-->
<!--                        </div>-->
<!--                        <div class="separator"></div>-->
<!--                        <div class="timeBlock">-->
<!--                            <span class="seconds value">--><?php //echo $secs; ?><!--</span>-->
<!--                            <span class="seconds text">--><?php //_e('sekund');?><!--</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-xs-12 col-md-4">-->
<!--                        <h2>Pozostało </br>do turnieju</h2>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
<!--    </div>-->
    <div class="matches-slider">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">

            <!-- Wrapper for slides -->
            <div class="carousel-inner slider-contener" role="listbox">
                <?php foreach ( $wynik=array_reverse($latest_books) as $post): ?>
                    <?php $round_val= get_cfc_meta( 'round_number', $post ->ID ); ?>
                    <?php  $meta_values = get_cfc_meta( 'mecze', $post ->ID ); ?>
                    <!--                    <a>-->
                    <?php foreach ($meta_values as $match): ?>
                        <?php if(($match['team_home']=='LUMKS Kasztelan Rozprza') || ($match['team_guest']=='LUMKS Kasztelan Rozprza')): ?>
                        <div class="item  <?php   if($round_val[0]['slider-active']=='true'): ?>active<?php endif; ?>">
                            <div class="single-item">
                                <div class="slider-title">
                                    <p class="slider-title-big">III liga mężczyzn</p>
                                    <p class="slider-title-small"><?php echo $round_val[0]['round_number_field']; ?> KOLEJKA</p>
                                </div>
                                <div class="slider-team">
                                    <div>
                                        <img  src="<?php $url=wp_get_attachment_image_src($match['home_logo']); echo $url[0]; ?>">
                                        <p><?php  echo $match['team_home'] ?></p>
                                    </div>
                                </div>
                                <div class="slider-score">
                                    <?php if($match['sets_home']!=''){ echo $match['sets_home'].':'.$match['sets_guest']; } else{ echo '-:-';} ?>
                                    <?php if($match['sets_point']): ?> <span>(<?php echo $match['sets_point']; ?>)</span><?php endif; ?>
                                </div>
                                <div class="slider-team slider-guest">
                                    <div>
                                        <img  src="<?php $url=wp_get_attachment_image_src($match['guest_logo']); ; echo $url[0]; ?>">
                                        <p><?php  echo $match['team_guest'] ?></p>
                                    </div>
                                </div>
                                <div class="slider-title slider-title-left">
                                    <p class="slider-title-big"><?php echo $round_val[0]['data-meczu']; ?></p>
                                    <p class="slider-title-small">godzina <?php echo $round_val[0]['godzina-meczu']; ?></p>
                                </div>
                            </div>
                            </div><?php  endif; ?>
                    <?php  endforeach; ?>
                <?php  endforeach; ?>
                <?php  $i=0; ?>
                <?php foreach ( $final as $post): ?>
                    <?php  $round_val= get_cfc_meta( 'round_number', $post ->ID ); ?>
                    <?php  $meta_values = get_cfc_meta( 'mecze', $post ->ID ); ?>
                    <!--                    <a>-->
                    <?php foreach ($meta_values as $match): ?>
                        <?php if(($match['team_home']=='LUMKS Kasztelan Rozprza') || ($match['team_guest']=='LUMKS Kasztelan Rozprza')): ?>
                        <div class="item  <?php   if($round_val[0]['slider-active']=='true'): ?>active<?php endif; ?>">
                            <div class="single-item">
                                <div class="slider-title">
                                    <p class="slider-title-big">III liga mężczyzn</p>
                                    <p class="slider-title-small"><?php echo $round_val[0]['round_number_field']; ?> KOLEJKA</p>
                                </div>
                                <div class="slider-team">
                                    <div>
                                        <img  src="<?php $url=wp_get_attachment_image_src($match['home_logo']); echo $url[0]; ?>">
                                        <p><?php  echo $match['team_home'] ?></p>
                                    </div>
                                </div>
                                <div class="slider-score">
                                    <?php if($match['sets_home']!=''){ echo $match['sets_home'].':'.$match['sets_guest']; } else{ echo '-:-';} ?>
                                    <?php if($match['sets_point']): ?> <span>(<?php echo $match['sets_point']; ?>)</span><?php endif; ?>
                                </div>
                                <div class="slider-team slider-guest">
                                    <div>
                                        <img  src="<?php $url=wp_get_attachment_image_src($match['guest_logo']); ; echo $url[0]; ?>">
                                        <p><?php  echo $match['team_guest'] ?></p>
                                    </div>
                                </div>
                                <div class="slider-title slider-title-left">
                                    <p class="slider-title-big"><?php echo $round_val[0]['data-meczu']; ?></p>
                                    <?php if($i==0): ?>
                                    <p class="slider-title-small">godzina <?php echo $round_val[0]['godzina-meczu']; ?></p>
                                    <?php else: ?>
                                    <p class="slider-title-small">godzina <?php echo $round_val[0]['godzina-drugiego-meczu']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            </div><?php  endif; ?>
                    <?php  endforeach; ?>
                    <?php $i++; ?>
                <?php  endforeach; ?>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="table-matches-container">
        <div class="matches-container">
            <?php include_once("ajax_round.php"); ?>
        </div>
        <div class="custom-table table-responsive">
            <h3>III liga mężczyzn</h3>
            <table class="table">
                <tbody>
                <tr>
                    <th>#</th>
                    <th>Drużyna</th>
                    <th>Mecze</th>
                    <th>Pkt</th>
                    <th>Sety</th>
                    <th>Punkty</th>

                </tr>
                <?php $i=0; ?>
                <?php foreach ($table as $team): ?>
                    <?php $i++; ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $team['name']; ?></td>
                        <td><?php echo $team['match_count']; ?></td>
                        <td><?php echo $team['points']; ?></td>
                        <td><?php echo $team['sets_plus']; ?>:<?php echo $team['sets_minus']; ?></td>
                        <td><?php echo $team['points_plus']; ?>:<?php echo $team['points_minus']; ?></td>
                    </tr>
                <?php  endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php foreach($posts as $i=>$post) : ?>
    <?php
    $post_thumbnail_id = get_post_thumbnail_id( $post );
    $fields = get_fields($post->ID);
    ?>
<?php endforeach; ?>
<?php
wp_enqueue_script('ajax-matches',THMJS.'vendor/ajax-matches.js',array(),'2016-12-12',true);
wp_localize_script( 'ajax-matches', 'ajaxmatches', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'templateUrl'=> get_stylesheet_directory_uri()
));
?>

    <!--    <div class="modal fade" id="myModal" role="dialog">-->
    <!--        <div class="modal-dialog">-->
    <!---->
    <!--            <!-- Modal content-->
    <!--            <div class="modal-content">-->
    <!--                <div class="modal-body">-->
    <!--                    --><?php //if (function_exists('vote_poll') && !in_pollarchive()): ?>
    <!--                        --><?php //get_poll();?>
    <!--                    --><?php //endif; ?>
    <!--                </div>-->
    <!--                <div class="modal-footer">-->
    <!--                    <button type="button" class="btn btn-default poll-btn" data-dismiss="modal">Zamknij</button>-->
    <!--                </div>-->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
    <!--    </div>-->

<?php get_footer(); ?>