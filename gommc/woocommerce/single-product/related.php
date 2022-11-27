<?php
/**
 * Related Products
 *
 * This template is overridden by MMC team.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$columns = (int) GoMMC_Theme_Helper::get_option('shop_related_columns');
$count = (int) GoMMC_Theme_Helper::get_option('shop_r_products_per_page');

if ( $related_products ) : ?>

	<section class="related products">

	<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Related products', 'gommc' ) );

		if ( $heading ) :
			?>
			<h4><?php echo esc_html( $heading ); ?></h4>
		<?php endif; ?>

		<div class="tpc-products-related tpc-products-wrapper columns-<?php echo esc_attr($columns);?>">

			<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

				<?php
				$post_object = get_post( $related_product->get_id() );

				setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

				wc_get_template_part( 'content', 'product' );
				?>

			<?php endforeach; ?>

			<?php woocommerce_product_loop_end(); ?>
		</div>
	</section>
	<?php
endif;

wp_reset_postdata();
