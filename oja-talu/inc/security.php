<?php
/**
 * Security hardening.
 *
 * Small, auditable, code-based hardening rather than a heavy all-in-one
 * security plugin — per Phase 4 §12, fewer third-party codebases running
 * on the site is itself a security property, not just a performance one.
 *
 * @package Oja_Talu
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove the generator meta tag WordPress prints by default, which
 * advertises the exact core version to anyone viewing page source.
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Do the same for WooCommerce's own generator tag, and for the RSS feed
 * generator tag.
 *
 * @param string $gen Existing generator tag markup.
 * @return string Empty string.
 */
function oja_talu_remove_generator_tag( string $gen ): string {
	return '';
}
add_filter( 'the_generator', 'oja_talu_remove_generator_tag' );

/**
 * Disable the in-admin theme/plugin file editor. A compromised admin
 * account with file-edit access can turn into a full server compromise
 * in one paste; there's no legitimate workflow reason to edit theme
 * files through wp-admin on a site with real version control.
 */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

/**
 * Disable XML-RPC. This theme and its plugin stack (WooCommerce,
 * Polylang) don't rely on it, and it's a long-standing target for
 * brute-force and amplification attacks. Re-enable via this same filter
 * if a specific integration (e.g. a mobile app) later needs it.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Remove the RSD, WLW manifest, and shortlink meta tags — none of them
 * serve a purpose on this site and each is one more piece of fingerprint
 * information for free.
 */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/**
 * Send a conservative Referrer-Policy header. Keeps the destination
 * site from receiving the full URL (which could include a search query
 * or other detail) when a visitor clicks an outbound link.
 */
function oja_talu_referrer_policy_header(): void {
	if ( ! headers_sent() ) {
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	}
}
add_action( 'send_headers', 'oja_talu_referrer_policy_header' );
