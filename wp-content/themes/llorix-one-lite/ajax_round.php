<?php $number='20';?>
<?php foreach ($latest_books as $post): ?>
    <?php $round_val= get_cfc_meta( 'round_number', $post ->ID ); ?>
   <?php if ($round_val[0]['round_number_field']== $number): ?>
        <?php  $meta_values = get_cfc_meta( 'mecze', $post ->ID ); ?>
            <h3><span>III Liga</span> <span id="matchNumber" data-number="<?php echo $round_val[0]['round_number_field']; ?>"><span class="downRound glyphicon glyphicon-chevron-left"></span><span class="ajaxChangeNumber"><?php echo $round_val[0]['round_number_field']; ?></span>. Kolejka<span class="upRound glyphicon glyphicon-chevron-right"></span></span></h3>
            <div id="matchesLoad">
            <?php foreach ($meta_values as $match):  ?>
                <div class="single-match">
                    <div class="team-name">
                        <p><?php  echo $match['team_home'] ?></p>
                        <img  src="<?php $url=wp_get_attachment_image_src($match['home_logo']); echo $url[0]; ?>">
                    </div>
                    <div class="matches-score">
                        <p><?php  echo $match['sets_home'].':'.$match['sets_guest']; ?></p>
                    </div>
                    <div class="team-name team-name-right">
                        <img  src="<?php $url=wp_get_attachment_image_src($match['guest_logo']); ; echo $url[0]; ?>">
                        <p><?php  echo $match['team_guest'] ?></p>
                    </div>
                </div>
            <?php  endforeach; ?>
            </div>
    <?php  endif; ?>
<?php  endforeach; ?>



