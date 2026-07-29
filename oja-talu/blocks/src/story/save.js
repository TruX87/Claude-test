/**
 * Front-end markup for oja-talu/story.
 *
 * Markup order is always image-then-text regardless of `imagePosition` —
 * only a CSS class controls the visual side, so assistive tech always
 * gets a sensible reading order (Design System component spec, §7).
 *
 * @package Oja_Talu
 */

import { useBlockProps, RichText, InnerBlocks } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const { mediaUrl, mediaAlt, imagePosition, heading } = attributes;
	const blockProps = useBlockProps.save( {
		className: `oja-story oja-story--${ imagePosition }`,
	} );

	return (
		<div { ...blockProps }>
			<div className="oja-story__media">
				{ mediaUrl && <img src={ mediaUrl } alt={ mediaAlt } loading="lazy" /> }
			</div>
			<div className="oja-story__content">
				<RichText.Content tagName="h2" value={ heading } />
				<div className="oja-story__body">
					<InnerBlocks.Content />
				</div>
			</div>
		</div>
	);
}
