<?php
/**
 * Title: Home — Products
 * Slug: oja-talu/home-products
 * Categories: oja-talu
 * Inserter: yes
 *
 * Ships with four empty Product Feature slots — dynamic blocks with no
 * productId selected yet. Whoever populates the Homepage picks the
 * actual seasonal products in the block sidebar; this pattern only sets
 * up the layout, since real product IDs don't exist until the shop
 * catalogue is populated in Phase 6 content work.
 *
 * @package Oja_Talu
 */

$oja_url_shop = esc_url( oja_talu_url( 'shop' ) );
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|6"}}}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--6)">

	<!-- wp:paragraph {"fontSize":"label","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"}},"textColor":"moss-text"} -->
	<p class="has-moss-text-color has-text-color has-label-font-size">Poest</p>
	<!-- /wp:paragraph -->

	<!-- wp:columns -->
	<div class="wp-block-columns">
		<!-- wp:column --><div class="wp-block-column"><!-- wp:oja-talu/product-feature /--></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:oja-talu/product-feature /--></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:oja-talu/product-feature /--></div><!-- /wp:column -->
		<!-- wp:column --><div class="wp-block-column"><!-- wp:oja-talu/product-feature /--></div><!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"className":"is-style-outline","url":"<?php echo esc_js( $oja_url_shop ); ?>"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo $oja_url_shop; ?>">Külasta poodi</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

</div>
<!-- /wp:group -->
