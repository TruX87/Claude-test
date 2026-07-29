import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const { mediaUrl, mediaAlt, title, text, linkUrl } = attributes;
	const blockProps = useBlockProps.save( { className: 'oja-season' } );
	const Wrapper = linkUrl ? 'a' : 'div';
	const wrapperProps = linkUrl ? { href: linkUrl } : {};

	return (
		<div { ...blockProps }>
			<Wrapper className="oja-season__inner" { ...wrapperProps }>
				<div className="oja-season__media">
					{ mediaUrl && <img src={ mediaUrl } alt={ mediaAlt } loading="lazy" /> }
				</div>
				<div className="oja-season__content">
					<RichText.Content tagName="h3" value={ title } />
					<RichText.Content tagName="p" value={ text } />
				</div>
			</Wrapper>
		</div>
	);
}
