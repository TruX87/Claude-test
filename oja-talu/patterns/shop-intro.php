<?php
/**
 * Title: Shop — Intro
 * Slug: oja-talu/shop-intro
 * Categories: oja-talu
 * Inserter: yes
 *
 * Sits above WooCommerce's native Product Collection block on both the
 * main shop archive (templates/archive-product.html) and each category
 * archive (templates/taxonomy-product_cat.html), so the same tab bar
 * appears everywhere in the shop. Category tabs are plain links to each
 * product_cat archive — no faceted-search sidebar, per Design System
 * §16 ("boutique farm shop, not Amazon") — with the current category
 * marked active, computed here rather than hard-coded, since this same
 * pattern renders on every shop page.
 *
 * @package Oja_Talu
 */

$oja_current_term_id = 0;
if ( is_tax( 'product_cat' ) ) {
	$oja_queried = get_queried_object();
	if ( $oja_queried instanceof WP_Term ) {
		$oja_current_term_id = $oja_queried->term_id;
	}
}

/**
 * @param string $slug Category slug to link to.
 * @return string Real term archive URL if the term exists yet, otherwise
 *                a best-guess URL so the tab still renders sensibly on a
 *                fresh install before categories have been created.
 */
$oja_cat_url = function ( string $slug ) {
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( $term instanceof WP_Term ) {
		$link = get_term_link( $term );
		if ( ! is_wp_error( $link ) ) {
			return $link;
		}
	}
	return home_url( '/toote-kategooria/' . $slug . '/' );
};

$oja_tabs = array(
	''             => __( 'Kõik', 'oja-talu' ),
	'aiasaadused'  => __( 'Aiasaadused', 'oja-talu' ),
	'piimatooted'  => __( 'Piimatooted', 'oja-talu' ),
	'hoidised'     => __( 'Hoidised', 'oja-talu' ),
	'kasitoo'      => __( 'Käsitöö', 'oja-talu' ),
);
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|5"}}}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--5)">

	<?php if ( is_tax( 'product_cat' ) ) : ?>
		<h1 class="wp-block-heading has-h1-font-size"><?php single_term_title(); ?></h1>
	<?php else : ?>
	<!-- wp:heading {"level":1,"fontSize":"h1"} -->
	<h1 class="wp-block-heading has-h1-font-size">Pood</h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"body-lg"} -->
	<p class="has-body-lg-font-size">Valmistame väikestes kogustes seda, mida aed ja aastaajad meile annavad.</p>
	<!-- /wp:paragraph -->
	<?php endif; ?>

	<div class="oja-shop-tabs has-label-font-size">
		<?php foreach ( $oja_tabs as $oja_slug => $oja_label ) : ?>
			<?php
			if ( '' === $oja_slug ) {
				$oja_is_active = ! is_tax( 'product_cat' );
				$oja_url       = home_url( '/pood/' );
			} else {
				$oja_term      = get_term_by( 'slug', $oja_slug, 'product_cat' );
				$oja_is_active = $oja_term instanceof WP_Term && $oja_current_term_id === $oja_term->term_id;
				$oja_url       = $oja_cat_url( $oja_slug );
			}
			?>
			<a class="oja-shop-tabs__tab<?php echo $oja_is_active ? ' is-active' : ''; ?>" href="<?php echo esc_url( $oja_url ); ?>">
				<?php echo esc_html( $oja_label ); ?>
			</a>
		<?php endforeach; ?>
	</div>

</div>
<!-- /wp:group -->
