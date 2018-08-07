<?php
/**
 * Template Name: Mini
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<?php
$images = get_cfc_meta( 'images', $post->ID );
?>
<?php get_header(); ?>
<div class="container container-fluid">
    <?php  wp_enqueue_style('blueimp',THMCSS.'blueimp-gallery.min.css'); ?>
    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
    </div>

    <div id="links" class="container">
        <?php foreach ($images as $i): ?>
            <a href="<?php echo wp_get_attachment_image_src($i['zdjeciee'], 'large')[0]; ?>">
                <img  src="<?php $url=wp_get_attachment_image_src($i['zdjeciee'], 'large'); echo $url[0]; ?>">
            </a>
        <?php endforeach; ?>
    </div>
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
<?php get_footer(); ?>
