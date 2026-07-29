<?php
/**
 * Server-side render for oja-talu/journal-entry.
 *
 * Reads the current post from block context (set by the surrounding
 * Query Loop / Post Template block) rather than from attributes — this
 * block has no content of its own to configure, only a post to display.
 *
 * @package Oja_Talu
 *
 * @var array    $attributes Block attributes (unused).
 * @var string   $content    Inner block content (unused — no InnerBlocks).
 * @var WP_Block $block      Block instance, carrying postId/postType context.
 */

defined( 'ABSPATH' ) || exit;

$oja_post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();

if ( ! $oja_post_id ) {
	return '';
}

$oja_permalink = get_permalink( $oja_post_id );
$oja_title     = get_the_title( $oja_post_id );
$oja_date      = get_the_date( '', $oja_post_id );
$oja_date_iso  = get_the_date( 'c', $oja_post_id );
$oja_excerpt   = get_the_excerpt( $oja_post_id );
$oja_thumb     = get_the_post_thumbnail(
	$oja_post_id,
	'oja-talu-editorial',
	array( 'loading' => 'lazy' )
);

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'oja-journal-entry' ) );
?>
<div <?php echo wp_kses_post( $wrapper_attributes ); ?>>
	<a class="oja-journal-entry__link-wrap" href="<?php echo esc_url( $oja_permalink ); ?>">
		<?php if ( $oja_thumb ) : ?>
			<div class="oja-journal-entry__media"><?php echo wp_kses_post( $oja_thumb ); ?></div>
		<?php endif; ?>
		<time class="oja-journal-entry__date" datetime="<?php echo esc_attr( $oja_date_iso ); ?>">
			<?php echo esc_html( $oja_date ); ?>
		</time>
		<h3 class="oja-journal-entry__title"><?php echo esc_html( $oja_title ); ?></h3>
		<p class="oja-journal-entry__excerpt"><?php echo esc_html( wp_strip_all_tags( $oja_excerpt ) ); ?></p>
	</a>
</div>
