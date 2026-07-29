<?php
/**
 * Core theme supports, navigation menus, and image sizes.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme supports, nav menu locations, and custom image sizes.
 *
 * Runs on after_setup_theme so it's available before anything that reads
 * these supports (widgets, block editor, WooCommerce) initialises.
 */
function oja_talu_setup(): void {
	// Block themes still declare these; several (post-thumbnails,
	// html5, responsive-embeds) affect classic-editor fallbacks and
	// third-party plugin markup, not just this theme's own templates.
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	// Custom logo: sized for the header wordmark lockup, not a square icon.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// WooCommerce declares its own theme support so Woo knows this theme
	// intends to use its block templates rather than legacy wrapper markup.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Nav menu locations exist as a fallback / classic-widget compatibility
	// path. The primary site chrome uses the block-based Navigation block
	// in parts/header.html, which reads from wp_navigation posts, not
	// these locations — see parts/header.html.
	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation (fallback)', 'oja-talu' ),
			'footer'  => __( 'Footer Navigation (fallback)', 'oja-talu' ),
		)
	);

	// Image sizes matching the three ratios fixed in the design system:
	// hero (16:9), editorial (4:3), and square (1:1, product/gallery/season).
	add_image_size( 'oja-talu-hero', 1600, 900, true );
	add_image_size( 'oja-talu-editorial', 1200, 900, true );
	add_image_size( 'oja-talu-square', 900, 900, true );

	load_theme_textdomain( 'oja-talu', OJA_TALU_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'oja_talu_setup' );

/**
 * Register the three custom image sizes with the media modal / block
 * editor image size dropdown, using the same labels as add_image_size().
 *
 * @param array $sizes Existing custom image size labels.
 * @return array Filtered image size labels.
 */
function oja_talu_custom_image_sizes( array $sizes ): array {
	return array_merge(
		$sizes,
		array(
			'oja-talu-hero'       => __( 'Hero (16:9)', 'oja-talu' ),
			'oja-talu-editorial'  => __( 'Editorial (4:3)', 'oja-talu' ),
			'oja-talu-square'     => __( 'Square (1:1)', 'oja-talu' ),
		)
	);
}
add_filter( 'image_size_names_choose', 'oja_talu_custom_image_sizes' );

/**
 * Enqueue the theme's global stylesheet.
 *
 * Everything expressible as a design token lives in theme.json and is
 * already output by WordPress core. base.css only carries what theme.json
 * cannot: resets, motion/focus accessibility rules, and the skip-link.
 */
function oja_talu_enqueue_assets(): void {
	wp_enqueue_style(
		'oja-talu-base',
		OJA_TALU_URI . '/assets/css/base.css',
		array(),
		OJA_TALU_VERSION
	);

	wp_enqueue_style(
		'oja-talu-components',
		OJA_TALU_URI . '/assets/css/components.css',
		array( 'oja-talu-base' ),
		OJA_TALU_VERSION
	);

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'oja-talu-woocommerce',
			OJA_TALU_URI . '/assets/css/woocommerce.css',
			array( 'oja-talu-components' ),
			OJA_TALU_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'oja_talu_enqueue_assets' );

/**
 * Add a `no-js` class to <html>, removed by JS on load — lets CSS give
 * every enhancement (like the footer's mobile accordion) a working
 * fallback state before JS has had a chance to run, per progressive-
 * enhancement rather than assuming JS is always available.
 *
 * @param string $output Existing language attributes string.
 * @return string Filtered attributes string with a class attribute appended.
 */
function oja_talu_no_js_class( string $output ): string {
	// Defensive: if another plugin's `language_attributes` filter already
	// added a class attribute, append to it instead of emitting a second
	// (technically invalid, if harmless) `class=""` attribute.
	if ( preg_match( '/class="([^"]*)"/', $output, $oja_matches ) ) {
		return str_replace( $oja_matches[0], 'class="' . trim( $oja_matches[1] . ' no-js' ) . '"', $output );
	}
	return $output . ' class="no-js"';
}
add_filter( 'language_attributes', 'oja_talu_no_js_class' );

/**
 * Print the skip-link markup right after <body>.
 *
 * Printed via a hook rather than hard-coded into parts/header.html so it
 * always exists even if the header template part is edited or replaced —
 * it targets #wp--skip-link--target, which WordPress core's block-based
 * templates already anchor to the start of the main content area.
 */
function oja_talu_skip_link(): void {
	printf(
		'<a class="skip-link" href="#wp--skip-link--target">%s</a>',
		esc_html__( 'Skip to content', 'oja-talu' )
	);
}
add_action( 'wp_body_open', 'oja_talu_skip_link' );
