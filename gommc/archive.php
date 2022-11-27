<?php

defined('ABSPATH') || exit;

use GoMMC_Theme_Helper as GoMMC;

/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gommc
 * @author MMC 
 * @since 1.0.0
 */

// Taxonomies
$tax_obj = get_queried_object();
$term_id = $tax_obj->term_id ?? '';
$tax_description = false;
 if ($term_id) {
    $taxonomies[] = $tax_obj->taxonomy . ': ' . $tax_obj->slug;
    $tax_description = $tax_obj->description;
}

// Sidebar parameters
$sb = GoMMC::get_sidebar_data('blog_list');
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '';

// Render
get_header();

echo '<div class="tpc-container', apply_filters('gommc/container/class', esc_attr( $container_class )), '">';
echo '<div class="row', apply_filters('gommc/row/class', $row_class), '">';
    echo '<div id="main-content" class="tpc_col-', apply_filters('gommc/column/class', esc_attr( $column )), '">';

        if ($term_id) { ?>
            <div class="archive__heading">
                <h4 class="archive__tax_title"><?php
                    echo get_the_archive_title(); ?>
                </h4>
                <?php
                if (!empty($tax_description)) {
                    echo '<div class="archive__tax_description">' . esc_html($tax_description) . '</div>';
                }
                ?>
            </div><?php
        }

        // Blog Archive Template
        get_template_part('templates/post/posts-list');

        echo GoMMC::pagination();

    echo '</div>';

    $sb && GoMMC::render_sidebar($sb);

echo '</div>';
echo '</div>';

get_footer();
