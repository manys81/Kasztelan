<?php
/**
 * Template Name: News
 **/
?>

<?php get_header(); ?>

<?php if ( have_posts() ): ?>
    <?php $thumb_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full' );?>

        <div class="container news-page">
            <h2 class="animated fadeInUp"><?= get_the_title( );  ?></h2>

            <div class="row equal-heights">
                <?php
                $temp = $wp_query;
                $wp_query = null;
                $wp_query = new WP_Query();
                $wp_query->query('showposts=15&paged='.$paged);

                while ($wp_query->have_posts()) : $wp_query->the_post();
                ?>
                    <?php $fields = get_fields($post->ID);?>
                    <div class="col-md-4 col-sm-6 animated fadeInUp">
                        <a class='single-article-link' href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                         <?php if ( has_post_thumbnail() ) : ?>
                             <div class="article-img-box">
                                 <img src="<?php the_post_thumbnail_url(); ?>"/>
                                 <span class="box-shadow-img"></span>
                             </div>
                             <h3><?php echo $fields['post_title']; ?></h3>
                             <p><?php echo $fields['short_description']; ?></p>
                             <p><?php echo str_replace('-','/',(date('d-m-Y', strtotime(substr($post->post_date,0,10))))); ?></p>
                         <?php endif; ?>
                        </a>

                    </div>

                <?php endwhile; ?>
                <div id="pagination">
                    <div><?php previous_posts_link( 'Pokaż nowsze' ); ?></div>
                    <div><?php next_posts_link( 'Pokaż starsze' ); ?></div>
                </div>


            </div>
        </div>



<?php endif; ?>

<?php
$wp_query = null;
$wp_query = $temp;  // Reset
?>
<?php get_footer(); ?>
