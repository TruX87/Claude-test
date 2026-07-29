<?php
/**
 * Title: Visit — Info
 * Slug: oja-talu/visit-info
 * Categories: oja-talu
 * Inserter: yes
 *
 * @package Oja_Talu
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|6"}}}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--6)">
	<!-- wp:heading {"level":1,"fontSize":"h1"} -->
	<h1 class="wp-block-heading has-h1-font-size">Külasta meid</h1>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"fontSize":"body-lg"} -->
	<p class="has-body-lg-font-size">Oja Talu, Saaremaa — avatud kokkuleppel.</p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:oja-talu/visit {"address":"Oja tee 4, Saaremaa","hours":"Kokkuleppel, Rohebaar reede–pühapäev 17–22","phone":"+372 5xxx xxxx","directionsUrl":"#"} -->
<div class="wp-block-oja-talu-visit oja-visit"><div class="oja-visit__info"><dl class="oja-visit__list"><dt>Aadress</dt><dd>Oja tee 4, Saaremaa</dd><dt>Avatud</dt><dd>Kokkuleppel, Rohebaar reede–pühapäev 17–22</dd><dt>Telefon</dt><dd><a href="tel:+3725xxxxxxx">+372 5xxx xxxx</a></dd></dl><p class="oja-visit__note">Sissesõidutee on kitsas ja käänuline — sõida aeglaselt, viimane lõik on kruusatee.</p><a class="oja-visit__cta" href="#">Vaata suunda</a></div></div>
<!-- /wp:oja-talu/visit -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"680px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|5","bottom":"var:preset|spacing|6"}}}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--5);padding-bottom:var(--wp--preset--spacing--6)">
	<!-- wp:paragraph {"fontSize":"label","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"}},"textColor":"moss"} -->
	<p class="has-moss-color has-text-color has-label-font-size">Kirjuta meile</p>
	<!-- /wp:paragraph -->

	<!-- wp:shortcode -->
	[oja_contact_form]
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
