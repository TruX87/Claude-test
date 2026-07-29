/**
 * Editor UI for oja-talu/visit.
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
	const {
		address,
		hours,
		phone,
		arrivalNote,
		mapImageUrl,
		mapImageAlt,
		mapImageId,
		directionsUrl,
	} = attributes;
	const blockProps = useBlockProps( { className: 'oja-visit' } );

	const onSelectMedia = ( media ) =>
		setAttributes( { mapImageId: media.id, mapImageUrl: media.url, mapImageAlt: media.alt || '' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Directions link', 'oja-talu' ) }>
					<TextControl
						label={ __( 'Maps URL', 'oja-talu' ) }
						value={ directionsUrl }
						onChange={ ( value ) => setAttributes( { directionsUrl: value } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="oja-visit__info">
					<div className="oja-visit__field">
						<span className="oja-visit__label">{ __( 'Aadress', 'oja-talu' ) }</span>
						<TextControl value={ address } onChange={ ( v ) => setAttributes( { address: v } ) } />
					</div>
					<div className="oja-visit__field">
						<span className="oja-visit__label">{ __( 'Avatud', 'oja-talu' ) }</span>
						<TextControl value={ hours } onChange={ ( v ) => setAttributes( { hours: v } ) } />
					</div>
					<div className="oja-visit__field">
						<span className="oja-visit__label">{ __( 'Telefon', 'oja-talu' ) }</span>
						<TextControl value={ phone } onChange={ ( v ) => setAttributes( { phone: v } ) } />
					</div>
					<RichText
						tagName="p"
						className="oja-visit__note"
						value={ arrivalNote }
						onChange={ ( v ) => setAttributes( { arrivalNote: v } ) }
						placeholder={ __( 'What to expect on arrival…', 'oja-talu' ) }
						allowedFormats={ [] }
					/>
				</div>

				<div className="oja-visit__map">
					{ ! mapImageUrl ? (
						<MediaPlaceholder
							icon="location"
							labels={ { title: __( 'Static map image', 'oja-talu' ) } }
							onSelect={ onSelectMedia }
							accept="image/*"
							allowedTypes={ [ 'image' ] }
						/>
					) : (
						<MediaUploadCheck>
							<MediaUpload
								onSelect={ onSelectMedia }
								allowedTypes={ [ 'image' ] }
								value={ mapImageId }
								render={ ( { open } ) => (
									<div role="button" tabIndex={ 0 } onClick={ open } onKeyDown={ ( e ) => ( e.key === 'Enter' ? open() : null ) }>
										{ /* eslint-disable-next-line jsx-a11y/alt-text */ }
										<img src={ mapImageUrl } alt={ mapImageAlt } />
									</div>
								) }
							/>
						</MediaUploadCheck>
					) }
				</div>
			</div>
		</>
	);
}
