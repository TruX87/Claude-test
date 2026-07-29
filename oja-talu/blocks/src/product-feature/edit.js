/**
 * Editor UI for oja-talu/product-feature.
 *
 * Product choice is a plain SelectControl over all published products
 * (fine at this shop's realistic catalogue size — a few dozen items).
 * If the catalogue grows large enough that this becomes unwieldy, swap
 * in a searchable autocomplete against the same postType:product entity
 * — the data source doesn't need to change, only the control.
 *
 * @package Oja_Talu
 */

import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Placeholder } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit( { attributes, setAttributes } ) {
	const { productId } = attributes;
	const blockProps = useBlockProps( { className: 'oja-product-feature' } );

	const products = useSelect(
		( select ) =>
			select( coreStore ).getEntityRecords( 'postType', 'product', {
				per_page: 100,
				orderby: 'title',
				order: 'asc',
				status: 'publish',
			} ),
		[]
	);

	const options = [
		{ label: __( '— Select a product —', 'oja-talu' ), value: 0 },
		...( products || [] ).map( ( product ) => ( {
			label: product.title?.rendered || `#${ product.id }`,
			value: product.id,
		} ) ),
	];

	return (
		<div { ...blockProps }>
			<InspectorControls>
				<PanelBody title={ __( 'Product', 'oja-talu' ) }>
					<SelectControl
						label={ __( 'Featured product', 'oja-talu' ) }
						value={ productId }
						options={ options }
						onChange={ ( value ) => setAttributes( { productId: Number( value ) } ) }
					/>
				</PanelBody>
			</InspectorControls>

			{ productId ? (
				<ServerSideRender block="oja-talu/product-feature" attributes={ attributes } />
			) : (
				<Placeholder
					icon="cart"
					label={ __( 'Product Feature', 'oja-talu' ) }
					instructions={ __( 'Choose a product in the block settings.', 'oja-talu' ) }
				/>
			) }
		</div>
	);
}
