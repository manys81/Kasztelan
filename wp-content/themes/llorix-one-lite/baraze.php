<?php
/**
 * Template Name: Polfinal
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
        'category_name' =>'olsztyn-polfinal',
        'posts_per_page'   => 3,
        'post_status'      => 'private',
        'order'         =>'ASC'
    );
    $final = get_posts( $args );

    $teams=[ 'LUMKS Kasztelan Rozprza', 'KPS Olsztyn' , 'SUKSS Suwałki', 'MKS MDK Warszawa'];

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
        $table1[]=array(
            'mecze' => $round
        );
    }

foreach ($table1 as $match) {
    foreach ($match['mecze'] as $single_match) {
        $wynik = explode(",", $single_match['sets']);

        if ($single_match['score_home'] == 3 && ($single_match['score_guest'] == 0 || $single_match['score_guest'] == 1)) {
            $table[$single_match['guest_team']]['points'] += 1;
            $table[$single_match['home_team']]['points'] += 2;
            $table[$single_match['home_team']]['match_count']++;
            $table[$single_match['guest_team']]['match_count']++;
        } elseif ($single_match['score_guest'] == 3 && ($single_match['score_home'] == 0 || $single_match['score_home'] == 1)) {
            $table[$single_match['guest_team']]['points'] += 2;
            $table[$single_match['home_team']]['points'] += 1;
            $table[$single_match['home_team']]['match_count']++;
            $table[$single_match['guest_team']]['match_count']++;
        } elseif ($single_match['score_guest'] == 3 && $single_match['score_home'] == 2) {
            $table[$single_match['guest_team']]['points'] += 2;
            $table[$single_match['home_team']]['points'] += 1;
            $table[$single_match['home_team']]['match_count']++;
            $table[$single_match['guest_team']]['match_count']++;
        } elseif ($single_match['score_guest'] == 2 && $single_match['score_home'] == 3) {
            $table[$single_match['guest_team']]['points'] += 1;
            $table[$single_match['home_team']]['points'] += 2;
            $table[$single_match['home_team']]['match_count']++;
            $table[$single_match['guest_team']]['match_count']++;
        }

        $table[$single_match['guest_team']]['sets_plus'] += $single_match['score_guest'];
        $table[$single_match['guest_team']]['sets_minus'] += $single_match['score_home'];
        $table[$single_match['home_team']]['sets_plus'] += $single_match['score_home'];
        $table[$single_match['home_team']]['sets_minus'] += $single_match['score_guest'];
        foreach ($wynik as $set) {
            $one_site = explode(":", $set);
            $table[$single_match['home_team']]['points_plus'] += $one_site[0];
            $table[$single_match['home_team']]['points_minus'] += $one_site[1];
            $table[$single_match['guest_team']]['points_plus'] += $one_site[1];
            $table[$single_match['guest_team']]['points_minus'] += $one_site[0];

        }
    }
}

    foreach ($teams as $team){
        if($table[$team]['sets_minus']==0){
            $table[$team]['sets_ratio']= $table[$team]['sets_plus']/0.1;
            $table[$team]['name']=$team;
        }
        else{
            $table[$team]['sets_ratio']= $table[$team]['sets_plus']/$table[$team]['sets_minus'];
            $table[$team]['name']=$team;
        }
        if(empty($table[$team]['match_count'])){
            $table[$team]['match_count']=0;
        }
        if(empty($table[$team]['match_count'])){
            $table[$team]['points']=0;
        }
    }

    function cmp($a, $b)
    {
        if( $b['points'] == $a['points']){
            return ($b['sets_ratio'] > $a['sets_ratio'])? 1:-1;
        }

        return $b['points'] - $a['points'] ;
    }
    usort($table, "cmp");
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

<?php get_footer(); ?>
