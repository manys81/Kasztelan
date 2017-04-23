<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $id = get_the_ID();
    $post=get_post($id);
    $fields = get_fields($post->ID);
    ?>
    <div class="container post-page">
        <h3 class=""><?php the_title(); ?></h3>
        <?php if ( has_post_thumbnail() ) : ?>
            <img src="<?php the_post_thumbnail_url(); ?>"/>
        <?php endif; ?>
        <p><?php echo $post -> post_content; ?></p>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>