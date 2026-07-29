/**
 * Front-end markup for oja-talu/hero.
 *
 * The CTA renders as a real <a href> — never a <span> or <button> with a
 * click handler bolted on — so it works with no JavaScript, is a real
 * link for screen readers and search engines, and is keyboard-operable
 * with no extra ARIA plumbing.
 *
 * @package Oja_Talu
 */

import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const { mediaUrl, mediaAlt, title, lead, ctaText, ctaUrl } = attributes;
	const blockProps = useBlockProps.save( { className: 'oja-hero' } );

	return (
		<div { ...blockProps }>
			{ mediaUrl && (
				<img
					className="oja-hero__media"
					src={ mediaUrl }
					alt={ mediaAlt }
					loading="eager"
					fetchpriority="high"
				/>
			) }
			<div className="oja-hero__content">
				<RichText.Content tagName="h1" className="oja-hero__title" value={ title } />
				<RichText.Content tagName="p" className="oja-hero__lead" value={ lead } />
				{ ctaText && ctaUrl && (
					<a className="oja-hero__cta" href={ ctaUrl }>
						<RichText.Content tagName="span" value={ ctaText } />
					</a>
				) }
			</div>
		</div>
	);
}
