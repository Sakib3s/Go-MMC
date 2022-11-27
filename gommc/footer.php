<?php
/**
 * The template for Footer rendering
 *
 * Contains the closing of the #main div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gommc
 * @author MMC 
 * @since 1.0.0
 */
echo '</main>';

/**
* Elementor Pro Footer Render
*
* @since 1.0.0
*/
do_action('gommc/elementor_pro/footer');

/**
* Check TPC footer active option
*
* @since 1.0.0
*/
$footer = apply_filters('gommc/footer/enable', true);
$footer_switch = $footer['footer_switch'] ?? '';
$copyright_switch = $footer['copyright_switch'] ?? '';
if ($footer_switch || $copyright_switch) {
    get_template_part('templates/section', 'footer');
}

/**
* Runs after main
*
* @since 1.0.0
*/
do_action('gommc/after_main_content');

wp_footer();

echo '</body>';
echo '</html>';
