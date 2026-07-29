<?php
/**
 * Server-side render for oja-talu/product-feature.
 *
 * Pulls a live WooCommerce product by ID at render time, so price and
 * stock are never stale even if this block was inserted weeks ago.
 *
 * @package Oja_Talu
 *
 * @var array $attributes Block attributes — { productId }.
 */

defined( 'ABSPATH' ) || exit;

$oja_product_id = isset( $attributes['productId'] ) ? (int) $attributes['productId'] : 0;

if ( ! $oja_product_id || ! function_exists( 'wc_get_product' ) ) {
	return '';
}

$oja_product = wc_get_product( $oja_product_id );

if ( ! $oja_product instanceof WC_Product ) {
	return '';
}

$oja_excerpt = wp_strip_all_tags( $oja_product->get_short_description() );
$oja_avail   = function_exists( 'oja_talu_product_availability_label' )
	? oja_talu_product_availability_label( $oja_product )
	: '';

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'oja-product-feature' ) );
?>
<div <?php echo wp_kses_post( $wrapper_attributes ); ?>>
	<a class="oja-product-feature__link-wrap" href="<?php echo esc_url( $oja_product->get_permalink() ); ?>">
		<div class="oja-product-feature__media">
			<?php echo wp_kses_post( $oja_product->get_image( 'oja-talu-square' ) ); ?>
		</div>
		<h3 class="oja-product-feature__title"><?php echo esc_html( $oja_product->get_name() ); ?></h3>
		<?php if ( $oja_excerpt ) : ?>
			<p class="oja-product-feature__excerpt"><?php echo esc_html( $oja_excerpt ); ?></p>
		<?php endif; ?>
		<?php if ( $oja_avail ) : ?>
			<p class="oja-product-feature__availability"><?php echo esc_html( $oja_avail ); ?></p>
		<?php else : ?>
			<p class="oja-product-feature__price"><?php echo wp_kses_post( $oja_product->get_price_html() ); ?></p>
		<?php endif; ?>
	</a>
</div>
