/**
 * Editor preview for oja-talu/journal-entry.
 *
 * Reads the post already available in block context (supplied by the
 * surrounding Query Loop) via core-data — no extra REST request per card,
 * unlike a ServerSideRender-based preview would need.
 *
 * @package Oja_Talu
 */

import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { dateI18n, getSettings as getDateSettings } from '@wordpress/date';

export default function Edit( { context } ) {
	const { postId, postType } = context;
	const blockProps = useBlockProps( { className: 'oja-journal-entry' } );

	const record = useSelect(
		( select ) =>
			postId && postType ? select( coreStore ).getEntityRecord( 'postType', postType, postId ) : null,
		[ postId, postType ]
	);

	if ( ! postId ) {
		return (
			<div { ...blockProps }>
				<p className="oja-journal-entry__placeholder">
					{ __( 'This block renders automatically inside the Journal archive query loop — it has no settings of its own.', 'oja-talu' ) }
				</p>
			</div>
		);
	}

	if ( ! record ) {
		return <div { ...blockProps }>{ __( 'Loading…', 'oja-talu' ) }</div>;
	}

	const dateSettings = getDateSettings();
	const formattedDate = record.date ? dateI18n( dateSettings.formats.date, record.date ) : '';
	const excerpt = record.excerpt?.rendered
		? record.excerpt.rendered.replace( /<[^>]+>/g, '' )
		: '';

	return (
		<div { ...blockProps }>
			<div className="oja-journal-entry__link-wrap">
				{ record.oja_featured_media_url && (
					<div className="oja-journal-entry__media">
						<img src={ record.oja_featured_media_url } alt="" />
					</div>
				) }
				<time className="oja-journal-entry__date">{ formattedDate }</time>
				<h3 className="oja-journal-entry__title">{ record.title?.rendered }</h3>
				<p className="oja-journal-entry__excerpt">{ excerpt }</p>
			</div>
		</div>
	);
}
