<?php

defined('ABSPATH') || exit;

/**
 * The template for displaying product search form
 *
 * This template is overridden by MMC team.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version    7.0.1
 */


?>
<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'gommc' ); ?></label>
	<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'gommc' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button class="search-button" type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'gommc' ); ?>"><?php echo esc_html_x( 'Search', 'submit button', 'gommc' ); ?></button>
	<i class="search__icon flaticon-loupe"></i>
	<input type="hidden" name="post_type" value="product" />
</form>
