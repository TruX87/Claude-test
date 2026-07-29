/**
 * Editor UI for oja-talu/brand-card.
 *
 * @package Oja_Talu
 */

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	MediaPlaceholder,
	MediaUpload,
	MediaUploadCheck,
	InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

const VARIANT_LABEL = {
	'oja-talu': 'Oja Talu',
	'oja-aed': 'Oja Aed',
	rohebaar: 'Rohebaar',
};

export default function Edit( { attributes, setAttributes } ) {
	const { variant, mediaUrl, mediaAlt, mediaId, title, description, linkText, linkUrl } = attributes;
	const blockProps = useBlockProps( { className: `oja-brand-card oja-brand-card--${ variant }` } );

	const onSelectMedia = ( media ) =>
		setAttributes( { mediaId: media.id, mediaUrl: media.url, mediaAlt: media.alt || '' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Link', 'oja-talu' ) }>
					<TextControl
						label={ __( 'Link text', 'oja-talu' ) }
						value={ linkText }
						onChange={ ( value ) => setAttributes( { linkText: value } ) }
					/>
					<TextControl
						label={ __( 'Destination URL', 'oja-talu' ) }
						value={ linkUrl }
						onChange={ ( value ) => setAttributes( { linkUrl: value } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<p className="oja-brand-card__eyebrow">{ VARIANT_LABEL[ variant ] }</p>
				{ ! mediaUrl ? (
					<MediaPlaceholder
						icon="format-image"
						labels={ { title: __( 'Card image', 'oja-talu' ) } }
						onSelect={ onSelectMedia }
						accept="image/*"
						allowedTypes={ [ 'image' ] }
					/>
				) : (
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ onSelectMedia }
							allowedTypes={ [ 'image' ] }
							value={ mediaId }
							render={ ( { open } ) => (
								<div role="button" tabIndex={ 0 } onClick={ open } onKeyDown={ ( e ) => ( e.key === 'Enter' ? open() : null ) }>
									{ /* eslint-disable-next-line jsx-a11y/alt-text */ }
									<img src={ mediaUrl } alt={ mediaAlt } />
								</div>
							) }
						/>
					</MediaUploadCheck>
				) }
				<RichText
					tagName="h3"
					value={ title }
					onChange={ ( value ) => setAttributes( { title: value } ) }
					placeholder={ VARIANT_LABEL[ variant ] }
					allowedFormats={ [] }
				/>
				<RichText
					tagName="p"
					value={ description }
					onChange={ ( value ) => setAttributes( { description: value } ) }
					placeholder={ __( 'One line…', 'oja-talu' ) }
					allowedFormats={ [] }
				/>
				{ linkText && <p className="oja-brand-card__link">{ linkText } →</p> }
			</div>
		</>
	);
}
