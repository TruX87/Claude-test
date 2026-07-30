/**
 * Explicit, deterministic build config for the Oja Talu theme's custom
 * blocks.
 *
 * This theme originally invoked `wp-scripts build blocks/src/hero ...`
 * (see git history), relying on @wordpress/scripts' automatic
 * block.json discovery to produce a `blocks/build/<name>/` folder per
 * block — mirroring block.json, index.js, and the compiled stylesheet
 * alongside each other, which is what inc/blocks.php's registration
 * loop expects. In practice that produced a flat/combined output
 * instead, because that auto-discovery glob expects block.json directly
 * under a `blocks/` folder, not nested one level deeper under
 * `blocks/src/<name>/` the way this theme is laid out — a version- and
 * convention-sensitive behaviour that isn't worth depending on.
 *
 * This config owns the entry list, output paths, and the block.json/
 * render.php copy step explicitly, so the result doesn't depend on
 * guessing how a given @wordpress/scripts version parses CLI arguments.
 *
 * @package Oja_Talu
 */

const path = require( 'path' );
const fs = require( 'fs' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );

const BLOCKS = [
	'hero',
	'story',
	'brand-card',
	'brand-cards',
	'season',
	'journal-entry',
	'product-feature',
	'visit',
];

const SRC_DIR = path.resolve( __dirname, 'blocks/src' );
const BUILD_DIR = path.resolve( __dirname, 'blocks/build' );

// One JS entry per block, named "<block>/index" so webpack's `[name]`
// output-filename token naturally nests each block's compiled file
// under its own build/<block>/ folder — matching block.json's
// "editorScript": "file:./index.js".
const entry = {};
BLOCKS.forEach( ( name ) => {
	entry[ `${ name }/index` ] = path.join( SRC_DIR, name, 'index.js' );
} );

// Copy each block's block.json (required) and render.php (only present
// on the two dynamic blocks) straight across — these are static files
// webpack has no reason to transform.
const copyPatterns = BLOCKS.flatMap( ( name ) => {
	const patterns = [
		{
			from: path.join( SRC_DIR, name, 'block.json' ),
			to: path.join( BUILD_DIR, name, 'block.json' ),
		},
	];
	const renderPath = path.join( SRC_DIR, name, 'render.php' );
	if ( fs.existsSync( renderPath ) ) {
		patterns.push( { from: renderPath, to: path.join( BUILD_DIR, name, 'render.php' ) } );
	}
	return patterns;
} );

module.exports = {
	mode: process.env.NODE_ENV === 'production' ? 'production' : 'development',
	devtool: process.env.NODE_ENV === 'production' ? false : 'source-map',
	entry,
	output: {
		path: BUILD_DIR,
		filename: '[name].js',
		clean: true,
	},
	module: {
		rules: [
			{
				test: /\.jsx?$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: [ require.resolve( '@wordpress/babel-preset-default' ) ],
					},
				},
			},
			{
				test: /\.scss$/,
				use: [ MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader' ],
			},
		],
	},
	plugins: [
		// block.json's "style" field points at "./style-index.css" —
		// the filename function below strips the "/index" suffix off
		// the JS chunk name ("hero/index" → "hero") before appending
		// "style-index.css", so the CSS lands at build/hero/style-index.css,
		// matching every block.json exactly.
		new MiniCssExtractPlugin( {
			filename: ( pathData ) => `${ pathData.chunk.name.replace( /\/index$/, '' ) }/style-index.css`,
		} ),
		new CopyWebpackPlugin( { patterns: copyPatterns } ),
	],
	externals: {
		'@wordpress/blocks': 'wp.blocks',
		'@wordpress/block-editor': 'wp.blockEditor',
		'@wordpress/components': 'wp.components',
		'@wordpress/element': 'wp.element',
		'@wordpress/i18n': 'wp.i18n',
		'@wordpress/data': 'wp.data',
		'@wordpress/core-data': 'wp.coreData',
		'@wordpress/compose': 'wp.compose',
		'@wordpress/date': 'wp.date',
		'@wordpress/server-side-render': 'wp.serverSideRender',
		react: 'React',
		'react-dom': 'ReactDOM',
	},
};
