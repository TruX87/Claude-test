<?php
/**
 * Custom block registration.
 *
 * Blocks are authored in blocks/src and compiled by @wordpress/scripts
 * into blocks/build (see package.json). This file only registers the
 * compiled output — it has no knowledge of JSX/Sass, so it works
 * whether or not Node is available on the server.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add a dedicated "Oja Talu" category to the block inserter so the eight
 * custom blocks aren't scattered across Text/Media/Design.
 *
 * @param array $categories Existing block categories.
 * @return array Filtered block categories.
 */
function oja_talu_block_categories( array $categories ): array {
	return array_merge(
		array(
			array(
				'slug'  => 'oja-talu',
				'title' => __( 'Oja Talu', 'oja-talu' ),
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'oja_talu_block_categories' );

/**
 * Register every compiled block in blocks/build.
 *
 * Each block folder's block.json is the single source of truth for its
 * name, attributes, and asset handles — register_block_type_from_metadata()
 * reads it directly rather than repeating that information in PHP.
 */
function oja_talu_register_blocks(): void {
	$oja_build_dir = OJA_TALU_DIR . '/blocks/build';

	if ( ! is_dir( $oja_build_dir ) ) {
		return;
	}

	$oja_block_dirs = glob( $oja_build_dir . '/*', GLOB_ONLYDIR );

	foreach ( (array) $oja_block_dirs as $oja_block_dir ) {
		if ( is_readable( $oja_block_dir . '/block.json' ) ) {
			register_block_type( $oja_block_dir );
		}
	}
}
add_action( 'init', 'oja_talu_register_blocks' );

/**
 * Load JS translation files for each block script, so fixed UI strings
 * inside save()'d markup (e.g. the Visit block's "Aadress"/"Avatud"
 * labels) are translated per site language rather than frozen to
 * whichever locale the editor happened to be using when they saved.
 *
 * Reads the actual registered script handle off each block type rather
 * than guessing WordPress's handle-naming convention by hand — the
 * guessed names (`{block-name}-editor-script`) are usually right, but
 * "usually" isn't good enough for something that fails silently
 * (an unmatched handle just means translations never load, with no
 * error to notice). This runs after oja_talu_register_blocks() so the
 * block types actually exist to inspect.
 *
 * Translation .json files are generated with `wp i18n make-json` from
 * the theme's languages/*.po files and placed in /languages.
 */
function oja_talu_set_block_script_translations(): void {
	$oja_registry = WP_Block_Type_Registry::get_instance();

	foreach ( $oja_registry->get_all_registered() as $oja_block_name => $oja_block_type ) {
		if ( ! str_starts_with( $oja_block_name, 'oja-talu/' ) ) {
			continue;
		}

		// WP 5.9+ blocks may register multiple script handles
		// (`editor_script_handles`); older/simple registrations use the
		// singular `editor_script`. Check both rather than assuming.
		$oja_handles = array();
		if ( ! empty( $oja_block_type->editor_script_handles ) ) {
			$oja_handles = (array) $oja_block_type->editor_script_handles;
		} elseif ( ! empty( $oja_block_type->editor_script ) ) {
			$oja_handles = array( $oja_block_type->editor_script );
		}

		foreach ( $oja_handles as $oja_handle ) {
			wp_set_script_translations( $oja_handle, 'oja-talu', OJA_TALU_DIR . '/languages' );
		}
	}
}
add_action( 'init', 'oja_talu_set_block_script_translations', 20 );
