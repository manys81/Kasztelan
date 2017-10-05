<?php
/**
 * Template Name: Plazowka
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
<div id="plazowka">
    <div id="plazowka-form" class="custom-form">
        <div class="container contact-page" id="plazowka">
            <h3 style="font-size: 35px; color: #0A3C64;">Formularz zgłoszeniowy</h3>
            <?php echo do_shortcode('[contact-form-7 id="1555" title="GrandPrix_3"]'); ?>
        </div>
    </div>
</div>


<?php endwhile; ?>

<?php get_footer(); ?>
