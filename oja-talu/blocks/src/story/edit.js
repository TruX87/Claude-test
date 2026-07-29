/**
 * Editor UI for oja-talu/story.
 *
 * Body copy uses InnerBlocks restricted to core/paragraph and core/list
 * rather than a legacy multiline RichText field — the modern, supported
 * WordPress pattern for a free-form text area inside a custom block.
 *
 * @package Oja_Talu
 */

import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InnerBlocks,
	MediaPlaceholder,
	MediaUpload,
	MediaUploadCheck,
	InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';

const ALLOWED_BLOCKS = [ 'core/paragraph', 'core/list' ];
const TEMPLATE = [ [ 'core/paragraph', { placeholder: __( 'Tell this part of the story…', 'oja-talu' ) } ] ];

export default function Edit( { attributes, setAttributes } ) {
	const { mediaUrl, mediaAlt, mediaId, imagePosition, heading } = attributes;
	const blockProps = useBlockProps( {
		className: `oja-story oja-story--${ imagePosition }`,
	} );

	const onSelectMedia = ( media ) => {
		setAttributes( { mediaId: media.id, mediaUrl: media.url, mediaAlt: media.alt || '' } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Layout', 'oja-talu' ) }>
					<ToggleControl
						label={ __( 'Image on the right', 'oja-talu' ) }
						checked={ imagePosition === 'right' }
						onChange={ ( checked ) =>
							setAttributes( { imagePosition: checked ? 'right' : 'left' } )
						}
						help={ __(
							'Visual order only — reading order in the markup stays image-then-text either way, for correct screen-reader order.',
							'oja-talu'
						) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="oja-story__media">
					{ ! mediaUrl ? (
						<MediaPlaceholder
							icon="format-image"
							labels={ { title: __( 'Story image', 'oja-talu' ) } }
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

				<div className="oja-story__content">
					<RichText
						tagName="h2"
						value={ heading }
						onChange={ ( value ) => setAttributes( { heading: value } ) }
						placeholder={ __( 'Section heading…', 'oja-talu' ) }
						allowedFormats={ [] }
					/>
					<div className="oja-story__body">
						<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } template={ TEMPLATE } templateLock={ false } />
					</div>
				</div>
			</div>
		</>
	);
}
