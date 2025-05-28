/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InnerBlocks, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import clsx from "clsx";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function Save({attributes}) {

	let publishedClasses = {};

	['xs', 'md', 'xl'].map((breakpoint)=>{

		let key = breakpoint==='xs' ? '-' : '-'+breakpoint+'-';

		// Reset align classes
		['start', 'center', 'end'].map((direction)=>{
			publishedClasses['align-items' + key + direction] = false;
		});

		// Reset justify classes
		['start', 'center', 'between', 'around', 'end'].map((direction)=>{
			publishedClasses['justify-content' + key + direction] = false;
		});

		// Reset gutter classes
		['0','1','2','3','4','5'].map((space)=>{
			publishedClasses['g-' + key + space] = false;
		});

		const align_key = `${breakpoint}_alignItems`;
		if( attributes[align_key] ) {
			const align_class = 'align-items' + key + attributes[align_key];
			publishedClasses[align_class] = (attributes[align_key] !== '');
		}

		const justify_key = `${breakpoint}_justifyContent`;
		if( attributes[justify_key] ) {
			const justify_class = 'justify-content' + key + attributes[justify_key];
			publishedClasses[justify_class] = (attributes[justify_key] !== '');
		}

		const gutter_key = `${breakpoint}_gutter`;
		if( attributes[gutter_key] ) {
			const g_class = 'g' + key + attributes[gutter_key];
			publishedClasses[g_class] = (attributes[gutter_key] !== '');
		}
	});

	const blockProps = useBlockProps.save({
		className: clsx('row', publishedClasses),
	});

	const innerBlocksProps = useInnerBlocksProps.save( blockProps );

	return <div { ...innerBlocksProps } />;
}
