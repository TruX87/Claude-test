<?php
/**
 * SEO: meta description, Open Graph, and JSON-LD schema.
 *
 * No SEO plugin — per Phase 4 §13, this is a deliberate "minimal
 * plugins" trade-off: the content team loses a Yoast-style metabox in
 * exchange for one fewer heavy plugin. If that trade-off turns out to
 * be wrong in practice, the fallback is a single lightweight plugin
 * (e.g. The SEO Framework), not re-adding this file — see Phase 4 §14.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register a plain "SEO description" field on posts, pages, products,
 * and Journal entries, exposed in the block editor via the native
 * Post Meta / Custom Fields panel (no custom sidebar UI needed for one
 * field).
 */
function oja_talu_register_seo_meta(): void {
	$oja_post_types = array( 'post', 'page', 'product', 'oja_journal' );

	foreach ( $oja_post_types as $oja_post_type ) {
		register_post_meta(
			$oja_post_type,
			'_oja_seo_description',
			array(
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
}
add_action( 'init', 'oja_talu_register_seo_meta' );

/**
 * Resolve the description to use for the current singular view: the
 * custom field if the editor filled one in, otherwise a stripped,
 * trimmed excerpt.
 *
 * @return string Plain-text description, or '' outside a singular view.
 */
function oja_talu_get_seo_description(): string {
	if ( ! is_singular() ) {
		return '';
	}

	$oja_custom = get_post_meta( get_the_ID(), '_oja_seo_description', true );
	if ( $oja_custom ) {
		return wp_strip_all_tags( $oja_custom );
	}

	$oja_excerpt = get_the_excerpt();
	return $oja_excerpt ? wp_strip_all_tags( $oja_excerpt ) : '';
}

/**
 * Print the meta description tag.
 */
function oja_talu_output_meta_description(): void {
	$oja_description = oja_talu_get_seo_description();
	if ( $oja_description ) {
		printf( '<meta name="description" content="%s" />' . "\n", esc_attr( wp_trim_words( $oja_description, 30, '…' ) ) );
	}
}
add_action( 'wp_head', 'oja_talu_output_meta_description', 2 );

/**
 * Print Open Graph tags for the current singular view.
 */
function oja_talu_output_open_graph(): void {
	if ( ! is_singular() ) {
		return;
	}

	$oja_title       = get_the_title();
	$oja_description = wp_trim_words( oja_talu_get_seo_description(), 30, '…' );
	$oja_url         = get_permalink();
	$oja_image       = get_the_post_thumbnail_url( get_the_ID(), 'oja-talu-hero' );
	?>
	<meta property="og:type" content="<?php echo is_singular( 'product' ) ? 'product' : 'website'; ?>" />
	<meta property="og:title" content="<?php echo esc_attr( $oja_title ); ?>" />
	<?php if ( $oja_description ) : ?>
		<meta property="og:description" content="<?php echo esc_attr( $oja_description ); ?>" />
	<?php endif; ?>
	<meta property="og:url" content="<?php echo esc_url( $oja_url ); ?>" />
	<?php if ( $oja_image ) : ?>
		<meta property="og:image" content="<?php echo esc_url( $oja_image ); ?>" />
	<?php endif; ?>
	<?php
}
add_action( 'wp_head', 'oja_talu_output_open_graph', 3 );

/**
 * Print JSON-LD schema: LocalBusiness site-wide (on the front page),
 * Product on single products, and Article on single Journal entries.
 */
function oja_talu_output_json_ld(): void {
	$oja_schema = null;

	if ( is_front_page() ) {
		$oja_schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'LocalBusiness',
			'name'     => get_bloginfo( 'name' ),
			'url'      => home_url( '/' ),
		);
	} elseif ( function_exists( 'is_product' ) && is_product() ) {
		$oja_product = wc_get_product( get_the_ID() );
		if ( $oja_product ) {
			$oja_schema = array(
				'@context'    => 'https://schema.org',
				'@type'       => 'Product',
				'name'        => $oja_product->get_name(),
				'description' => wp_strip_all_tags( $oja_product->get_short_description() ),
				'sku'         => $oja_product->get_sku(),
				'image'       => wp_get_attachment_image_url( $oja_product->get_image_id(), 'oja-talu-square' ),
				'offers'      => array(
					'@type'         => 'Offer',
					'priceCurrency' => get_woocommerce_currency(),
					'price'         => $oja_product->get_price(),
					'availability'  => $oja_product->is_in_stock()
						? 'https://schema.org/InStock'
						: 'https://schema.org/OutOfStock',
					'url'           => get_permalink(),
				),
			);
		}
	} elseif ( is_singular( 'oja_journal' ) ) {
		$oja_schema = array(
			'@context'      => 'https://schema.org',
			'@type'         => 'Article',
			'headline'      => get_the_title(),
			'datePublished' => get_the_date( 'c' ),
			'dateModified'  => get_the_modified_date( 'c' ),
			'image'         => get_the_post_thumbnail_url( get_the_ID(), 'oja-talu-editorial' ),
			'author'        => array(
				'@type' => 'Organization',
				'name'  => get_bloginfo( 'name' ),
			),
		);
	}

	if ( $oja_schema ) {
		echo '<script type="application/ld+json">' . wp_json_encode( array_filter( $oja_schema ) ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_json_encode() output is safe JSON, not HTML.
	}
}
add_action( 'wp_head', 'oja_talu_output_json_ld', 4 );
