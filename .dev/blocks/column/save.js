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

	['xs', 'md', 'xl'].map((breakpoint)=> {

		let key = breakpoint === 'xs' ? '-' : '-' + breakpoint + '-';

		// Reset width classes
		[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].map((width) => {
			publishedClasses['col' + key + width] = false;
		});

		// Reset order classes
		[1, 2, 3, 4, 5].map((order) => {
			publishedClasses['order' + key + order] = false;
		});

		const columns_key = `${breakpoint}_columns`;
		if( attributes[columns_key] ) {
			const columns_class = 'col' + key + attributes[columns_key];
			publishedClasses[columns_class] = (attributes[columns_key] !== '');
		}

		const order_key = `${breakpoint}_order`;
		if( attributes[order_key] ) {
			const order_class = 'order' + key + attributes[order_key];
			publishedClasses[order_class] = (attributes[order_key] !== '');
		}
	});

	const blockProps = useBlockProps.save({
		className: clsx(publishedClasses),
	});

	const innerBlocksProps = useInnerBlocksProps.save( blockProps );

	return <div { ...innerBlocksProps } />;
}
