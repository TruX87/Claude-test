<?php
/**
 * Block pattern category.
 *
 * The pattern files themselves live in /patterns and are auto-registered
 * by WordPress core (any .php file in a block theme's /patterns folder
 * with the correct header comment is picked up automatically — no
 * register_block_pattern() calls needed here). This file only registers
 * the category label those files reference.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the "Oja Talu" pattern category.
 */
function oja_talu_register_pattern_category(): void {
	register_block_pattern_category(
		'oja-talu',
		array( 'label' => __( 'Oja Talu', 'oja-talu' ) )
	);
}
add_action( 'init', 'oja_talu_register_pattern_category' );
