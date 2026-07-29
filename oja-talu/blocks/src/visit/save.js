/**
 * Front-end markup for oja-talu/visit.
 *
 * The map is a static image linking out to a maps provider — not an
 * embedded iframe — so the page carries no third-party script weight
 * and needs no cookie-consent banner just to show a location.
 *
 * @package Oja_Talu
 */

import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';

/**
 * The dt/dd labels and CTA text below are translated via __() rather
 * than stored as editable attributes: they're fixed UI chrome (like a
 * core block's default button text), not editorial content, so the
 * standard WordPress pattern is a JS translation file per locale
 * (wp_set_script_translations(), registered in inc/blocks.php) rather
 * than one more attribute per label.
 */
export default function save( { attributes } ) {
	const { address, hours, phone, arrivalNote, mapImageUrl, mapImageAlt, directionsUrl } = attributes;
	const blockProps = useBlockProps.save( { className: 'oja-visit' } );

	return (
		<div { ...blockProps }>
			<div className="oja-visit__info">
				<dl className="oja-visit__list">
					{ address && (
						<>
							<dt>{ __( 'Aadress', 'oja-talu' ) }</dt>
							<dd>{ address }</dd>
						</>
					) }
					{ hours && (
						<>
							<dt>{ __( 'Avatud', 'oja-talu' ) }</dt>
							<dd>{ hours }</dd>
						</>
					) }
					{ phone && (
						<>
							<dt>{ __( 'Telefon', 'oja-talu' ) }</dt>
							<dd>
								<a href={ `tel:${ phone.replace( /\s+/g, '' ) }` }>{ phone }</a>
							</dd>
						</>
					) }
				</dl>
				<RichText.Content tagName="p" className="oja-visit__note" value={ arrivalNote } />
				{ directionsUrl && (
					<a className="oja-visit__cta" href={ directionsUrl }>
						{ __( 'Vaata suunda', 'oja-talu' ) }
					</a>
				) }
			</div>
			{ mapImageUrl && (
				<a className="oja-visit__map" href={ directionsUrl || undefined }>
					<img src={ mapImageUrl } alt={ mapImageAlt } loading="lazy" />
				</a>
			) }
		</div>
	);
}
