<?php
/**
 * Template Name: Rozgrywki
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php
    include_once("single-matches.php");
?>
    <?php $args = array(
        'category_name' =>'report',
        'posts_per_page'   => 15,
    );
    $reports = get_posts( $args );
    ?>
    <div id="rozgrywki-page">
        <div class="container table-matches-container margin-top">
            <div class="matches-container rozgrywki-page">
                <h3><span>LUMKS Kasztelan Rozprza</span> <span>Spotkania: 2016/2017</span></h3>
            <?php foreach ( $wynik=array_reverse($latest_books) as $post): ?>
                <?php $round_val= get_cfc_meta( 'round_number', $post ->ID ); ?>
                <?php  $meta_values = get_cfc_meta( 'mecze', $post ->ID ); ?>
<!--                    <a>-->
                <?php foreach ($meta_values as $match): ?>
                    <?php $report_status = false; ?>

                    <?php if($match['team_home']=='LUMKS Kasztelan Rozprza'): ?>
                        <?php foreach($reports as $report): ?>
                            <?php $team_name = get_field('compare_team',$report->ID); ?>
                            <?php $wyjazdowy = get_field('wyjazdowy',$report->ID); ?>

                            <?php if(($match['team_guest']==$team_name) && (!$wyjazdowy)):?>
                               <a href="<?php the_permalink($report); ?>">
                                   <div class="single-match">
                                       <div class="team-name">
                                           <p><?php  echo $match['team_home'] ?></p>
                                           <img  src="<?php $url=wp_get_attachment_image_src($match['home_logo']); echo $url[0]; ?>">
                                       </div>
                                       <div class="matches-score">
                                           <p><?php if($match['sets_home']!=''){ echo $match['sets_home'].':'.$match['sets_guest']; } else{ echo '-:-';} ?></p>
                                           <?php if($match['sets_point']): ?> <p>(<?php echo $match['sets_point']; ?>)</p><?php endif; ?>
                                       </div>
                                       <div class="team-name team-name-right">
                                           <img  src="<?php $url=wp_get_attachment_image_src($match['guest_logo']); ; echo $url[0]; ?>">
                                           <p><?php  echo $match['team_guest'] ?></p>
                                       </div>
                                   </div>
                                </a>
                                <?php $report_status= true ?>
                            <?php endif; ?>
                        <?php endforeach;?>

                    <?php elseif($match['team_guest']=='LUMKS Kasztelan Rozprza'): ?>
                        <?php foreach($reports as $report): ?>
                            <?php $team_name = get_field('compare_team',$report->ID); ?>
                            <?php $wyjazdowy = get_field('wyjazdowy',$report->ID); ?>

                            <?php if(($match['team_home']==$team_name) && ($wyjazdowy)):?>
                                <a href="<?php the_permalink($report); ?>">
                                    <div class="single-match">
                                        <div class="team-name">
                                            <p><?php  echo $match['team_home'] ?></p>
                                            <img  src="<?php $url=wp_get_attachment_image_src($match['home_logo']); echo $url[0]; ?>">
                                        </div>
                                        <div class="matches-score">
                                            <p><?php if($match['sets_home']!=''){ echo $match['sets_home'].':'.$match['sets_guest']; } else{ echo '-:-';} ?></p>
                                            <?php if($match['sets_point']): ?> <p>(<?php echo $match['sets_point']; ?>)</p><?php endif; ?>
                                        </div>
                                        <div class="team-name team-name-right">
                                            <img  src="<?php $url=wp_get_attachment_image_src($match['guest_logo']); ; echo $url[0]; ?>">
                                            <p><?php  echo $match['team_guest'] ?></p>
                                        </div>
                                    </div>
                                </a>
                                <?php $report_status= true ?>
                            <?php endif; ?>
                        <?php endforeach;?>
                    <?php endif; ?>

                    <?php if((($match['team_guest']=='LUMKS Kasztelan Rozprza') || ($match['team_home']=='LUMKS Kasztelan Rozprza')) && (!$report_status)): ?>

                        <div class="single-match">
                            <div class="team-name">
                                <p><?php  echo $match['team_home'] ?></p>
                                <img  src="<?php $url=wp_get_attachment_image_src($match['home_logo']); echo $url[0]; ?>">
                            </div>
                            <div class="matches-score">
                                <p><?php if($match['sets_home']!=''){ echo $match['sets_home'].':'.$match['sets_guest']; } else{ echo '-:-';} ?></p>
                                <?php if($match['sets_point']): ?> <p>(<?php echo $match['sets_point']; ?>)</p><?php endif; ?>
                            </div>
                            <div class="team-name team-name-right">
                                <img  src="<?php $url=wp_get_attachment_image_src($match['guest_logo']); ; echo $url[0]; ?>">
                                <p><?php  echo $match['team_guest'] ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php  endforeach; ?>
            <?php  endforeach; ?>
            </div>
        </div>
    <div class="table-matches-container margin-top container">
        <div class="custom-table table-responsive">
            <h3><span>III Liga Mężczyzn</span> <span>Tabela</span></h3>
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
    <div class="table-matches-container margin-top container rozgrywki-page">
        <?php foreach ($latest_books as $post): ?>
        <div class="matches-container">
            <?php $round_val= get_cfc_meta( 'round_number', $post ->ID ); ?>
                <?php  $meta_values = get_cfc_meta( 'mecze', $post ->ID ); ?>
                <h3 class="js-collapse"><span><?php echo $round_val[0]['round_number_field']; ?>. Kolejka</span><span class="match-date"><?php echo $round_val[0]['data-meczu']; ?><span class="glyphicon "></span></span></h3>
                <?php foreach ($meta_values as $match): ?>
                    <div class="js-show-hide">
                    <div class="single-match">
                        <div class="team-name">
                            <p><?php  echo $match['team_home'] ?></p>
                            <img  src="<?php $url=wp_get_attachment_image_src($match['home_logo']); echo $url[0]; ?>">
                        </div>
                        <div class="matches-score">
                            <p><?php if($match['sets_home']!=''){ echo $match['sets_home'].':'.$match['sets_guest']; } else{ echo '-:-';} ?></p>
                           <?php if($match['sets_point']): ?> <p>(<?php echo $match['sets_point']; ?>)</p><?php endif; ?>
                        </div>
                        <div class="team-name team-name-right">
                            <img  src="<?php $url=wp_get_attachment_image_src($match['guest_logo']); ; echo $url[0]; ?>">
                            <p><?php  echo $match['team_guest'] ?></p>
                        </div>
                    </div>
                    </div>
                <?php  endforeach; ?>
        </div>
        <?php  endforeach; ?>
    </div>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>
