<?php

defined('ABSPATH') || exit;

use GoMMC_Theme_Helper as GoMMC;

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gommc
 * @since 1.0.0
 */

get_header();
the_post();

$sb = GoMMC::get_sidebar_data();
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '';
$container_class = $sb['container_class'] ?? '';

// Render
echo '<div class="tpc-container', apply_filters('gommc/container/class', esc_attr( $container_class )), '">';
echo '<div class="row ', apply_filters('gommc/row/class', esc_attr( $row_class )), '">';

    echo '<div id="main-content" class="tpc_col-', apply_filters('gommc/column/class', esc_attr( $column )), '">';

        the_content(esc_html__('Read more!', 'gommc'));

        // Pagination
        wp_link_pages(GoMMC::pagination_wrapper());

        // Comments
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
