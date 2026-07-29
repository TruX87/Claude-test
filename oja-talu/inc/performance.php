<?php
/**
 * Performance: font preloading and the Interactivity API script module.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Preload the two above-the-fold font files (Fraunces regular weight for
 * the hero heading, Work Sans for body copy) so the browser starts
 * fetching them before it discovers the @font-face rules in theme.json's
 * generated CSS — the highest-impact, lowest-risk font optimisation
 * available without a build step.
 */
function oja_talu_preload_fonts(): void {
	$oja_fonts = array(
		'/assets/fonts/Fraunces-Variable.woff2',
		'/assets/fonts/WorkSans-Variable.woff2',
	);

	foreach ( $oja_fonts as $oja_font_path ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin />' . "\n",
			esc_url( OJA_TALU_URI . $oja_font_path )
		);
	}
}
add_action( 'wp_head', 'oja_talu_preload_fonts', 1 );

/**
 * Register and enqueue the small Interactivity API script module that
 * powers the header scroll state, the footer mobile accordion, and the
 * product page's sticky add-to-cart bar.
 *
 * Written as a plain ES module (no @wordpress/scripts build step) since
 * WordPress's script-module system resolves the `@wordpress/interactivity`
 * import via its own import map — see Phase 4 §10, "no separate frontend
 * bundler" for anything this small.
 */
function oja_talu_register_interactivity(): void {
	wp_register_script_module(
		'oja-talu-interactivity',
		OJA_TALU_URI . '/assets/js/interactivity.js',
		array( '@wordpress/interactivity' ),
		OJA_TALU_VERSION
	);
	wp_enqueue_script_module( 'oja-talu-interactivity' );
}
add_action( 'wp_enqueue_scripts', 'oja_talu_register_interactivity' );
