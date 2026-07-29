<?php
/**
 * Title: Home — Journal Preview
 * Slug: oja-talu/home-journal
 * Categories: oja-talu
 * Inserter: yes
 *
 * Pulls the two most recent Journal entries live via a Query Loop rather
 * than hand-authoring sample entries into the pattern — journal content
 * changes constantly, so the pattern must never go stale.
 *
 * @package Oja_Talu
 */

$oja_url_journal = esc_url( oja_talu_url( 'journal' ) );
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|6"}}}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--6)">

	<!-- wp:paragraph {"fontSize":"label","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em"}},"textColor":"moss-text"} -->
	<p class="has-moss-text-color has-text-color has-label-font-size">Päevik</p>
	<!-- /wp:paragraph -->

	<!-- wp:query {"queryId":10,"query":{"perPage":2,"postType":"oja_journal","order":"desc","orderBy":"date","inherit":false},"layout":{"type":"default"}} -->
	<div class="wp-block-query">
		<!-- wp:post-template -->
			<!-- wp:oja-talu/journal-entry /-->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"className":"is-style-outline","url":"<?php echo esc_js( $oja_url_journal ); ?>"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo $oja_url_journal; ?>">Loe päevikut</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

</div>
<!-- /wp:group -->
