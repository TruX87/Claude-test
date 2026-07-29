<?php
/**
 * Block style variations.
 *
 * Phase 4 deliberately chose these over two more fully-custom blocks:
 * the visual outcome the brand needs (fixed 1:1 gallery grid; serif
 * italic pull-quote) is achievable as a style variation of a core
 * block, which is less to maintain than a parallel custom block that
 * duplicates most of core/gallery's or core/quote's own behaviour.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the "Oja" style variations and their CSS.
 */
function oja_talu_register_block_styles(): void {
	register_block_style(
		'core/gallery',
		array(
			'name'  => 'oja-gallery',
			'label' => __( 'Oja', 'oja-talu' ),
		)
	);

	register_block_style(
		'core/quote',
		array(
			'name'  => 'oja-quote',
			'label' => __( 'Oja', 'oja-talu' ),
		)
	);
}
add_action( 'init', 'oja_talu_register_block_styles' );
