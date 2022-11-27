<?php

defined('ABSPATH') || exit;

if (!class_exists('GoMMC_Header_Sticky')) {
    class GoMMC_Header_Sticky extends GoMMC_Get_Header
    {
        public function __construct()
        {
            $this->header_vars();
            $this->html_render = 'sticky';

            if (GoMMC_Theme_Helper::get_mb_option('header_sticky', 'mb_customize_header_layout', 'custom')) {
                $header_sticky_style = GoMMC_Theme_Helper::get_option('header_sticky_style');

                echo "<div class='tpc-sticky-header tpc-sticky-element", ($this->header_type === 'default' ? ' header_sticky_shadow' : ''), "'", (!empty($header_sticky_style) ? ' data-style="' . esc_attr($header_sticky_style) . '"' : ''), ">";

                echo '<div class="container-wrapper">';

                    $this->build_header_layout('sticky');

                echo '</div>';

                echo '</div>';
            }
        }
    }

    new GoMMC_Header_Sticky();
}
