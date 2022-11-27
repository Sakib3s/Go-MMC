<?php

defined('ABSPATH') || exit;

use GoMMC_Theme_Helper as GoMMC;

/**
 * The template for displaying search result page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package gommc
 * @since 1.0.0
 */

get_header();

$sb = GoMMC::get_sidebar_data('blog_list');
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '';

?>
<div class="tpc-container<?php echo apply_filters('gommc/container/class', esc_attr( $container_class )); ?>">
<div class="row<?php echo apply_filters('gommc/row/class', esc_attr( $row_class )); ?>">
    <div id='main-content' class="tpc_col-<?php echo apply_filters('gommc/column/class', esc_attr( $column )); ?>">
        <?php
        if (have_posts()) :
            echo '<header class="searсh-header">',
                '<h1 class="page-title">',
                    esc_html__('Search Results for: ', 'gommc'),
                    '<span>', get_search_query(), '</span>',
                '</h1>',
            '</header>';

            global $tpc_blog_atts;
            global $wp_query;

            $tpc_blog_atts = [
                'query' => $wp_query,
                // Layout
                'blog_layout' => 'grid',
                'blog_columns' => GoMMC::get_option('blog_list_columns') ?: '12',
                // Appearance
                'hide_media' => GoMMC::get_option('blog_list_hide_media'),
                'hide_content' => GoMMC::get_option('blog_list_hide_content'),
                'hide_blog_title' => GoMMC::get_option('blog_list_hide_title'),
                'hide_all_meta' => GoMMC::get_option('blog_list_meta'),
                'meta_author' => GoMMC::get_option('blog_list_meta_author'),
                'meta_comments' => GoMMC::get_option('blog_list_meta_comments'),
                'meta_categories' => GoMMC::get_option('blog_list_meta_categories'),
                'meta_date' => GoMMC::get_option('blog_list_meta_date'),
                'hide_likes' => !GoMMC::get_option('blog_list_likes'),
                'hide_views' => !GoMMC::get_option('blog_list_views'),
                'hide_share' => !GoMMC::get_option('blog_list_share'),
                'read_more_hide' => GoMMC::get_option('blog_list_read_more'),
                'content_letter_count' => GoMMC::get_option('blog_list_letter_count') ?: '85',
                'read_more_text' => esc_html__('READ MORE', 'gommc'),
                'heading_tag' => 'h3',
                'items_load' => 4,
            ];

            // Blog Archive Template
            get_template_part('templates/post/posts-list');
            echo GoMMC::pagination();

        else :
            echo '<div class="page_404_wrapper">';
                echo '<header class="searсh-header">',
                    '<h1 class="page-title">',
                    esc_html__('Nothing Found', 'gommc'),
                    '</h1>',
                '</header>';

                echo '<div class="page-content">';
                    if (is_search()) :
                        echo '<p class="banner_404_text">';
                        esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'gommc');
                        echo '</p>';
                    else : ?>
                        <p class="banner_404_text"><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'gommc'); ?></p>
                        <?php
                    endif;
                    ?>
                    <div class="search_result_form">
                        <?php get_search_form(); ?>
                    </div>
                    <div class="gommc_404__button">
                        <a class="tpc-button btn-size-lg" href="<?php echo esc_url(home_url('/')); ?>">
                            <div class="button-content-wrapper">
                            <?php esc_html_e('Take Me Home', 'gommc'); ?>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <?php
        endif;
    echo '</div>';

    if ($sb) {
        GoMMC::render_sidebar($sb);
    }

echo '</div>';
echo '</div>';

get_footer();
