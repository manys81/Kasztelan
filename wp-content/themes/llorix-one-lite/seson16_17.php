<?php
/**
 * Template Name: Sezon 2016/17
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $args = array(
        'post_type'   => 'matches',
        'category_name' =>'leszno-final',
        'posts_per_page'   => 3,
        'post_status'      => 'private',
        'order'         =>'ASC'
    );
    $final_leszno = get_posts( $args );

    $teams_leszno=[ 'LUMKS Kasztelan Rozprza', 'Klima Błażowa' , 'UKS 9 Leszno', 'MUKS Michałkowice'];

    foreach ($final_leszno as $post){
        $meta_values = get_cfc_meta( 'mecze', $post ->ID );
        unset($round);
        foreach ($meta_values as $mecz){
            $round[]=array(
                'home_team' => $mecz['team_home'],
                'home_team_url' => $mecz['home_logo'],
                'guest_team' => $mecz['team_guest'],
                'guest_team_url' => $mecz['guest_logo'],
                'score_home' => $mecz['sets_home'],
                'score_guest' => $mecz['sets_guest'],
                'sets' => $mecz['sets_point']
            );
        }
        $table4[]=array(
            'mecze' => $round
        );
    }

    foreach ($table4 as $match) {
        foreach ($match['mecze'] as $single_match) {
            $wynik = explode(",", $single_match['sets']);

            if ($single_match['score_home'] == 3 && ($single_match['score_guest'] == 0 || $single_match['score_guest'] == 1)) {
                $table_leszno[$single_match['guest_team']]['points'] += 1;
                $table_leszno[$single_match['home_team']]['points'] += 2;
                $table_leszno[$single_match['home_team']]['match_count']++;
                $table_leszno[$single_match['guest_team']]['match_count']++;
            } elseif ($single_match['score_guest'] == 3 && ($single_match['score_home'] == 0 || $single_match['score_home'] == 1)) {
                $table_leszno[$single_match['guest_team']]['points'] += 2;
                $table_leszno[$single_match['home_team']]['points'] += 1;
                $table_leszno[$single_match['home_team']]['match_count']++;
                $table_leszno[$single_match['guest_team']]['match_count']++;
            } elseif ($single_match['score_guest'] == 3 && $single_match['score_home'] == 2) {
                $table_leszno[$single_match['guest_team']]['points'] += 2;
                $table_leszno[$single_match['home_team']]['points'] += 1;
                $table_leszno[$single_match['home_team']]['match_count']++;
                $table_leszno[$single_match['guest_team']]['match_count']++;
            } elseif ($single_match['score_guest'] == 2 && $single_match['score_home'] == 3) {
                $table_leszno[$single_match['guest_team']]['points'] += 1;
                $table_leszno[$single_match['home_team']]['points'] += 2;
                $table_leszno[$single_match['home_team']]['match_count']++;
                $table_leszno[$single_match['guest_team']]['match_count']++;
            }

            $table_leszno[$single_match['guest_team']]['sets_plus'] += $single_match['score_guest'];
            $table_leszno[$single_match['guest_team']]['sets_minus'] += $single_match['score_home'];
            $table_leszno[$single_match['home_team']]['sets_plus'] += $single_match['score_home'];
            $table_leszno[$single_match['home_team']]['sets_minus'] += $single_match['score_guest'];
            foreach ($wynik as $set) {
                $one_site = explode(":", $set);
                $table_leszno[$single_match['home_team']]['points_plus'] += $one_site[0];
                $table_leszno[$single_match['home_team']]['points_minus'] += $one_site[1];
                $table_leszno[$single_match['guest_team']]['points_plus'] += $one_site[1];
                $table_leszno[$single_match['guest_team']]['points_minus'] += $one_site[0];

            }
        }
    }

    foreach ($teams_leszno as $team){
        if($table_leszno[$team]['sets_minus']==0){
            $table_leszno[$team]['sets_ratio']= $table_leszno[$team]['sets_plus']/0.1;
            $table_leszno[$team]['name']=$team;
        }
        else{
            $table_leszno[$team]['sets_ratio']= $table_leszno[$team]['sets_plus']/$table_leszno[$team]['sets_minus'];
            $table_leszno[$team]['name']=$team;
        }
        if(empty($table_leszno[$team]['match_count'])){
            $table_leszno[$team]['match_count']=0;
        }
        if(empty($table_leszno[$team]['match_count'])){
            $table_leszno[$team]['points']=0;
        }
    }

    function cmp1($a, $b)
    {
        if( $b['points'] == $a['points']){
            return ($b['sets_ratio'] > $a['sets_ratio'])? 1:-1;
        }

        return $b['points'] - $a['points'] ;
    }
    usort($table_leszno, "cmp1");
    ?>

    <div id="rozgrywki-page">
        <h2 class="container"> Turniej finałowy o awans do II Ligi</h2>
        <div class="table-matches-container margin-top container">
            <div class="custom-table table-responsive">
                <h3><span>III Liga Mężczyzn Finały</span> <span>Tabela</span></h3>
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
                    <?php foreach ($table_leszno as $team): ?>
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
            <?php foreach ($final_leszno as $post): ?>
                <div class="matches-container">
                    <?php $round_val= get_cfc_meta( 'round_number', $post ->ID );?>
                    <?php  $meta_values = get_cfc_meta( 'mecze', $post ->ID );?>
                    <h3><span><?php echo $post -> post_title; ?></span><span class="match-date"><?php echo $round_val[0]['data-meczu']; ?><span class="glyphicon "></span></span></h3>
                    <?php $i=0; ?>
                    <?php foreach ($meta_values as $match): ?>
                        <div>
                            <div class="single-match final-match">
                                <div class="final-time">
                                    <p><?php if($i==0) echo $round_val[0]['godzina-meczu']; else echo $round_val[0]['godzina-drugiego-meczu']; ?></p>
                                </div>
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
                        <?php $i++; ?>
                    <?php  endforeach; ?>
                </div>
            <?php  endforeach; ?>
        </div>
    </div>
    <?php unset($table_leszno); ?>
<?php endwhile; ?>
<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $args = array(
        'post_type'   => 'matches',
        'category_name' =>'olsztyn-polfinal',
        'posts_per_page'   => 3,
        'post_status'      => 'private',
        'order'         =>'ASC'
    );
    $final_baraze = get_posts( $args );

    $teams_baraze=[ 'LUMKS Kasztelan Rozprza', 'KPS Olsztyn' , 'SUKSS Suwałki', 'MKS MDK Warszawa'];

    foreach ($final_baraze as $post){
        $meta_values = get_cfc_meta( 'mecze', $post ->ID );
        unset($round);
        foreach ($meta_values as $mecz){
            $round[]=array(
                'home_team' => $mecz['team_home'],
                'home_team_url' => $mecz['home_logo'],
                'guest_team' => $mecz['team_guest'],
                'guest_team_url' => $mecz['guest_logo'],
                'score_home' => $mecz['sets_home'],
                'score_guest' => $mecz['sets_guest'],
                'sets' => $mecz['sets_point']
            );
        }
        $table_3[]=array(
            'mecze' => $round
        );
    }
    foreach ($table_3 as $match) {
        foreach ($match['mecze'] as $single_match) {
            $wynik = explode(",", $single_match['sets']);

            if ($single_match['score_home'] == 3 && ($single_match['score_guest'] == 0 || $single_match['score_guest'] == 1)) {
                $table_baraze[$single_match['guest_team']]['points'] += 1;
                $table_baraze[$single_match['home_team']]['points'] += 2;
                $table_baraze[$single_match['home_team']]['match_count']++;
                $table_baraze[$single_match['guest_team']]['match_count']++;
            } elseif ($single_match['score_guest'] == 3 && ($single_match['score_home'] == 0 || $single_match['score_home'] == 1)) {
                $table_baraze[$single_match['guest_team']]['points'] += 2;
                $table_baraze[$single_match['home_team']]['points'] += 1;
                $table_baraze[$single_match['home_team']]['match_count']++;
                $table_baraze[$single_match['guest_team']]['match_count']++;
            } elseif ($single_match['score_guest'] == 3 && $single_match['score_home'] == 2) {
                $table_baraze[$single_match['guest_team']]['points'] += 2;
                $table_baraze[$single_match['home_team']]['points'] += 1;
                $table_baraze[$single_match['home_team']]['match_count']++;
                $table_baraze[$single_match['guest_team']]['match_count']++;
            } elseif ($single_match['score_guest'] == 2 && $single_match['score_home'] == 3) {
                $table_baraze[$single_match['guest_team']]['points'] += 1;
                $table_baraze[$single_match['home_team']]['points'] += 2;
                $table_baraze[$single_match['home_team']]['match_count']++;
                $table_baraze[$single_match['guest_team']]['match_count']++;
            }

            $table_baraze[$single_match['guest_team']]['sets_plus'] += $single_match['score_guest'];
            $table_baraze[$single_match['guest_team']]['sets_minus'] += $single_match['score_home'];
            $table_baraze[$single_match['home_team']]['sets_plus'] += $single_match['score_home'];
            $table_baraze[$single_match['home_team']]['sets_minus'] += $single_match['score_guest'];
            foreach ($wynik as $set) {
                $one_site = explode(":", $set);
                $table_baraze[$single_match['home_team']]['points_plus'] += $one_site[0];
                $table_baraze[$single_match['home_team']]['points_minus'] += $one_site[1];
                $table_baraze[$single_match['guest_team']]['points_plus'] += $one_site[1];
                $table_baraze[$single_match['guest_team']]['points_minus'] += $one_site[0];

            }
        }
    }
    foreach ($teams_baraze as $team){
        if($table_baraze[$team]['sets_minus']==0){
            $table_baraze[$team]['sets_ratio']= $table_baraze[$team]['sets_plus']/0.1;
            $table_baraze[$team]['name']=$team;
        }
        else{
            $table_baraze[$team]['sets_ratio']= $table_baraze[$team]['sets_plus']/$table_baraze[$team]['sets_minus'];
            $table_baraze[$team]['name']=$team;
        }
        if(empty($table_baraze[$team]['match_count'])){
            $table_baraze[$team]['match_count']=0;
        }
        if(empty($table_baraze[$team]['match_count'])){
            $table_baraze[$team]['points']=0;
        }
    }

    usort($table_baraze, "cmp1");
    ?>

    <div id="rozgrywki-page">
        <h2 class="container"> Turniej półfinałowy o awans do II Ligi</h2>
        <div class="table-matches-container margin-top container">
            <div class="custom-table table-responsive">
                <h3><span>III Liga Mężczyzn Finały</span> <span>Tabela</span></h3>
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
                    <?php foreach ($table_baraze as $team): ?>
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
            <?php foreach ($final_baraze as $post): ?>
                <div class="matches-container">
                    <?php $round_val= get_cfc_meta( 'round_number', $post ->ID );?>
                    <?php  $meta_values = get_cfc_meta( 'mecze', $post ->ID );?>
                    <h3><span><?php echo $post -> post_title; ?></span><span class="match-date"><?php echo $round_val[0]['data-meczu']; ?><span class="glyphicon "></span></span></h3>
                    <?php $i=0; ?>
                    <?php foreach ($meta_values as $match): ?>
                        <div>
                            <div class="single-match final-match">
                                <div class="final-time">
                                    <p><?php if($i==0) echo $round_val[0]['godzina-meczu']; else echo $round_val[0]['godzina-drugiego-meczu']; ?></p>
                                </div>
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
                        <?php $i++; ?>
                    <?php  endforeach; ?>
                </div>
            <?php  endforeach; ?>
        </div>
    </div>
    <?php unset($table_baraze); ?>
<?php endwhile; ?>
<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $args = array(
        'post_type'   => 'matches',
        'category_name' =>'final_3_liga',
        'posts_per_page'   => 3,
        'post_status'      => 'private',
        'order'         =>'ASC'
    );
    $final = get_posts( $args );

    $teams_final=[ 'LUMKS Kasztelan Rozprza', 'KS SIATKARZ Wieluń' , 'KS HURAGAN Widawa', 'LUKS Dobroń'];

    foreach ($final as $post){
        $meta_values = get_cfc_meta( 'mecze', $post ->ID );
        unset($round);
        foreach ($meta_values as $mecz){
            $round[]=array(
                'home_team' => $mecz['team_home'],
                'home_team_url' => $mecz['home_logo'],
                'guest_team' => $mecz['team_guest'],
                'guest_team_url' => $mecz['guest_logo'],
                'score_home' => $mecz['sets_home'],
                'score_guest' => $mecz['sets_guest'],
                'sets' => $mecz['sets_point']
            );
        }
        $table2[]=array(
            'mecze' => $round
        );
    }

    foreach ($table2 as $match) {
        foreach ($match['mecze'] as $single_match) {
            $wynik = explode(",", $single_match['sets']);

            if ($single_match['score_home'] == 3 && ($single_match['score_guest'] == 0 || $single_match['score_guest'] == 1)) {
                $table_final[$single_match['guest_team']]['points'] += 1;
                $table_final[$single_match['home_team']]['points'] += 2;
                $table_final[$single_match['home_team']]['match_count']++;
                $table_final[$single_match['guest_team']]['match_count']++;
            } elseif ($single_match['score_guest'] == 3 && ($single_match['score_home'] == 0 || $single_match['score_home'] == 1)) {
                $table_final[$single_match['guest_team']]['points'] += 2;
                $table_final[$single_match['home_team']]['points'] += 1;
                $table_final[$single_match['home_team']]['match_count']++;
                $table_final[$single_match['guest_team']]['match_count']++;
            } elseif ($single_match['score_guest'] == 3 && $single_match['score_home'] == 2) {
                $table_final[$single_match['guest_team']]['points'] += 2;
                $table_final[$single_match['home_team']]['points'] += 1;
                $table_final[$single_match['home_team']]['match_count']++;
                $table_final[$single_match['guest_team']]['match_count']++;
            } elseif ($single_match['score_guest'] == 2 && $single_match['score_home'] == 3) {
                $table_final[$single_match['guest_team']]['points'] += 1;
                $table_final[$single_match['home_team']]['points'] += 2;
                $table_final[$single_match['home_team']]['match_count']++;
                $table_final[$single_match['guest_team']]['match_count']++;
            }

            $table_final[$single_match['guest_team']]['sets_plus'] += $single_match['score_guest'];
            $table_final[$single_match['guest_team']]['sets_minus'] += $single_match['score_home'];
            $table_final[$single_match['home_team']]['sets_plus'] += $single_match['score_home'];
            $table_final[$single_match['home_team']]['sets_minus'] += $single_match['score_guest'];
            foreach ($wynik as $set) {
                $one_site = explode(":", $set);
                $table_final[$single_match['home_team']]['points_plus'] += $one_site[0];
                $table_final[$single_match['home_team']]['points_minus'] += $one_site[1];
                $table_final[$single_match['guest_team']]['points_plus'] += $one_site[1];
                $table_final[$single_match['guest_team']]['points_minus'] += $one_site[0];

            }
        }
    }

    foreach ($teams_final as $team){
        if($table_final[$team]['sets_minus']==0){
            $table_final[$team]['sets_ratio']= $table_final[$team]['sets_plus']/0.1;
            $table_final[$team]['name']=$team;
        }
        else{
            $table_final[$team]['sets_ratio']= $table_final[$team]['sets_plus']/$table_final[$team]['sets_minus'];
            $table_final[$team]['name']=$team;
        }
        if(empty($table_final[$team]['match_count'])){
            $table_final[$team]['match_count']=0;
        }
        if(empty($table_final[$team]['match_count'])){
            $table_final[$team]['points']=0;
        }
    }

    usort($table_final, "cmp1");
    ?>

    <div id="rozgrywki-page">
        <h2 class="container"> Turniej finałowy III Ligi Mężczyzn</h2>
        <div class="table-matches-container margin-top container">
            <div class="custom-table table-responsive">
                <h3><span>III Liga Mężczyzn Finały</span> <span>Tabela</span></h3>
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
                    <?php foreach ($table_final as $team): ?>
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
            <?php foreach ($final as $post): ?>
                <div class="matches-container">
                    <?php $round_val= get_cfc_meta( 'round_number', $post ->ID );?>
                    <?php  $meta_values = get_cfc_meta( 'mecze', $post ->ID );?>
                    <h3><span><?php echo $post -> post_title; ?></span><span class="match-date"><?php echo $round_val[0]['data-meczu']; ?><span class="glyphicon "></span></span></h3>
                    <?php $i=0; ?>
                    <?php foreach ($meta_values as $match): ?>
                        <div>
                            <div class="single-match final-match">
                                <div class="final-time">
                                    <p><?php if($i==0) echo $round_val[0]['godzina-meczu']; else echo $round_val[0]['godzina-drugiego-meczu']; ?></p>
                                </div>
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
                        <?php $i++; ?>
                    <?php  endforeach; ?>
                </div>
            <?php  endforeach; ?>
        </div>
    </div>
<?php endwhile; ?>
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
