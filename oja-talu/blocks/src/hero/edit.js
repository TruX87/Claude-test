/**
 * Editor UI for oja-talu/hero.
 *
 * @package Oja_Talu
 */

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	MediaPlaceholder,
	MediaUploadCheck,
	MediaUpload,
	InspectorControls,
	BlockControls,
	MediaReplaceFlow,
} from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { mediaId, mediaUrl, mediaAlt, title, lead, ctaText, ctaUrl } = attributes;
	const blockProps = useBlockProps( { className: 'oja-hero' } );

	const onSelectMedia = ( media ) => {
		setAttributes( {
			mediaId: media.id,
			mediaUrl: media.url,
			mediaAlt: media.alt || '',
		} );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Call to action', 'oja-talu' ) }>
					<TextControl
						label={ __( 'Button link', 'oja-talu' ) }
						value={ ctaUrl }
						onChange={ ( value ) => setAttributes( { ctaUrl: value } ) }
						help={ __( 'Where the primary button goes.', 'oja-talu' ) }
					/>
				</PanelBody>
			</InspectorControls>

			{ mediaUrl && (
				<BlockControls>
					<MediaReplaceFlow
						mediaId={ mediaId }
						mediaURL={ mediaUrl }
						allowedTypes={ [ 'image' ] }
						accept="image/*"
						onSelect={ onSelectMedia }
					/>
				</BlockControls>
			) }

			<div { ...blockProps }>
				{ ! mediaUrl ? (
					<MediaPlaceholder
						icon="format-image"
						labels={ { title: __( 'Hero image', 'oja-talu' ) } }
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
								<div
									className="oja-hero__media"
									role="button"
									tabIndex={ 0 }
									onClick={ open }
									onKeyDown={ ( e ) => ( e.key === 'Enter' ? open() : null ) }
								>
									{ /* eslint-disable-next-line jsx-a11y/alt-text */ }
									<img src={ mediaUrl } alt={ mediaAlt } />
								</div>
							) }
						/>
					</MediaUploadCheck>
				) }

				<div className="oja-hero__content">
					<RichText
						tagName="h1"
						className="oja-hero__title"
						value={ title }
						onChange={ ( value ) => setAttributes( { title: value } ) }
						placeholder={ __( 'Hero title…', 'oja-talu' ) }
						allowedFormats={ [] }
					/>
					<RichText
						tagName="p"
						className="oja-hero__lead"
						value={ lead }
						onChange={ ( value ) => setAttributes( { lead: value } ) }
						placeholder={ __( 'One short line…', 'oja-talu' ) }
						allowedFormats={ [ 'core/italic' ] }
					/>
					<RichText
						tagName="span"
						className="oja-hero__cta"
						value={ ctaText }
						onChange={ ( value ) => setAttributes( { ctaText: value } ) }
						placeholder={ __( 'Button text…', 'oja-talu' ) }
						allowedFormats={ [] }
					/>
				</div>
			</div>
		</>
	);
}
