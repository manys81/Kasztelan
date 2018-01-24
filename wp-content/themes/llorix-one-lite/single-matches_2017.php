<?php
$team = get_cfc_meta( 'teams_seson', 1623 );
$i=0;
$teams=[];
foreach ($team as $t){
    $i++;
    array_push($teams,$t['druzyna']);
}
foreach ($teams as $team){
    $table[$team]=array(
        'points'=>'',
        'sets_plus'=>'',
        'sets_minus'=>'',
        'sets_ratio'=>'',
        'points_plus'=>'',
        'name'=>'',
        'match_count'=>'',
        'points_minus'=>'');
}

$args = array(
    'post_type'   => 'matches',
    'category_name' =>'single_round_2017',
    'posts_per_page'   => 25,
    'post_status'      => 'private'
);
$latest_books = get_posts( $args );
$table_big = array();
foreach ($latest_books as $post){
    $round_val= get_cfc_meta( 'round_number', $post ->ID );
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
        'numer' => $round_val[0]['round_number_field'],
        'mecze' => $round
    );


}
foreach ($table1 as $match){
    foreach ($match['mecze'] as $single_match){
        $wynik = explode(",", $single_match['sets']);

        if($single_match['score_home']==3 && ($single_match['score_guest']==0 || $single_match['score_guest']==1)){
            $table[$single_match['guest_team']]['points'] +=0;
            $table[$single_match['home_team']]['points'] +=3;
            $table[$single_match['home_team']]['match_count']++;
            $table[$single_match['guest_team']]['match_count']++;
        }
        elseif ($single_match['score_guest']==3 && ($single_match['score_home']==0 || $single_match['score_home']==1)){
            $table[$single_match['guest_team']]['points'] +=3;
            $table[$single_match['home_team']]['points'] +=0;
            $table[$single_match['home_team']]['match_count']++;
            $table[$single_match['guest_team']]['match_count']++;
        }
        elseif ($single_match['score_guest']==3 && $single_match['score_home']==2){
            $table[$single_match['guest_team']]['points'] +=2;
            $table[$single_match['home_team']]['points'] +=1;
            $table[$single_match['home_team']]['match_count']++;
            $table[$single_match['guest_team']]['match_count']++;
        }
        elseif ($single_match['score_guest']==2 && $single_match['score_home']==3){
            $table[$single_match['guest_team']]['points'] +=1;
            $table[$single_match['home_team']]['points'] +=2;
            $table[$single_match['home_team']]['match_count']++;
            $table[$single_match['guest_team']]['match_count']++;
        }

        $table[$single_match['guest_team']]['sets_plus']+=$single_match['score_guest'];
        $table[$single_match['guest_team']]['sets_minus']+=$single_match['score_home'];
        $table[$single_match['home_team']]['sets_plus']+=$single_match['score_home'];
        $table[$single_match['home_team']]['sets_minus']+=$single_match['score_guest'];
        foreach ($wynik as $set){
            $one_site = explode(":", $set);
            $table[$single_match['home_team']]['points_plus']+=$one_site[0];
            $table[$single_match['home_team']]['points_minus']+=$one_site[1];
            $table[$single_match['guest_team']]['points_plus']+=$one_site[1];
            $table[$single_match['guest_team']]['points_minus']+=$one_site[0];

        }
    }
}
foreach ($teams as $team){
    if($table[$team]['sets_minus']==0){
        $table[$team]['sets_ratio']= $table[$team]['sets_plus']/0.1 - 0.00001;
        $table[$team]['name']=$team;
    }
    else{
        $table[$team]['sets_ratio']= $table[$team]['sets_plus']/$table[$team]['sets_minus'];
        $table[$team]['name']=$team;
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

