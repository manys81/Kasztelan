<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
  <?php
    $id = get_the_ID();
    $post=get_post($id);
    $fields = get_fields($post->ID);
    $category=in_category('galeria');

    ?>
        <?php if(!$category): ?>
        <div class="container post-page">
            <div class="col-md-8">
                <h2 class=""><?php the_title(); ?></h2>
                    <?php if ( has_post_thumbnail() ) : ?>
                         <img src="<?php the_post_thumbnail_url(); ?>"/>
                     <?php endif; ?>
                <p><?php echo $post -> post_content; ?></p>
                <div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>&amp;src=sdkpreparse">Udostępnij</a></div>
            </div>
            <div class="col-md-4">
                <?php
                $posts=get_posts(array(
                    'posts_per_page' => '5',
                    'exclude' => $post -> ID
                ));
                ?>
                <h4 class="post_others">Aktualności</h4>
                <ul class=" posts-others-list">
                    <?php foreach ($posts as $p):?>
                    <li><a href="<?php echo get_permalink($p)?>"><?php echo get_the_title($p)?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
            <?php if(in_category('5') || in_category('38')): ?>
                <div class="post-page-report">
                    <div class="container">
                        <div class="match-raport-main">
                            <div class="team-name-raport">
                                <img  src="<?php echo get_template_directory_uri (); ?>/images/kasztelan_logo_small.png">
                                <p>LUMKS Kasztelan Rozprza</p>
                            </div>
                            <div class="result-report">
                                <p><?php echo $fields['raport_sets_us'].':'.$fields['raport_sets_opp']; ?></p>
                                <p>(<?php echo $fields['raport_score']; ?>)</p>
                            </div>
                            <div class="team-name-raport team-name-raport-right">
                                <img src="<?php echo $fields['compare_team_img']; ?>"/>
                                <p><?php echo $fields['compare_team']; ?> </p>
                            </div>
                        </div>
                        <table class="match-raport-table">
                            <tbody>
                                <tr >
                                    <td><span <?php if ($fields['spikes']>$fields['spikes_op']): ?>class="green"<?php endif; ?> style="width: <?php echo $fields['spikes']; ?>%;"><?php echo $fields['spikes']; ?></span></td>
                                    <td><span>Ataki</span></td>
                                    <td><span <?php if ($fields['spikes']<$fields['spikes_op']): ?>class="green"<?php endif; ?> style="width: <?php echo $fields['spikes_op']; ?>%"><?php echo $fields['spikes_op']; ?></span></td>
                                </tr>
                                <tr>
                                    <td><span <?php if ($fields['blocks']>$fields['blocks_op']): ?>class="green"<?php endif; ?> style="width: <?php echo 2*$fields['blocks']; ?>%;"><?php echo $fields['blocks']; ?></span></td>
                                    <td><span>Bloki</span></td>
                                    <td><span <?php if ($fields['blocks']<$fields['blocks_op']): ?>class="green"<?php endif; ?> style="width: <?php echo 2*$fields['blocks_op']; ?>%;"><?php echo $fields['blocks_op']; ?></span></td>
                                </tr>
                                <tr>
                                    <td><span <?php if ($fields['ases']>$fields['ases_op']): ?>class="green"<?php endif; ?> style="width: <?php echo 2*$fields['ases']; ?>%;"><?php echo $fields['ases']; ?></span></td>
                                    <td><span>Asy</span></td>
                                    <td><span <?php if ($fields['ases']<$fields['ases_op']): ?>class="green"<?php endif; ?> style="width: <?php echo 2*$fields['ases_op']; ?>%;"><?php echo $fields['ases_op']; ?></span></td>
                                </tr>
                                <tr>
                                    <td><span <?php if ($fields['opp_errors']>$fields['errors']): ?>class="green"<?php endif; ?> style="width: <?php echo 2*$fields['opp_errors']; ?>%;"><?php echo $fields['opp_errors']; ?></span></td>
                                    <td><span>Błędy rzeciwnika</span></td>
                                    <td><span <?php if ($fields['opp_errors']<$fields['errors']): ?>class="green"<?php endif; ?> style="width: <?php echo 2*$fields['errors']; ?>%;"><?php echo $fields['errors']; ?></span></td>
                                </tr>
                                <tr>
                                    <td><span <?php if ($fields['total_points']>$fields['total_points_op']): ?>class="green"<?php endif; ?> style="width: <?php echo round(100*$fields['total_points']/125); ?>%;"><?php echo $fields['total_points']; ?></span></td>
                                    <td><span>Razem</span></td>
                                    <td><span <?php if ($fields['total_points']<$fields['total_points_op']): ?>class="green"<?php endif; ?> style="width: <?php echo round(100*$fields['total_points_op']/125); ?>%;"><?php echo $fields['total_points_op']; ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            <?php endif; ?>
            <div class="container comments-box">
                <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                    wp_enqueue_script('validate',THMJS.'jquery.validate.min.js',array(),'2016-04-15',true);
                    wp_enqueue_script('comments',THMJS.'comments.js',array(),'2016-04-15',true);
                       endif; ?>
            </div>
    <?php else: ?>

        <h2 class="container gallery-title"><?php the_title(); ?></h2>
        <?php  wp_enqueue_style('blueimp',THMCSS.'blueimp-gallery.min.css'); ?>
        <div id="blueimp-gallery" class="blueimp-gallery">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
        </div>
        <div id="links" class="container">
            <?php echo $post -> post_content; ?>
        </div>
        <div class="container">
            <div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>&amp;src=sdkpreparse">Udostępnij</a></div>
        </div>
        <div class="container comments-box">
            <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
                wp_enqueue_script('validate',THMJS.'jquery.validate.min.js',array(),'2016-04-15',true);
                wp_enqueue_script('comments',THMJS.'comments.js',array(),'2016-04-15',true);
            endif; ?>
        </div>
        <?php   wp_enqueue_script('blueimp',THMJS.'vendor/blueimp-gallery.min.js',array(),'2.16.0',true); ?>
        <script>
            document.getElementById('links').onclick = function (event) {
                event = event || window.event;
                var target = event.target || event.srcElement,
                    link = target.src ? target.parentNode : target,
                    options = {index: link, event: event},
                    links = this.getElementsByTagName('a');
                blueimp.Gallery(links, options);
            };
            jQuery(window).load(function() {
                // Animate loader off screen
                jQuery(".se-pre-con").fadeOut("slow");
            });
        </script>
    <?php endif; ?>
<?php endwhile; ?>

<?php //$args = array(
//    'post_ID' => '140' // ignored (use post_id instead)
//);
//$comments1 = get_comments( $args );
//foreach($comments1 as $comment){
//    $author = get_comment_author( $comment );
//    d($_COOKIE['comment_author_'.COOKIEHASH]);
//    d($comment);
//}
// ?>
<?php get_footer(); ?>
