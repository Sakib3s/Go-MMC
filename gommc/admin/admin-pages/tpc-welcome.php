<?php
function gommc_let_to_num( $size ) {
	$l   = substr( $size, -1 );
	$ret = substr( $size, 0, -1 );
	switch ( strtoupper( $l ) ) {
		case 'P':
		$ret *= 1024;
		case 'T':
		$ret *= 1024;
		case 'G':
		$ret *= 1024;
		case 'M':
		$ret *= 1024;
		case 'K':
		$ret *= 1024;
	}
	return $ret;
}
$ssl_check = 'https' === substr( get_home_url('/'), 0, 5 );
$green_mark = '<mark class="green"><span class="dashicons dashicons-yes"></span></mark>';

$gommctheme = wp_get_theme();

$plugins_counts = (array) get_option( 'active_plugins', array() );

if ( is_multisite() ) {
	$network_activated_plugins = array_keys( get_site_option( 'active_sitewide_plugins', array() ) );
	$plugins_counts            = array_merge( $plugins_counts, $network_activated_plugins );
}
?>

	<h2 class="nav-tab-wrapper">
		<?php

		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=gommc-admin-menu' ), esc_html__( 'Welcome', 'gommc' ) );

		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=tpc-theme-options-panel' ), esc_html__( 'Theme Options', 'gommc' ) );

		if (class_exists('OCDI_Plugin')):
			printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'themes.php?page=pt-one-click-demo-import' ), esc_html__( 'Demo Import', 'gommc' ) );
		endif;
		
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=gommc-requirements' ), esc_html__( 'Requirements', 'gommc' ) );
		?>
	</h2>
	
	

		<div class="gommc-getting-started">
				<div class="gommc-getting-started__box">

					<div class="gommc-getting-started__content">
						<div class="gommc-getting-started__content--narrow">
							<h2><?php echo __( 'Welcome to Go MMC', 'gommc' ); ?></h2>
							<p><?php
							printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=gommc-required-plugins' ), esc_html__( 'Install Required Plugins', 'gommc' ) );

							printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=tpc-theme-options-panel' ), esc_html__( 'Theme Options', 'gommc' ) );

							if (class_exists('OCDI_Plugin')):
								printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'themes.php?page=pt-one-click-demo-import' ), esc_html__( 'Demo Import', 'gommc' ) );
							endif;
							?>
							</p>
						</div>
					</div>
				</div>
			</div>


	


