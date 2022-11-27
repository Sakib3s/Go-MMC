<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $pagenow;

function gommc_welcome_page(){
   require_once 'tpc-welcome.php';
}

function gommc_requirements_page(){
   require_once 'tpc-requirements.php';
}

function gommc_admin_menu(){
    if ( current_user_can( 'edit_theme_options' ) ) {

        add_menu_page( 'GoMMC', 'GoMMC', 'administrator', 'gommc-admin-menu', 'gommc_welcome_page', 'dashicons-welcome-learn-more', 2 );

        add_submenu_page( 'gommc-admin-menu', 'gommc', esc_html__('Welcome','gommc'), 'administrator', 'gommc-admin-menu', 'gommc_welcome_page' );

        add_submenu_page('gommc-admin-menu', '', 'Theme Options', 'manage_options', 'admin.php?page=tpc-theme-options-panel' );

        if (class_exists('OCDI_Plugin')):
           add_submenu_page( 'gommc-admin-menu', esc_html__( 'Demo Import', 'gommc' ), esc_html__( 'Demo Import', 'gommc' ), 'administrator', 'demo_install', 'demo_install_function' );
       endif;

      add_submenu_page( 'gommc-admin-menu', 'gommc', esc_html__('Requirements','gommc'), 'administrator', 'gommc-requirements', 'gommc_requirements_page' );

   }

}

add_action( 'admin_menu', 'gommc_admin_menu' );

function demo_install_function(){
    ?>
    <script>location.href='<?php echo esc_url(admin_url().'themes.php?page=pt-one-click-demo-import');?>';</script>
    <?php
}

if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

  wp_redirect(admin_url("admin.php?page=gommc-admin-menu"));
  
}









