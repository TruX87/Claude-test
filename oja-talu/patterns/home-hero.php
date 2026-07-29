<?php
/**
 * Title: Home — Hero
 * Slug: oja-talu/home-hero
 * Categories: oja-talu
 * Inserter: yes
 *
 * @package Oja_Talu
 */

$oja_url_story = esc_url( oja_talu_url( 'story' ) );
?>
<!-- wp:oja-talu/hero {"ctaText":"Avasta Oja talu","ctaUrl":"<?php echo esc_js( $oja_url_story ); ?>"} -->
<div class="wp-block-oja-talu-hero oja-hero"><div class="oja-hero__content"><h1 class="oja-hero__title">Digitaalne uks Oja tallu</h1><p class="oja-hero__lead">A quiet place where garden, fire and nature meet.</p><a class="oja-hero__cta" href="<?php echo $oja_url_story; ?>"><span>Avasta Oja talu</span></a></div></div>
<!-- /wp:oja-talu/hero -->
