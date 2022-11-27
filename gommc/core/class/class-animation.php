<?php
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'GoMMC_Animation' ) ) {
    class GoMMC_Animation {

        protected static $instance = null;

        public static function instance() {
            if ( null === self::$instance ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function initialize() {

        /**
         * Edit Controls.
         */
        // Add custom Motion Effect - Entrance Animation.
        add_filter( 'elementor/controls/animations/additional_animations', [
            $this,
            'add_custom_entrance_animations',
        ] );

        }

        public function add_custom_entrance_animations( $animations ) {
            $animations['By GoMMC'] = [
                'gommcFadeInUp' => 'GoMMC - Fade In Up',
            ];

            return $animations;
        }


    }

    GoMMC_Animation::instance()->initialize();
}

