<?php
defined('ABSPATH') || exit;

if (!class_exists('TPC_Theme_Panel')) {
    /**
     * RT Theme Panel
     *
     *
     * @category Class
     * @package gommc\core\class
     * @author MMC 
     * @since 1.0.0
     */
    class TPC_Theme_Panel
    {
        /**
         * @access      private
         * @var         \TPC_Theme_Panel $instance
         * @since       3.0.0
         */
        private static $instance;

        /**
         * Get active instance
         *
         * @access      public
         * @since       3.1.3
         * @return      self::$instance
         */
        public static function instance()
        {
            if ( ! self::$instance ) {
                self::$instance = new self;
                self::$instance->hooks();
            }

            return self::$instance;
        }

        // Shim since we changed the function name. Deprecated.
        public static function get_instance()
        {
            if ( ! self::$instance ) {
                self::$instance = new self;
                self::$instance->hooks();
            }

            return self::$instance;
        }

        private function hooks()
        {
            /* ----------------------------------------------------------------------------- */
            /* Add Menu Page */
            /* ----------------------------------------------------------------------------- */
            add_action( 'admin_menu', [ $this, 'theme_panel_admin_menu' ]);
            add_action( 'admin_init', [ $this, 'theme_redirect' ] );
        }

        public function theme_panel_admin_menu()
        {
            add_menu_page (
                esc_html__('GoMMC', 'gommc'),
                esc_html__('GoMMC', 'gommc'),
                'manage_options', // capability
                'tpc-dashboard-panel',  // menu-slug
                [ $this, 'theme_panel_welcome_render' ], // function that will render its output
                get_template_directory_uri() . '/core/admin/img/dashboard/logo.png', // link to the icon that will be displayed in the sidebar
                2 // position of the menu option
            );
            $submenu = [];
            $submenu[] = [
                esc_html__('Welcome', 'gommc'), // page_title
                esc_html__('Welcome', 'gommc'), // menu_title
                'manage_options', // capability
                'tpc-dashboard-panel', // menu_slug
                [ $this, 'theme_panel_welcome_render' ], // function that will render its output
            ];

            if (current_user_can( 'activate_plugins' )):
                $submenu[] = [
                    esc_html__('Theme Plugins', 'gommc'), // page_title
                    esc_html__('Theme Plugins', 'gommc'), // menu_title
                    'edit_posts', // capability
                    'tpc-plugins-panel', // menu_slug
                    [ $this, 'theme_plugins' ], // function that will render its output
                ];
            endif;


            $submenu[] = [
                esc_html__('Requirements', 'gommc'), // page_title
                esc_html__('Requirements', 'gommc'), // menu_title
                'edit_posts', // capability
                'tpc-status-panel', // menu_slug
                [ $this, 'theme_status' ], // function that will render its output
            ];

            if ( class_exists( 'GoMMC_Core' ) ) {
                $submenu[] = [
                    esc_html__('Theme Options', 'gommc'), // page_title
                    esc_html__('Theme Options', 'gommc'), // menu_title
                    'edit_posts', // capability
                    'tpc-theme-options-panel', // menu_slug
                    [ $this, 'theme_options' ], // function that will render its output
                ];
            }

            $submenu = apply_filters('tpc_panel_submenu', [ $submenu ] );

            foreach ($submenu[0] as $key => $value) {
                add_submenu_page(
                    'tpc-dashboard-panel', // parent menu slug
                    $value[0], // page_title
                    $value[1], // menu_title
                    $value[2], // capability
                    $value[3], // menu_slug
                    $value[4] // function that will render its output
                );
            }
        }

        public function theme_dashboard_heading()
        {
            global $submenu;

            $menu_items = '';

            if (isset($submenu['tpc-dashboard-panel'])):
              $menu_items = $submenu['tpc-dashboard-panel'];
            endif;

            if (!empty($menu_items)) :
            ?>
              <div class="wrap tpc-wrapper-notify">
                <div class="nav-tab-wrapper">
                  <?php foreach ($menu_items as $item):
                    $class = isset($_GET['page']) && $_GET['page'] == $item[2] ? ' nav-tab-active' : '';
                    ?>
                    <a href="<?php echo esc_url(admin_url('admin.php?page='.$item[2].''));?>"
                        class="nav-tab<?php echo esc_attr($class);?>"
                    >
                        <?php echo esc_html($item[0]); ?>

                    </a>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif;
        }

        public function theme_panel_welcome_render()
        {

            $this->theme_dashboard_heading();

            /**
             * Template View Welcome
             */
            require_once get_theme_file_path('/core/dashboard/tpl-view-weclome.php');
        }

        public function theme_plugins()
        {

            $this->theme_dashboard_heading();

            /**
             * Template View Plugin
             */
            require_once get_theme_file_path('/core/dashboard/tpl-view-plugins.php');
        }

        public function theme_status()
        {

            $this->theme_dashboard_heading();

            /**
             * Template View Plugin
             */
            require_once get_theme_file_path('/core/dashboard/tpl-view-status.php');

        }

        public function theme_options() {}

        public function theme_redirect()
        {
            global $pagenow;
            if ( is_admin() && isset( $_GET['activated'] ) && 'themes.php' === $pagenow ) {
                wp_safe_redirect( esc_url(admin_url( 'admin.php?page=tpc-dashboard-panel' )) );
                exit;
            }
        }

    }
}

TPC_Theme_Panel::get_instance();


?>