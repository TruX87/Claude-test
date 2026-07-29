/**
 * SEO description panel.
 *
 * `register_post_meta()` in inc/seo.php exposes `_oja_seo_description`
 * over the REST API, but that alone gives editors no visible field to
 * fill it in — the generic "Custom Fields" box is off by default per
 * user and easy to miss. This registers a proper panel in the document
 * sidebar instead, the same pattern Yoast/RankMath use, without needing
 * either plugin.
 *
 * Plain global-script JS (wp.*), not a JSX/build-step file — this is a
 * single small panel, not one of the theme's Gutenberg blocks, so it
 * doesn't need @wordpress/scripts (Phase 4 §10, "no separate bundler
 * for anything this small").
 *
 * @package Oja_Talu
 */

( function ( wp ) {
	var registerPlugin = wp.plugins.registerPlugin;
	var PluginDocumentSettingPanel = wp.editPost.PluginDocumentSettingPanel;
	var TextareaControl = wp.components.TextareaControl;
	var withSelect = wp.data.withSelect;
	var withDispatch = wp.data.withDispatch;
	var compose = wp.compose.compose;
	var createElement = wp.element.createElement;
	var __ = wp.i18n.__;

	var META_KEY = '_oja_seo_description';

	var SeoDescriptionControl = compose(
		withSelect( function ( select ) {
			var meta = select( 'core/editor' ).getEditedPostAttribute( 'meta' ) || {};
			return { description: meta[ META_KEY ] || '' };
		} ),
		withDispatch( function ( dispatch ) {
			return {
				setDescription: function ( value ) {
					var metaUpdate = {};
					metaUpdate[ META_KEY ] = value;
					dispatch( 'core/editor' ).editPost( { meta: metaUpdate } );
				},
			};
		} )
	)( function ( props ) {
		return createElement( TextareaControl, {
			label: __( 'Meta description', 'oja-talu' ),
			help: __(
				'Shown in search results and social shares. Falls back to the excerpt if left blank. Aim for roughly 150–160 characters.',
				'oja-talu'
			),
			value: props.description,
			onChange: props.setDescription,
			rows: 3,
		} );
	} );

	registerPlugin( 'oja-talu-seo-panel', {
		render: function () {
			return createElement(
				PluginDocumentSettingPanel,
				{ name: 'oja-talu-seo', title: __( 'SEO', 'oja-talu' ), className: 'oja-seo-panel' },
				createElement( SeoDescriptionControl, null )
			);
		},
	} );
} )( window.wp );
