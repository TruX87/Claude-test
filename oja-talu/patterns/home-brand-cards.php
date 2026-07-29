<?php
/**
 * Title: Home — Three Brands
 * Slug: oja-talu/home-brand-cards
 * Categories: oja-talu
 * Inserter: yes
 *
 * Links resolve via oja_talu_url() (inc/urls.php) rather than hard-coded
 * paths, so they follow the real page if its slug ever changes.
 *
 * @package Oja_Talu
 */

$oja_url_story    = esc_url( oja_talu_url( 'story' ) );
$oja_url_oja_aed  = esc_url( oja_talu_url( 'oja-aed' ) );
$oja_url_rohebaar = esc_url( oja_talu_url( 'rohebaar' ) );
?>
<!-- wp:oja-talu/brand-cards -->
<div class="wp-block-oja-talu-brand-cards oja-brand-cards">

<!-- wp:oja-talu/brand-card {"variant":"oja-talu","linkText":"Loe rohkem","linkUrl":"<?php echo esc_js( $oja_url_story ); ?>"} -->
<div class="wp-block-oja-talu-brand-card oja-brand-card oja-brand-card--oja-talu"><a class="oja-brand-card__link-wrap" href="<?php echo $oja_url_story; ?>"><h3>Oja Talu</h3><p>Koht, lugu, perekond</p><span class="oja-brand-card__cta">Loe rohkem →</span></a></div>
<!-- /wp:oja-talu/brand-card -->

<!-- wp:oja-talu/brand-card {"variant":"oja-aed","linkText":"Loe rohkem","linkUrl":"<?php echo esc_js( $oja_url_oja_aed ); ?>"} -->
<div class="wp-block-oja-talu-brand-card oja-brand-card oja-brand-card--oja-aed"><a class="oja-brand-card__link-wrap" href="<?php echo $oja_url_oja_aed; ?>"><h3>Oja Aed</h3><p>Aed, tooted, käsitöö</p><span class="oja-brand-card__cta">Loe rohkem →</span></a></div>
<!-- /wp:oja-talu/brand-card -->

<!-- wp:oja-talu/brand-card {"variant":"rohebaar","linkText":"Loe rohkem","linkUrl":"<?php echo esc_js( $oja_url_rohebaar ); ?>"} -->
<div class="wp-block-oja-talu-brand-card oja-brand-card oja-brand-card--rohebaar"><a class="oja-brand-card__link-wrap" href="<?php echo $oja_url_rohebaar; ?>"><h3>Rohebaar</h3><p>Toit, jook, elamus</p><span class="oja-brand-card__cta">Loe rohkem →</span></a></div>
<!-- /wp:oja-talu/brand-card -->

</div>
<!-- /wp:oja-talu/brand-cards -->
