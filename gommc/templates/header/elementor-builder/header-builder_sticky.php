<?php
defined('ABSPATH') || exit;

global $tpc_template_header;
$tpc_template_header = 'sticky';

if (
    !empty($this->header_sticky_page_select_id)
    && did_action('elementor/loaded')
) {
    echo \Elementor\Plugin::$instance->frontend->get_builder_content($this->header_sticky_page_select_id);
}
