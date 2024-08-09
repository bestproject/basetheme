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

const IconColumn = (
	<svg xmlns="http://www.w3.org/2000/svg" width="800" height="800" viewBox="0 0 24 24" fill="#292d32">
		<path
			d="M4.23 1.25c-.889 0-1.666.164-2.227.691S1.25 3.243 1.25 4.1V19.9c0 .857.193 1.631.754 2.158s1.337.691 2.227.691H8.27c.889 0 1.666-.164 2.227-.691s.754-1.302.754-2.158V4.1c0-.857-.193-1.631-.754-2.158S9.159 1.25 8.27 1.25zm0 1.5H8.27c.701 0 1.04.135 1.197.283s.283.423.283 1.066V19.9c0 .643-.126.919-.283 1.066s-.497.283-1.197.283H4.23c-.701 0-1.04-.135-1.197-.283s-.283-.423-.283-1.066V4.1c0-.643.126-.919.283-1.066S3.53 2.75 4.23 2.75z"
			opacity=".4"/>
		<path
			d="M15.73 1.25c-.889 0-1.666.164-2.227.691S12.75 3.243 12.75 4.1V19.9c0 .857.193 1.631.754 2.158s1.337.691 2.227.691h4.039c.889 0 1.666-.164 2.227-.691s.754-1.302.754-2.158V4.1c0-.857-.193-1.631-.754-2.158s-1.337-.691-2.227-.691zm0 1.5h4.039c.701 0 1.04.135 1.197.283s.283.423.283 1.066V19.9c0 .643-.126.919-.283 1.066s-.497.283-1.197.283H15.73c-.701 0-1.04-.135-1.197-.283s-.283-.423-.283-1.066V4.1c0-.643.126-.919.283-1.066s.497-.283 1.197-.283z"/>
	</svg>
);

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType(metadata.name, {
	icon: IconColumn,
	edit: Edit,
	save: Save,
});
