<?php
defined('ABSPATH') || exit;

if (!class_exists( 'GoMMC_Mega_Menu_Waker')) {
    /**
     * LMSMart Mega Menu Walker
     *
     *
     * @category Class
     * @package gommc\core\class
     * @author MMC 
     * @since 1.0.0
     */
    class GoMMC_Mega_Menu_Waker extends Walker_Nav_Menu
    {
        /**
         * @since 1.0.0
         */
        private $depth_0_counter;
        private $submenu_disable;

        public function __construct($depth_0_counter, $submenu_disable)
        {
            $this->depth_0_counter = $depth_0_counter ?? null;
            $this->submenu_disable = $submenu_disable ?? null;
        }

        public function style_helper()
        {
            $style = '';

            if (!empty($this->tpc_megamenu_background_image)) {
                $style .= "background-image: url(".esc_attr($this->tpc_megamenu_background_image).");";

                if (!empty($this->tpc_megamenu_background_repeat)) {
                    $style .= "background-repeat:".esc_attr($this->tpc_megamenu_background_repeat).";";
                }
                if (!empty($this->tpc_megamenu_background_pos_x)) {
                    $style .= "background-position-x:".esc_attr($this->tpc_megamenu_background_pos_x).";";
                }
                if (!empty($this->tpc_megamenu_background_pos_y)) {
                    $style .= "background-position-y:".esc_attr($this->tpc_megamenu_background_pos_y).";";
                }
            }

            if (!empty($this->tpc_megamenu_min_height)) {
                $style .= "min-height:".esc_attr((int) $this->tpc_megamenu_min_height)."px;";
            }

            if (!empty($this->tpc_megamenu_width)) {
                $style .= "max-width:".esc_attr((int) $this->tpc_megamenu_width)."px;";
            }

            if (!empty($this->tpc_megamenu_padding_left)) {
                $style .= "padding-left:".esc_attr((int) $this->tpc_megamenu_padding_left)."px;";
            }
            if (!empty($this->tpc_megamenu_padding_right)) {
                $style .= "padding-right:".esc_attr((int) $this->tpc_megamenu_padding_right)."px;";
            }

            $style = !empty($style) ? " style='".$style."'" : "";
            return $style;
        }

        public function class_helper(){
            $class = '';

            if(!empty($this->tpc_megamenu_submenu_pos)){
                $class .= "tpc-submenu-position-".esc_attr($this->tpc_megamenu_submenu_pos);
            }

            return $class;
        }

        public function start_lvl(&$output, $depth = 0, $args = [])
        {
            $indent = str_repeat("\t", $depth);

            switch (true) {
                case $depth === 0 && $this->tpc_megamenu_enable == 'links':
                    $output .= "$indent<ul class=\"tpc-mega-menu mega-menu sub-menu sub-menu-columns\"".$this->style_helper().">";
                    break;
                case $depth === 1 && $this->tpc_megamenu_enable == 'links' :
                    $output .= "$indent<ul class=\"tpc-mega-menu mega-menu sub-menu sub-menu-columns_item\">";
                    break;
                default:
                    $output .= "$indent<ul class='sub-menu ".$this->class_helper()."'>";
                    break;
            }
        }


        /**
         * Ends the list of after the elements are added.
         */
        public function end_lvl(&$output, $depth = 0, $args = [])
        {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

        /**
         * Check Active Mega Menu
         * @return void
         */
        public function check_mega_menu_activate($depth)
        {
            return $depth === 0 && !empty($this->tpc_megamenu_enable) && $this->tpc_megamenu_enable != 'disable';
        }

        /**
         * Start the element output.
         */
        public function start_el(
            &$output,
            $item,
            $depth = 0,
            $args = [],
            $id = 0
        ) {
            if (
                isset($this->submenu_disable)
                && $depth > 0
            ) {
                /**
                 * Do not render submenu items.
                 */
                return;
            }

            $indent = $depth ? str_repeat("\t", $depth) : '';
            $class_names = $value = '';

            $classes = empty($item->classes) ? [] : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

            $item_output = '';
            $data_attr = '';

            $this->tpc_megamenu_submenu_pos = get_post_meta( $item->ID, 'tpc_megamenu_submenu_pos', true );
            if ($depth === 0) {
                // Check If Enable
                $this->tpc_megamenu_enable = get_post_meta( $item->ID, 'tpc_megamenu_enable', true );

                if ($this->tpc_megamenu_enable !== '') {
                    $array = ['columns', 'posts_count', 'min_height', 'width', 'padding_left', 'padding_right', 'hide_headings', 'background_image', 'background_repeat', 'background_pos_x', 'background_pos_y'];
                    foreach ($array as $key => $value) {
                        $this->{'tpc_megamenu_'.$value} = get_post_meta( $item->ID, 'tpc_megamenu_'.$value, true );
                    }
                }
            }

            if ($this->check_mega_menu_activate($depth)) {
                $class_names .= ' mega-menu';

                if ($this->tpc_megamenu_enable == 'links') {

                    $columns = !empty($this->tpc_megamenu_columns) ? $this->tpc_megamenu_columns :  1;
                    $class_names .= ' mega-menu-links mega-columns-'.$columns.'col ';
                }
            }

            if (
                $depth === 1
                && $this->tpc_megamenu_enable == 'links'
                && !empty($this->tpc_megamenu_hide_headings)
            ) {
                $class_names .= ' hide-mega-headings';
            }

            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent.'<li'. $id.$class_names.$data_attr.'>';

            $atts = [];
            $atts['title'] = !empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = !empty( $item->target ) ? $item->target : '';
            $atts['rel'] = !empty( $item->xfn ) ? $item->xfn : '';
            $atts['href'] = !empty( $item->url ) ? $item->url : '';

            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = 'href' === $attr ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $menu_item = apply_filters('the_title', $item->title, $item->ID);

            $item_output = $args->before ?? '';
            $item_output .= '<a' . $attributes . '>';
            $item_output .= '<span class="item_text">';
                $item_output .= $menu_item;
                $item_output .= $args->link_after;
            $item_output .= '</span>';
            $item_output .= '<i class="menu-item__plus"></i>';
            $item_output .= '</a>';
            $item_output .= $args->after ?? '';

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        public function end_el(&$output, $item, $depth = 0, $args = [])
        {
            if (
                $this->check_mega_menu_activate($depth)
                && $this->tpc_megamenu_enable != 'links'
            ) {
                $output .= '</div>';
            }

            $output .= '</li>';
        }

    } // Walker_Nav_Menu


    /*-----------------------------------------------------------------------------------*/
    /* MMC menu fields
    /*-----------------------------------------------------------------------------------*/
    add_action( 'wp_nav_menu_item_custom_fields', 'lmsmart_add_megamenu_fields', 10, 4 );
    function lmsmart_add_megamenu_fields( $item_id, $item, $depth, $args )
    {
        ?>

        <p class="description description-wide field-megamenu-submenu-pos col-6">
            <label for="edit-menu-item-megamenu-submenu-pos-<?php echo esc_attr( $item_id ) ?>">
                <?php esc_html_e( 'Submenu Position', 'gommc' ); ?>
                <select id="edit-menu-item-megamenu-submenu-pos-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-submenu-pos" name="menu-item-tpc-megamenu-submenu-pos[<?php echo esc_attr( $item_id ) ?>]">
                    <option value="default" <?php selected( $item->tpc_megamenu_submenu_pos, 'default' ); ?>><?php esc_html_e( 'Default', 'gommc' ); ?></option>
                    <option value="left" <?php selected( $item->tpc_megamenu_submenu_pos, 'left' ); ?>><?php esc_html_e( 'Left', 'gommc' ); ?></option>
                    <option value="right" <?php selected( $item->tpc_megamenu_submenu_pos, 'right' ); ?>><?php esc_html_e( 'Right', 'gommc' ); ?></option>
                </select>
            </label>
        </p>

        <div class="clear"></div>
        <div class="mt-20">
            <strong><?php esc_html_e( 'LMSMart Mega Menu Settings:', 'gommc' ); ?></strong>
            <em><?php esc_html_e( '(Only for Main Menu)', 'gommc' ); ?></em>
        </div>
        <div class="clear"></div>

        <div class='tpc_accordion_wrapper collapsible close widget_class'>
            <div class='tpc_accordion_heading'>
                <span class='tpc_accordion_title'><?php esc_html_e( 'TPC Mega Menu Settings', 'gommc' ); ?></span>
                <span class='tpc_accordion_button'></span>
            </div>
        <div class='tpc_accordion_body' style='display: none'>
            <div class="tpc-mega-menu_wrapper">
                <p class="description description-wide field-megamenu-enable">
                    <label for="edit-menu-item-megamenu-enable-<?php echo esc_attr( $item_id ) ?>">
                        <?php
                        esc_html_e( 'Enable The TPC Mega Menu?', 'gommc' );
                        echo '<select',
                            ' id="edit-menu-item-megamenu-enable-', esc_attr( $item_id ), '"',
                            ' class="widefat code edit-menu-item-megamenu-enable"',
                            ' name="menu-item-tpc-megamenu-enable[', esc_attr( $item_id ), ']"',
                            '>',
                            '<option value="">', esc_attr__('Disable', 'gommc'), '</option>',
                            '<option value="links" ', selected( $item->tpc_megamenu_enable, 'links' ), '>', esc_html__('Mega Menu Columns', 'gommc'), '</option>',
                        '</select>';
                        ?>
                    </label>
                </p>

                <p class="description description-wide field-megamenu-columns">
                    <label for="edit-menu-item-megamenu-columns-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Number of Mega Menu Columns', 'gommc' ); ?>
                        <select id="edit-menu-item-megamenu-columns-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-columns" name="menu-item-tpc-megamenu-columns[<?php echo esc_attr( $item_id ) ?>]">
                            <option value=""></option>
                            <option value="2" <?php selected( $item->tpc_megamenu_columns, '2' ); ?>>2</option>
                            <option value="3" <?php selected( $item->tpc_megamenu_columns, '3' ); ?>>3</option>
                            <option value="4" <?php selected( $item->tpc_megamenu_columns, '4' ); ?>>4</option>
                            <option value="5" <?php selected( $item->tpc_megamenu_columns, '5' ); ?>>5</option>
                        </select>
                    </label>
                </p>

                <p class="description description-wide field-megamenu-background-image col-6">
                    <label for="edit-menu-item-megamenu-background-image-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Background Image', 'gommc' );?>
                        <input type="text" class="lmsmart_media_url widefat code edit-menu-item-megamenu-background-image" name="menu-item-tpc-megamenu-background-image[<?php echo esc_attr( $item_id ) ?>]" id="edit-menu-item-megamenu-background-image-<?php echo esc_attr( $item_id ) ?>" value="<?php echo esc_attr($item->tpc_megamenu_background_image); ?>">
                    </label>
                    <a href="#" class="button lmsmart_media_upload"><?php esc_html_e('Upload', 'gommc'); ?></a>
                </p>

                <p class="description description-wide field-megamenu-background-repeat col-6">
                    <label for="edit-menu-item-megamenu-background-repeat-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Background Repeat', 'gommc' ); ?>
                        <select id="edit-menu-item-megamenu-background-repeat-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-background-repeat" name="menu-item-tpc-megamenu-background-repeat[<?php echo esc_attr( $item_id ) ?>]">
                            <option value="no-repeat" <?php selected( $item->tpc_megamenu_background_repeat, 'no-repeat' ); ?>><?php esc_html_e( 'No Repeat', 'gommc' ); ?></option>
                            <option value="repeat" <?php selected( $item->tpc_megamenu_background_repeat, 'repeat' ); ?>><?php esc_html_e( 'Repeat', 'gommc' ); ?></option>
                            <option value="repeat-x" <?php selected( $item->tpc_megamenu_background_repeat, 'repeat-x' ); ?>><?php esc_html_e( 'Repeat X', 'gommc' ); ?></option>
                            <option value="repeat-y" <?php selected( $item->tpc_megamenu_background_repeat, 'repeat-y' ); ?>><?php esc_html_e( 'Repeat Y', 'gommc' ); ?></option>
                        </select>
                    </label>
                </p>
                <div class="clear"></div>
                <p class="description description-wide field-megamenu-background-pos-x col-6">
                    <label for="edit-menu-item-megamenu-background-pos-x-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Background Position X', 'gommc' ); ?>
                        <select id="edit-menu-item-megamenu-background-pos-x-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-background-pos-x" name="menu-item-tpc-megamenu-background-pos-x[<?php echo esc_attr( $item_id ) ?>]">
                            <option value="right" <?php selected( $item->tpc_megamenu_background_pos_x, 'right' ); ?>><?php esc_html_e( 'Right', 'gommc' ); ?></option>
                            <option value="center" <?php selected( $item->tpc_megamenu_background_pos_x, 'center' ); ?>><?php esc_html_e( 'Center', 'gommc' ); ?></option>
                            <option value="left" <?php selected( $item->tpc_megamenu_background_pos_x, 'left' ); ?>><?php esc_html_e( 'Left', 'gommc' ); ?></option>
                        </select>
                    </label>
                </p>

                <p class="description description-wide field-megamenu-background-pos-y col-6">
                    <label for="edit-menu-item-megamenu-background-pos-y-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Background Position Y', 'gommc' ); ?>
                        <select id="edit-menu-item-megamenu-background-pos-y-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-background-pos-y" name="menu-item-tpc-megamenu-background-pos-y[<?php echo esc_attr( $item_id ) ?>]">
                            <option value="top" <?php selected( $item->tpc_megamenu_background_pos_y, 'top' ); ?>><?php esc_html_e( 'Top', 'gommc' ); ?></option>
                            <option value="center" <?php selected( $item->tpc_megamenu_background_pos_y, 'center' ); ?>><?php esc_html_e( 'Center', 'gommc' ); ?></option>
                            <option value="bottom" <?php selected( $item->tpc_megamenu_background_pos_y, 'bottom' ); ?>><?php esc_html_e( 'Bottom', 'gommc' ); ?></option>
                        </select>
                    </label>
                </p>
                <div class="clear"></div>
                <p class="description description-wide field-megamenu-min-height col-6">
                    <label for="edit-menu-item-megamenu-min-height-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Min Height', 'gommc' );
                        ?>
                        <input type="text" id="edit-menu-item-megamenu-min-height-<?php echo esc_attr( $item_id ) ?>"  class="input-sortable widefat code edit-menu-item-custom" name="menu-item-tpc-megamenu-min-height[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr($item->tpc_megamenu_min_height); ?>">
                    </label>
                </p>

                <p class="description description-wide field-megamenu-width col-6">
                    <label for="edit-menu-item-megamenu-width-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Max Width', 'gommc' );
                        ?>
                        <input type="text" id="edit-menu-item-megamenu-width-<?php echo esc_attr( $item_id ) ?>"  class="input-sortable widefat code edit-menu-item-custom" name="menu-item-tpc-megamenu-width[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr($item->tpc_megamenu_width); ?>">
                    </label>
                </p>
                 <div class="clear"></div>
                 <p class="description description-wide field-megamenu-padding-left col-6">
                    <label for="edit-menu-item-megamenu-padding-left-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Padding Left', 'gommc' );
                        ?>
                        <input type="text" id="edit-menu-item-megamenu-padding-left-<?php echo esc_attr( $item_id ) ?>"  class="input-sortable widefat code edit-menu-item-custom" name="menu-item-tpc-megamenu-padding-left[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr($item->tpc_megamenu_padding_left); ?>">
                    </label>
                </p>
                <p class="description description-wide field-megamenu-padding-right col-6">
                    <label for="edit-menu-item-megamenu-padding-right-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Padding Right', 'gommc' );
                        ?>
                        <input type="text" id="edit-menu-item-megamenu-padding-right-<?php echo esc_attr( $item_id ) ?>"  class="input-sortable widefat code edit-menu-item-custom" name="menu-item-tpc-megamenu-padding-right[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr($item->tpc_megamenu_padding_right); ?>">
                    </label>
                </p>
                <div class="clear"></div>
                <p class="description description-wide field-megamenu-hide-headings">
                    <label for="edit-menu-item-megamenu-hide-headings-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Hide Mega Menu Headings?', 'gommc' );?>
                        <input type="checkbox" id="edit-menu-item-megamenu-hide-headings-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-hide-headings" name="menu-item-tpc-megamenu-hide-headings[<?php echo esc_attr( $item_id ) ?>]" value="true" <?php checked( $item->tpc_megamenu_hide_headings, 'true' ); ?>>
                    </label>
                </p>
            </div>
        </div>
        </div>
    <?php }

    add_action('wp_update_nav_menu_item', 'lmsmart_custom_nav_update', 10, 3);
    function lmsmart_custom_nav_update( $menu_id, $menu_item_db_id, $menu_item_data = [] )
    {
        $fields = lmsmart_mega_menu_fields();

        foreach ($fields as $field) {
            $save = str_replace( 'menu-item-tpc-megamenu-', 'tpc_megamenu_', $field);
            $save = str_replace( '-', '_', $save);

            // Sanitize.
            if ( ! empty( $_POST[ $field ][ $menu_item_db_id ] ) ) {
                $val = sanitize_text_field($_POST[ $field ][ $menu_item_db_id ]);
                update_post_meta( $menu_item_db_id, $save, $val );
            } else {
                delete_post_meta( $menu_item_db_id, $save );
            }
        }
    }

    if (!function_exists('lmsmart_mega_menu_fields')) {

        function lmsmart_mega_menu_fields()
        {
            return [
                'menu-item-tpc-megamenu-submenu-pos',
                'menu-item-tpc-megamenu-enable',
                'menu-item-tpc-megamenu-columns',
                'menu-item-tpc-megamenu-posts-count',
                'menu-item-tpc-megamenu-min-height',
                'menu-item-tpc-megamenu-width',
                'menu-item-tpc-megamenu-padding-left',
                'menu-item-tpc-megamenu-padding-right',
                'menu-item-tpc-megamenu-hide-headings',
                'menu-item-tpc-megamenu-background-image',
                'menu-item-tpc-megamenu-background-repeat',
                'menu-item-tpc-megamenu-background-pos-x',
                'menu-item-tpc-megamenu-background-pos-y',
            ];
        }
    }

    add_filter( 'wp_edit_nav_menu_walker', 'lmsmart_custom_nav_edit_walker', 10, 2 );
    function lmsmart_custom_nav_edit_walker($walker,$menu_id) {
        return 'LMSMart_Mega_Menu_Edit_Walker';
    }

    /**
     * Navigation Menu API: Walker_Nav_Menu_Edit class
     *
     * @package WordPress
     * @subpackage Administration
     * @since 4.4.0
     */

    /**
     * Create HTML list of nav menu input items.
     *
     * @since 3.0.0
     *
     * @see Walker_Nav_Menu
     */
    class LMSMart_Mega_Menu_Edit_Walker extends Walker_Nav_Menu
    {
        /**
         * Starts the list before the elements are added.
         *
         * @see Walker_Nav_Menu::start_lvl()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   Not used.
         */
        public function start_lvl( &$output, $depth = 0, $args = [] ) {}

        /**
         * Ends the list of after the elements are added.
         *
         * @see Walker_Nav_Menu::end_lvl()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   Not used.
         */
        public function end_lvl( &$output, $depth = 0, $args = [] ) {}

        /**
         * Start the element output.
         *
         * @see Walker_Nav_Menu::start_el()
         * @since 3.0.0
         *
         * @global int $_wp_nav_menu_max_depth
         *
         * @param string $output Used to append additional content (passed by reference).
         * @param object $item   Menu item data object.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   Not used.
         * @param int    $id     Not used.
         */
        public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 )
        {
            global $_wp_nav_menu_max_depth;
            $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

            ob_start();
            $item_id = esc_attr( $item->ID );
            $removed_args = [
                'action',
                'customlink-tab',
                'edit-menu-item',
                'menu-item',
                'page-tab',
                '_wpnonce',
            ];

            $original_title = false;
            if ( 'taxonomy' == $item->type ) {
                $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
                if ( is_wp_error( $original_title ) )
                    $original_title = false;
            } elseif ( 'post_type' == $item->type ) {
                $original_object = get_post( $item->object_id );
                $original_title = get_the_title( $original_object->ID );
            } elseif ( 'post_type_archive' == $item->type ) {
                $original_object = get_post_type_object( $item->object );
                if ( $original_object ) {
                    $original_title = $original_object->labels->archives;
                }
            }

            $classes = [
                'menu-item menu-item-depth-' . $depth,
                'menu-item-' . esc_attr( $item->object ),
                'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
            ];

            $title = $item->title;

            if ( ! empty( $item->_invalid ) ) {
                $classes[] = 'menu-item-invalid';
                /* translators: %s: title of menu item which is invalid */
                $title = sprintf( esc_html__( '%s (Invalid)', 'gommc' ), $item->title );
            } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
                $classes[] = 'pending';
                /* translators: %s: title of menu item in draft status */
                $title = sprintf( esc_html__('%s (Pending)', 'gommc'), $item->title );
            }

            $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

            $submenu_text = 0 == $depth ? 'style="display: none;"' : '';

            ?>
            <li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
                <div class="menu-item-bar">
                    <div class="menu-item-handle">
                        <span class="item-title">
                            <span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo !empty($submenu_text) ? $submenu_text : ''; ?>><?php esc_html_e( 'sub item', 'gommc' ); ?></span></span>
                        <span class="item-controls">
                            <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                            <span class="item-order hide-if-js">
                                <a href="<?php
                                    echo esc_url(wp_nonce_url(
                                        add_query_arg(
                                            [
                                                'action' => 'move-up-menu-item',
                                                'menu-item' => $item_id,
                                            ],
                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                        ),
                                        'move-menu_item'
                                    ));
                                ?>" class="item-move-up" aria-label="<?php esc_attr_e( 'Move up', 'gommc' ) ?>">&#8593;</a>
                                |
                                <a href="<?php
                                    echo esc_url(wp_nonce_url(
                                        add_query_arg(
                                            [
                                                'action' => 'move-down-menu-item',
                                                'menu-item' => $item_id,
                                            ],
                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                        ),
                                        'move-menu_item'
                                    ));
                                ?>" class="item-move-down" aria-label="<?php esc_attr_e( 'Move down', 'gommc'  ) ?>">&#8595;</a>
                            </span>
                            <a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" href="<?php
                                echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? esc_url(admin_url( 'nav-menus.php' )) : esc_url(add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ) );
                            ?>" aria-label="<?php esc_attr_e( 'Edit menu item', 'gommc'  ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'Edit', 'gommc' ); ?></span></a>
                        </span>
                    </div>
                </div>

                <div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
                    <?php if ( 'custom' == $item->type ) : ?>
                        <p class="field-url description description-wide">
                            <label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
                                <?php esc_html_e( 'URL', 'gommc' ); ?><br />
                                <input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                            </label>
                        </p>
                    <?php endif; ?>
                    <p class="description description-wide">
                        <label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'Navigation Label', 'gommc' ); ?><br />
                            <input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                        </label>
                    </p>
                    <p class="field-title-attribute field-attr-title description description-wide">
                        <label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'Title Attribute', 'gommc' ); ?><br />
                            <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                        </label>
                    </p>
                    <p class="field-link-target description">
                        <label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
                            <input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
                            <?php esc_html_e( 'Open link in a new tab', 'gommc' ); ?>
                        </label>
                    </p>
                    <p class="field-css-classes description description-thin">
                        <label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'CSS Classes (optional)', 'gommc' ); ?><br />
                            <input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                        </label>
                    </p>
                    <p class="field-xfn description description-thin">
                        <label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'Link Relationship (XFN)', 'gommc' ); ?><br />
                            <input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                        </label>
                    </p>
                    <p class="field-description description description-wide">
                        <label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'Description', 'gommc' ); ?><br />
                            <textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                            <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'gommc'); ?></span>
                        </label>
                    </p>
                    <?php
                        /*-----------------------------------------------------------------------------------*/
                        /* MMC Mega Menu
                        /*-----------------------------------------------------------------------------------*/
                        do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args );
                    ?>

                    <fieldset class="field-move hide-if-no-js description description-wide">
                        <span class="field-move-visual-label" aria-hidden="true"><?php esc_html_e( 'Move', 'gommc' ); ?></span>
                        <button type="button" class="button-link menus-move menus-move-up" data-dir="up"><?php esc_html_e( 'Up one', 'gommc' ); ?></button>
                        <button type="button" class="button-link menus-move menus-move-down" data-dir="down"><?php esc_html_e( 'Down one', 'gommc' ); ?></button>
                        <button type="button" class="button-link menus-move menus-move-left" data-dir="left"></button>
                        <button type="button" class="button-link menus-move menus-move-right" data-dir="right"></button>
                        <button type="button" class="button-link menus-move menus-move-top" data-dir="top"><?php esc_html_e( 'To the top', 'gommc' ); ?></button>
                    </fieldset>

                    <div class="menu-item-actions description-wide submitbox">
                        <?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
                            <p class="link-to-original">
                                <?php
                                $allowed_html = [
                                    'a' => [
                                        'href' => true,
                                    ],
                                ];
                                printf( wp_kses( __('Original: %s', 'gommc'), $allowed_html ), '<a href="' . esc_url( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                            </p>
                        <?php endif; ?>
                        <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
                        echo esc_url(wp_nonce_url(
                            add_query_arg(
                                [
                                    'action' => 'delete-menu-item',
                                    'menu-item' => $item_id,
                                ],
                                admin_url( 'nav-menus.php' )
                            ),
                            'delete-menu_item_' . $item_id
                        )); ?>"><?php esc_html_e( 'Remove', 'gommc' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( [ 'edit-menu-item' => $item_id, 'cancel' => time() ], admin_url( 'nav-menus.php' ) ) );
                            ?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel', 'gommc'); ?></a>
                    </div>

                    <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
                    <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                    <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                    <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                    <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                    <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
                </div><!-- .menu-item-settings-->
                <ul class="menu-item-transport"></ul>
                <?php
            $output .= ob_get_clean();
        }
    } // Walker_Nav_Menu_Edit
}
