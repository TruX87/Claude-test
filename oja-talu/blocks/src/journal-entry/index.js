/**
 * Block registration for oja-talu/journal-entry.
 *
 * Dynamic block: `render` in block.json points at render.php, so no
 * save() output needs to be serialized into post content — save()
 * returns null, which is the correct/standard pattern for a fully
 * server-rendered block.
 *
 * @package Oja_Talu
 */

import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import Edit from './edit';
import './style.scss';

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
