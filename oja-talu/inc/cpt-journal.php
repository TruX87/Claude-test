<?php
/**
 * Journal custom post type.
 *
 * The Restoration Journal is the chronological record of the farmstead
 * restoration (Phase 1 UX Architecture, "person following the restoration
 * journey"). It is a real post type — not a category on Posts — so its
 * archive gets a clean canonical URL and its own template, per the Phase 4
 * decision to avoid a manually query-looped Page.
 *
 * Deliberately minimal: title, content, featured image, and excerpt are
 * all it needs. No custom taxonomy is registered yet — Phase 4 flagged a
 * "milestone" taxonomy as easy to add later if the archive ever needs
 * filtering, and building it speculatively now would be exactly the kind
 * of premature abstraction this project has otherwise avoided.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the `oja_journal` post type.
 */
function oja_talu_register_journal_cpt(): void {
	register_post_type(
		'oja_journal',
		array(
			'labels'              => array(
				'name'                  => __( 'Journal', 'oja-talu' ),
				'singular_name'         => __( 'Journal Entry', 'oja-talu' ),
				'add_new_item'          => __( 'Add New Journal Entry', 'oja-talu' ),
				'edit_item'             => __( 'Edit Journal Entry', 'oja-talu' ),
				'view_item'             => __( 'View Journal Entry', 'oja-talu' ),
				'all_items'             => __( 'Journal', 'oja-talu' ),
				'search_items'          => __( 'Search Journal', 'oja-talu' ),
				'not_found'             => __( 'No journal entries found', 'oja-talu' ),
				'archives'              => __( 'Journal Archive', 'oja-talu' ),
			),
			'public'              => true,
			'has_archive'         => true,
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-book-alt',
			'menu_position'       => 20,
			'rewrite'             => array(
				'slug'       => 'paevik',
				'with_front' => false,
			),
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields' ),
			'template'            => array( array( 'oja-talu/journal-entry' ) ),
			'template_lock'       => false,
			'exclude_from_search' => false,
		)
	);
}
add_action( 'init', 'oja_talu_register_journal_cpt' );

/**
 * Flush rewrite rules once on theme activation so /paevik/ resolves
 * immediately instead of requiring a manual visit to Settings → Permalinks.
 */
function oja_talu_flush_rewrites_on_switch(): void {
	oja_talu_register_journal_cpt();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'oja_talu_flush_rewrites_on_switch' );

/**
 * Expose a ready-to-use featured image URL over the REST API.
 *
 * The default REST response only includes the attachment ID
 * (`featured_media`), which would require a second request to resolve to
 * a URL. The oja-talu/journal-entry block's editor preview (edit.js)
 * reads this field directly so the Journal archive doesn't fire one
 * REST call per post just to render a thumbnail in the editor.
 */
function oja_talu_register_journal_media_rest_field(): void {
	register_rest_field(
		'oja_journal',
		'oja_featured_media_url',
		array(
			'get_callback' => function ( array $post ): string {
				$thumbnail_id = get_post_thumbnail_id( $post['id'] );
				if ( ! $thumbnail_id ) {
					return '';
				}
				$url = wp_get_attachment_image_url( $thumbnail_id, 'oja-talu-editorial' );
				return $url ? $url : '';
			},
			'schema'       => array(
				'type'        => 'string',
				'description' => __( 'Featured image URL, sized for editorial (4:3) use.', 'oja-talu' ),
				'context'     => array( 'view', 'edit' ),
			),
		)
	);
}
add_action( 'rest_api_init', 'oja_talu_register_journal_media_rest_field' );
