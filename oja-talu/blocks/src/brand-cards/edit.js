/**
 * Editor UI for oja-talu/brand-cards.
 *
 * templateLock="all" prevents an editor from adding a fourth card,
 * deleting one of the three, or reordering them — the brand hierarchy
 * (Oja Talu / Oja Aed / Rohebaar) is fixed, per Phase 4 §5.
 *
 * @package Oja_Talu
 */

import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

const ALLOWED_BLOCKS = [ 'oja-talu/brand-card' ];

const TEMPLATE = [
	[ 'oja-talu/brand-card', { variant: 'oja-talu' } ],
	[ 'oja-talu/brand-card', { variant: 'oja-aed' } ],
	[ 'oja-talu/brand-card', { variant: 'rohebaar' } ],
];

export default function Edit() {
	const blockProps = useBlockProps( { className: 'oja-brand-cards' } );

	return (
		<div { ...blockProps }>
			<InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } template={ TEMPLATE } templateLock="all" />
		</div>
	);
}
