/**
 * Front-end markup for oja-talu/brand-card.
 *
 * The whole card is a single <a> — one tab stop, not three — wrapping
 * image, title, and description, per the component's accessibility
 * requirement in the Phase 2 spec.
 *
 * @package Oja_Talu
 */

import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const { variant, mediaUrl, mediaAlt, title, description, linkText, linkUrl } = attributes;
	const blockProps = useBlockProps.save( { className: `oja-brand-card oja-brand-card--${ variant }` } );

	return (
		<div { ...blockProps }>
			<a className="oja-brand-card__link-wrap" href={ linkUrl || '#' }>
				{ mediaUrl && <img src={ mediaUrl } alt={ mediaAlt } loading="lazy" /> }
				<RichText.Content tagName="h3" value={ title } />
				<RichText.Content tagName="p" value={ description } />
				{ linkText && <span className="oja-brand-card__cta">{ linkText } →</span> }
			</a>
		</div>
	);
}
