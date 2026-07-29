/**
 * Editor UI for oja-talu/season.
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

export default function Edit( { attributes, setAttributes } ) {
	const { mediaUrl, mediaAlt, mediaId, title, text, linkUrl } = attributes;
	const blockProps = useBlockProps( { className: 'oja-season' } );
	const onSelectMedia = ( media ) =>
		setAttributes( { mediaId: media.id, mediaUrl: media.url, mediaAlt: media.alt || '' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Link (optional)', 'oja-talu' ) }>
					<TextControl
						label={ __( 'URL', 'oja-talu' ) }
						value={ linkUrl }
						onChange={ ( value ) => setAttributes( { linkUrl: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<div className="oja-season__media">
					{ ! mediaUrl ? (
						<MediaPlaceholder
							icon="format-image"
							labels={ { title: __( 'Season image', 'oja-talu' ) } }
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
				</div>
				<div className="oja-season__content">
					<RichText
						tagName="h3"
						value={ title }
						onChange={ ( value ) => setAttributes( { title: value } ) }
						placeholder={ __( 'e.g. Juuli aias', 'oja-talu' ) }
						allowedFormats={ [] }
					/>
					<RichText
						tagName="p"
						value={ text }
						onChange={ ( value ) => setAttributes( { text: value } ) }
						placeholder={ __( 'A line or two…', 'oja-talu' ) }
						allowedFormats={ [ 'core/italic' ] }
					/>
				</div>
			</div>
		</>
	);
}
