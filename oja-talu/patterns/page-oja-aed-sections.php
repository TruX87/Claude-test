<?php
/**
 * Title: Page — Oja Aed Sections
 * Slug: oja-talu/page-oja-aed-sections
 * Categories: oja-talu
 * Inserter: yes
 *
 * @package Oja_Talu
 */

$oja_aed_cat_term = get_term_by( 'slug', 'oja-aed', 'product_cat' );
$oja_aed_cat_url  = $oja_aed_cat_term instanceof WP_Term && ! is_wp_error( get_term_link( $oja_aed_cat_term ) )
	? get_term_link( $oja_aed_cat_term )
	: oja_talu_url( 'shop' );
$oja_aed_cat_url  = esc_url( $oja_aed_cat_url );
?>
<!-- wp:oja-talu/hero -->
<div class="wp-block-oja-talu-hero oja-hero"><div class="oja-hero__content"><h1 class="oja-hero__title">Oja Aed</h1><p class="oja-hero__lead">Aed, mis annab meile kõik, mida hooaeg lubab.</p></div></div>
<!-- /wp:oja-talu/hero -->

<!-- wp:oja-talu/story {"imagePosition":"left"} -->
<div class="wp-block-oja-talu-story oja-story oja-story--left"><div class="oja-story__media"></div><div class="oja-story__content"><h2>Lilled</h2><div class="oja-story__body"><!-- wp:paragraph -->
<p>Roosid on siin peaaegu sama vanad kui maja ise. Igal suvel korjame need käsitsi, õigel hommikutunnil.</p>
<!-- /wp:paragraph --></div></div></div>
<!-- /wp:oja-talu/story -->

<!-- wp:oja-talu/story {"imagePosition":"right"} -->
<div class="wp-block-oja-talu-story oja-story oja-story--right"><div class="oja-story__media"></div><div class="oja-story__content"><h2>Ürdid</h2><div class="oja-story__body"><!-- wp:paragraph -->
<p>Ürdipeenar kasvab kontrollimatult ja täpselt nii, nagu tahame. Kuivatame ja seome kimpudeks talveks.</p>
<!-- /wp:paragraph --></div></div></div>
<!-- /wp:oja-talu/story -->

<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|5"}}}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--5)">
	<!-- wp:heading {"level":2,"fontSize":"h2"} -->
	<h2 class="wp-block-heading has-h2-font-size">Tooted</h2>
	<!-- /wp:heading -->

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
		<!-- wp:button {"className":"is-style-outline","url":"<?php echo esc_js( $oja_aed_cat_url ); ?>"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo $oja_aed_cat_url; ?>">Vaata kõiki Oja Aed tooteid</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:oja-talu/story {"imagePosition":"left"} -->
<div class="wp-block-oja-talu-story oja-story oja-story--left"><div class="oja-story__media"></div><div class="oja-story__content"><h2>Käsitöö</h2><div class="oja-story__body"><!-- wp:paragraph -->
<p>Aiasaadustele lisaks teeme puidust ja looduslikest materjalidest väikeseid esemeid — need, mida ise iga päev kasutame.</p>
<!-- /wp:paragraph --></div></div></div>
<!-- /wp:oja-talu/story -->
