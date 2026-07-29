<?php
/**
 * Internal URL resolution.
 *
 * Patterns and template parts need to link to key pages (Shop, Journal,
 * the three brand pages, Visit) before those pages necessarily exist
 * yet — a fresh theme activation has no content. Rather than hard-code
 * `/pood/`-style paths everywhere and silently break the moment a slug
 * changes, every internal link in this theme is supposed to run through
 * this one function, so there's exactly one place to fix if a page gets
 * renamed or a client wants different slugs.
 *
 * Limitation this does NOT solve: `core/navigation-link` blocks (used in
 * parts/header.html and parts/footer.html) store a plain `url` string
 * attribute at save time — WordPress does not re-resolve it from a page
 * ID on every render the way this function does. Those links are set to
 * sensible best-guess paths and must be corrected once the real pages
 * exist, by opening the Navigation block in the Site Editor and
 * re-pointing each link at the actual page (see README.md).
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Resolve a semantic page key to its real URL.
 *
 * @param string $key One of: home, story, oja-aed, rohebaar, shop,
 *                     journal, visit, contact.
 * @return string Absolute URL. Falls back to a best-guess path built
 *                from the expected slug if the page doesn't exist yet
 *                (e.g. on a fresh install before content is populated).
 */
function oja_talu_url( string $key ): string {
	if ( 'home' === $key ) {
		return home_url( '/' );
	}

	$oja_slugs = array(
		'story'    => 'meie-lugu',
		'oja-aed'  => 'oja-aed',
		'rohebaar' => 'rohebaar',
		'shop'     => 'pood',
		'journal'  => 'paevik',
		'visit'    => 'kulasta-meid',
		'contact'  => 'kontakt',
	);

	if ( ! isset( $oja_slugs[ $key ] ) ) {
		return home_url( '/' );
	}

	$oja_slug = $oja_slugs[ $key ];

	// Journal is a CPT archive, not a Page — resolve via its own
	// rewrite slug rather than get_page_by_path().
	if ( 'journal' === $key ) {
		$oja_link = get_post_type_archive_link( 'oja_journal' );
		return $oja_link ? $oja_link : home_url( '/' . $oja_slug . '/' );
	}

	$oja_page = get_page_by_path( $oja_slug );
	if ( $oja_page instanceof WP_Post ) {
		$oja_link = get_permalink( $oja_page );
		if ( $oja_link ) {
			return $oja_link;
		}
	}

	return home_url( '/' . $oja_slug . '/' );
}
