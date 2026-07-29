<?php
/**
 * Oja Talu theme bootstrap.
 *
 * This file intentionally contains no logic beyond wiring up the includes
 * in /inc. Each concern (theme setup, blocks, patterns, WooCommerce, SEO,
 * performance, security) lives in its own file so a maintainer can find
 * and change one behaviour without reading the whole theme.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

define( 'OJA_TALU_VERSION', '0.1.0' );
define( 'OJA_TALU_DIR', get_template_directory() );
define( 'OJA_TALU_URI', get_template_directory_uri() );

$oja_talu_includes = array(
	'inc/theme-setup.php',    // add_theme_support, nav menus, image sizes.
	'inc/block-styles.php',   // register_block_style() variations (gallery, quote).
	'inc/blocks.php',         // custom block registration.
	'inc/patterns.php',       // block pattern + pattern category registration.
	'inc/cpt-journal.php',    // Journal custom post type.
	'inc/forms.php',          // Contact form shortcode + submission handler.
	'inc/performance.php',    // font preloads, image/script tuning.
	'inc/security.php',       // hardening filters.
	'inc/seo.php',            // meta description, Open Graph, JSON-LD schema.
);

// WooCommerce-dependent code only loads if WooCommerce is actually active,
// so this theme does not fatal-error on a site that hasn't installed it yet.
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
	$oja_talu_includes[] = 'inc/woocommerce.php';
}

foreach ( $oja_talu_includes as $oja_talu_file ) {
	$oja_talu_path = OJA_TALU_DIR . '/' . $oja_talu_file;
	if ( is_readable( $oja_talu_path ) ) {
		require_once $oja_talu_path;
	}
}
unset( $oja_talu_includes, $oja_talu_file, $oja_talu_path );
