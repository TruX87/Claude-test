<?php
/**
 * WooCommerce integration.
 *
 * Only loaded when WooCommerce is active (see functions.php). Every
 * change here is a targeted filter/removal, not a blanket "disable Woo
 * features" switch — per Phase 4 §8.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declare WooCommerce block-template support and drop the wrapper
 * markup Woo would otherwise inject around classic (non-block) templates
 * — this theme has none of those, everything is a block template.
 */
function oja_talu_woocommerce_setup(): void {
	add_theme_support( 'wc-blocks' );
}
add_action( 'after_setup_theme', 'oja_talu_woocommerce_setup' );

/**
 * "Tagasi {month}" availability text.
 *
 * When a product has a `_season_return_month` meta value set (a plain
 * text field an editor fills in via the product's Custom Fields panel —
 * no new meta box needed for a single optional field), swap WooCommerce's
 * default "Out of stock" copy for a season-aware message. Falls back to
 * Woo's own default text for every other product.
 *
 * @param string     $availability Default availability HTML.
 * @param WC_Product $product      Product being rendered.
 * @return string Filtered availability HTML.
 */
function oja_talu_product_availability_text( string $availability, WC_Product $product ): string {
	if ( $product->is_in_stock() ) {
		return $availability;
	}

	$return_month = get_post_meta( $product->get_id(), '_season_return_month', true );

	if ( $return_month ) {
		return esc_html( oja_talu_product_availability_label( $product ) );
	}

	return $availability;
}
add_filter( 'woocommerce_get_availability_text', 'oja_talu_product_availability_text', 10, 2 );

/**
 * Shared availability label, also used by the oja-talu/product-feature
 * block's render.php so the Homepage feature grid and the shop archive
 * never disagree about a product's status.
 *
 * @param WC_Product $product Product to describe.
 * @return string Human-readable availability label, or '' if the
 *                product is simply in stock (caller falls back to price).
 */
function oja_talu_product_availability_label( WC_Product $product ): string {
	if ( $product->is_in_stock() ) {
		return '';
	}

	$return_month = get_post_meta( $product->get_id(), '_season_return_month', true );

	if ( ! $return_month ) {
		return __( 'Otsas', 'oja-talu' );
	}

	/* translators: %s: month name, e.g. "august". */
	return sprintf( __( 'Tagasi %s', 'oja-talu' ), $return_month );
}

/**
 * Remove urgency-driven default WooCommerce UI that conflicts with the
 * brand's "boutique farm shop, not Amazon" principle (Design System §16).
 */
function oja_talu_remove_urgency_ui(): void {
	// "Only 2 left in stock!" threshold messaging.
	add_filter( 'woocommerce_display_stock_qty_for_no_stock', '__return_false' );

	// Related/upsell product carousels on the single product page.
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
}
add_action( 'wp', 'oja_talu_remove_urgency_ui' );

/**
 * Disable the built-in star rating / review system.
 *
 * The brand doc implies no review system (nothing in the design system
 * describes one); if the client wants reviews later, re-enable via
 * Woo's own settings rather than removing this filter — keeps the
 * decision reversible in one place.
 */
add_filter( 'woocommerce_product_get_rating_html', '__return_empty_string' );

/**
 * Register the custom "Return month" field on the product edit screen,
 * backing the `_season_return_month` meta key used above.
 */
function oja_talu_product_return_month_field(): void {
	woocommerce_wp_text_input(
		array(
			'id'          => '_season_return_month',
			'label'       => __( 'Season return month', 'oja-talu' ),
			'desc_tip'    => true,
			'description' => __( 'If set, out-of-stock shows "Tagasi {month}" instead of "Out of stock". Leave blank otherwise.', 'oja-talu' ),
		)
	);
}
add_action( 'woocommerce_product_options_inventory_product_data', 'oja_talu_product_return_month_field' );

/**
 * Save the "Return month" field.
 *
 * @param int $product_id Product being saved.
 */
function oja_talu_save_product_return_month_field( int $product_id ): void {
	if ( isset( $_POST['_season_return_month'] ) ) {
		update_post_meta(
			$product_id,
			'_season_return_month',
			sanitize_text_field( wp_unslash( $_POST['_season_return_month'] ) )
		);
	}
}
add_action( 'woocommerce_process_product_meta', 'oja_talu_save_product_return_month_field' );
