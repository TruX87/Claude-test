/**
 * Oja Talu — Interactivity API store.
 *
 * Powers three small, calm enhancements (Design System §19 — motion
 * exists to create calm, not entertainment): the header gaining a
 * hairline once scrolled, the footer's mobile accordion, and the
 * product page's sticky "back to purchase" bar.
 *
 * Deliberately self-initialising via plain selectors rather than
 * `data-wp-init`/`data-wp-interactive` directives hand-added to the
 * template HTML files: static blocks (core/group, core/navigation) are
 * re-serialized from their own known attributes whenever an editor
 * re-saves a template in the Site Editor, which would silently strip
 * any directive attribute this theme added by hand to that markup. The
 * store/state/actions pattern below still comes from
 * `@wordpress/interactivity` (no jQuery, no ad hoc globals) — only the
 * *wiring* is a plain querySelector, so it survives a template re-save.
 * Written as a plain ES module — no build step needed for this file.
 *
 * @package Oja_Talu
 */

import { store } from '@wordpress/interactivity';

const { state } = store( 'oja-talu', {
	state: {
		isHeaderScrolled: false,
	},
} );

/**
 * Header: add a class once the page has scrolled past the hero, so CSS
 * can give it a solid background + hairline border instead of a shadow.
 */
function initHeaderScroll() {
	const header = document.querySelector( '.oja-header' );
	if ( ! header ) {
		return;
	}
	const onScroll = () => {
		state.isHeaderScrolled = window.scrollY > 40;
		header.classList.toggle( 'is-scrolled', state.isHeaderScrolled );
	};
	onScroll();
	window.addEventListener( 'scroll', onScroll, { passive: true } );
}

/**
 * Footer: each column's heading toggles that column's nav open/closed
 * on mobile. On desktop the CSS in components.css ignores this
 * attribute entirely and always shows every column.
 */
function initFooterAccordion() {
	const headings = document.querySelectorAll( '.oja-footer .wp-block-column > .wp-block-heading' );
	headings.forEach( ( heading ) => {
		const column = heading.closest( '.wp-block-column' );
		heading.setAttribute( 'role', 'button' );
		heading.setAttribute( 'tabindex', '0' );
		heading.setAttribute( 'aria-expanded', 'false' );

		const toggle = () => {
			const isOpen = column.getAttribute( 'data-oja-expanded' ) === 'true';
			column.setAttribute( 'data-oja-expanded', isOpen ? 'false' : 'true' );
			heading.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
		};

		heading.addEventListener( 'click', toggle );
		heading.addEventListener( 'keydown', ( event ) => {
			if ( event.key === 'Enter' || event.key === ' ' ) {
				event.preventDefault();
				toggle();
			}
		} );
	} );
}

/**
 * Product page: show a persistent mobile "back to purchase" bar once
 * the real Add to Cart form has scrolled out of view. Uses
 * IntersectionObserver rather than a scroll-position calculation —
 * cheaper, and correct regardless of page length.
 */
function initStickyAddToCart() {
	const form = document.querySelector( '.wp-block-woocommerce-add-to-cart-form' );
	const bar = document.querySelector( '.oja-sticky-atc' );
	if ( ! form || ! bar || typeof IntersectionObserver === 'undefined' ) {
		return;
	}

	const observer = new IntersectionObserver(
		( [ entry ] ) => {
			bar.classList.toggle( 'is-visible', ! entry.isIntersecting );
		},
		{ rootMargin: '-56px 0px 0px 0px' }
	);
	observer.observe( form );

	const jumpButton = bar.querySelector( '.oja-sticky-atc__button' );
	if ( jumpButton ) {
		jumpButton.addEventListener( 'click', () => {
			form.scrollIntoView( { behavior: 'smooth', block: 'center' } );
		} );
	}
}

document.addEventListener( 'DOMContentLoaded', () => {
	initHeaderScroll();
	initFooterAccordion();
	initStickyAddToCart();
	document.documentElement.classList.remove( 'no-js' );
} );
