/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import Save from './save';
import metadata from './block.json';

const IconRow = (
	<svg xmlns="http://www.w3.org/2000/svg" width="800" height="800" viewBox="0 0 24 24" fill="#292d32">
		<path
			d="M4.1 12.75c-.857 0-1.631.193-2.158.754s-.691 1.337-.691 2.227v4.039c0 .889.164 1.666.691 2.227s1.302.754 2.158.754H19.9c.857 0 1.631-.193 2.158-.754s.691-1.337.691-2.227V15.73c0-.889-.164-1.666-.691-2.227s-1.302-.754-2.158-.754zm0 1.5H19.9c.643 0 .919.126 1.066.283s.283.497.283 1.197v4.039c0 .701-.135 1.04-.283 1.197s-.423.283-1.066.283H4.1c-.643 0-.919-.126-1.066-.283s-.283-.497-.283-1.197V15.73c0-.701.135-1.04.283-1.197s.423-.283 1.066-.283z"/>
		<path
			d="M4.1 1.25c-.857 0-1.631.193-2.158.754S1.25 3.341 1.25 4.23V8.27c0 .889.164 1.666.691 2.227s1.302.754 2.158.754H19.9c.857 0 1.631-.193 2.158-.754s.691-1.337.691-2.227V4.23c0-.889-.164-1.666-.691-2.227S20.757 1.25 19.9 1.25zm0 1.5H19.9c.643 0 .919.126 1.066.283s.283.497.283 1.197V8.27c0 .701-.135 1.04-.283 1.197s-.423.283-1.066.283H4.1c-.643 0-.919-.126-1.066-.283S2.75 8.97 2.75 8.27V4.23c0-.701.135-1.04.283-1.197S3.456 2.75 4.1 2.75z"
			opacity=".4"/>
	</svg>
);

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType(metadata.name, {
	icon: IconRow,
	edit: Edit,
	save: Save,
});
