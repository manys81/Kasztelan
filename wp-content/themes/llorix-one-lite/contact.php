<?php
/**
 * Template Name: Kontakt
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $id = get_the_ID();
    $post=get_post($id);
    $fields = get_fields($post->ID);
    ?>
    <div class="container contact-page">
        <h2 class=""><?php the_title(); ?></h2>
        <p><?php echo $post -> post_content; ?></p>
        <div class="row custom-form  col-md-6 ">
            <?php echo do_shortcode('[contact-form-7 id="444" title="Kontakt"]'); ?>
        </div>
        <div style="width:100%;height:400px" id="map">
            <div class="marker"  data-lat="<?php echo $fields['google_map']['lat']; ?>" data-lng="<?php echo $fields['google_map']['lng']; ?>"></div>
        </div>
    </div>

<?php endwhile; ?>


<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgQ63Nq0mdmslDPJiSBOyVJ9DAvdNiHJ0&callback=initMap">
</script>
<?php wp_enqueue_script('google_map',THMJS.'vendor/google-map.js',array(),'0.1',true); ?>
<?php get_footer(); ?>
