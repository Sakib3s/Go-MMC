<?php

defined('ABSPATH') || exit;

use GoMMC_Theme_Helper as GoMMC;

/**
 * The Full-width template
 *
 * @package gommc
 * @since 1.0.0
 */

get_header();
the_post();

$sb = GoMMC::get_sidebar_data();
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '';

// Render
echo '<div class="tpc-container full-width', apply_filters('gommc/container/class', esc_attr( $container_class )), '">';
echo '<div class="row', apply_filters('gommc/row/class', esc_attr( $row_class )), '">';

    echo '<div id="main-content" class="tpc_col-', apply_filters('gommc/column/class', esc_attr( $column )), '">';

        the_content(esc_html__('Read more!', 'gommc'));

        // Pagination
        wp_link_pages(GoMMC::pagination_wrapper());

        if (comments_open() || get_comments_number()) {
            comments_template();
        }

    echo '</div>';

    if ($sb) {
        GoMMC::render_sidebar($sb);
    }

echo '</div>';
echo '</div>';

get_footer();
