<?php
class Quicks_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth, $args) {
        global $wp_query;
        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
        $attributes .= ' class="noUnderline" ';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= '<section>';
        $item_output .= '<h2 class="wow fadeInUp">';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</h2>';
        $item_output .= '<p class="hidden-xs hidden-sm wow fadeInUp" data-wow-delay="500ms">' . $item->description . ' </p>';
        $item_output .= '</section>';
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}