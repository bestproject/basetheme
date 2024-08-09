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
import {InnerBlocks, InspectorControls, useBlockProps} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import clsx from "clsx";
import {
	Panel,
	PanelBody,
	SelectControl
} from "@wordpress/components";

import { select } from '@wordpress/data';


import {
	mobile as IconMobile,
	tablet as IconTablet,
	desktop as IconDesktop,
} from '@wordpress/icons'

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({attributes, setAttributes}) {

	const {
		xs_columns, md_columns, xl_columns,
		xs_order, md_order, xl_order, className
	} = attributes;

	let editorClasses = {};
	let publishedClasses = {};

	const deviceType = select( ( select ) => {
		return select( 'core/block-editor' ).getDeviceType() ?? 'Desktop';
	}, [] );

	['xs', 'md', 'xl'].map((breakpoint)=> {

		let key = breakpoint === 'xs' ? '-' : '-' + breakpoint + '-';

		// Reset width classes
		[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].map((width) => {
			editorClasses['col' + key + width] = false;
			publishedClasses['col' + key + width] = false;
		});

		// Reset order classes
		[1, 2, 3, 4, 5].map((order) => {
			editorClasses['order' + key + order] = false;
			publishedClasses['order' + key + order] = false;
		});

		const columns_key = `${breakpoint}_columns`;
		if( attributes[columns_key] ) {
			const columns_class = 'col' + key + attributes[columns_key];
			editorClasses[columns_class] = (attributes[columns_key] !== '');
		}

		const order_key = `${breakpoint}_order`;
		if( attributes[order_key] ) {
			const order_class = 'order' + key + attributes[order_key];
			editorClasses[order_class] = (attributes[order_key] !== '');
		}
	});

	let classes = className ? className.split(' ') : [];
	classes.map((item)=>{
		publishedClasses[item] = true;
	});

	// Update class attribute
	setAttributes( {
		className: clsx(publishedClasses),
	})

	const blockProps = useBlockProps({
		className: clsx(editorClasses),
	})

	const updateColumns = (breakpoint, value ) => {
		setAttributes( {
			[breakpoint+"_columns"]: value === undefined ? '' : value+"",
		} );
	};

	const updateOrder = (breakpoint, value ) => {
		setAttributes( {
			[breakpoint+"_order"]: value === undefined ? '' : value+"",
		} );
	};

	return (
		<div { ...blockProps }>
			<InspectorControls key="setting">
				<Panel>

					<PanelBody title={ __( 'Smartphone (≥0px)', 'basetheme' ) } icon={ IconMobile } initialOpen={ deviceType==='Mobile' }>

						<SelectControl
							label={ __( 'Width', 'basetheme' ) }
							value={ xs_columns }
							options={ [
								{ label: '1 / 12', value: '1' },
								{ label: '2 / 12', value: '2' },
								{ label: '3 / 12', value: '3' },
								{ label: '4 / 12', value: '4' },
								{ label: '5 / 12', value: '5' },
								{ label: '6 / 12', value: '6' },
								{ label: '7 / 12', value: '7' },
								{ label: '8 / 12', value: '8' },
								{ label: '9 / 12', value: '9' },
								{ label: '10 / 12', value: '10' },
								{ label: '11 / 12', value: '11' },
								{ label: '12 / 12', value: '12' },
							] }
							labelPosition="side"
							onChange={ ( value ) => updateColumns( 'xs', value ) }
							__nextHasNoMarginBottom
						/>

						<SelectControl
							label={ __( "Order", 'basetheme' ) }
							value={ xs_order }
							options={ [
								{ label: __( 'Automatic', 'basetheme' ), value: '' },
								{ label: '1', value: '1' },
								{ label: '2', value: '2' },
								{ label: '3', value: '3' },
								{ label: '4', value: '4' },
								{ label: '5', value: '5' }
							] }
							labelPosition="side"
							onChange={ ( value ) => updateOrder( 'xs', value ) }
							__nextHasNoMarginBottom
						/>

					</PanelBody>
					<PanelBody title={ __( 'Tablet (≥768px)', 'basetheme' ) } icon={ IconTablet } initialOpen={ deviceType==='Tablet' }>

						<SelectControl
							label={ __( "Width", 'basetheme' ) }
							value={ md_columns }
							options={ [
								{ label: __( 'Inherited', 'basetheme' ), value: '' },
								{ label: '1 / 12', value: '1' },
								{ label: '2 / 12', value: '2' },
								{ label: '3 / 12', value: '3' },
								{ label: '4 / 12', value: '4' },
								{ label: '5 / 12', value: '5' },
								{ label: '6 / 12', value: '6' },
								{ label: '7 / 12', value: '7' },
								{ label: '8 / 12', value: '8' },
								{ label: '9 / 12', value: '9' },
								{ label: '10 / 12', value: '10' },
								{ label: '11 / 12', value: '11' },
								{ label: '12 / 12', value: '12' },
							] }
							labelPosition="side"
							onChange={ ( value ) => updateColumns( 'md', value ) }
							__nextHasNoMarginBottom
						/>

						<SelectControl
							label={ __( "Order", 'basetheme' ) }
							value={ md_order }
							options={ [
								{ label: __( 'Automatic', 'basetheme' ), value: '' },
								{ label: '1', value: '1' },
								{ label: '2', value: '2' },
								{ label: '3', value: '3' },
								{ label: '4', value: '4' },
								{ label: '5', value: '5' }
							] }
							labelPosition="side"
							onChange={ ( value ) => updateOrder( 'md', value ) }
							__nextHasNoMarginBottom
						/>
					</PanelBody>
					<PanelBody title={ __( 'Desktop (≥1200px)', 'basetheme' ) } icon={ IconDesktop } initialOpen={ deviceType==='Desktop' }>

						<SelectControl
							label={ __( "Width", 'basetheme' ) }
							value={ xl_columns }
							options={ [
								{ label: __( 'Inherited', 'basetheme' ), value: '' },
								{ label: '1 / 12', value: '1' },
								{ label: '2 / 12', value: '2' },
								{ label: '3 / 12', value: '3' },
								{ label: '4 / 12', value: '4' },
								{ label: '5 / 12', value: '5' },
								{ label: '6 / 12', value: '6' },
								{ label: '7 / 12', value: '7' },
								{ label: '8 / 12', value: '8' },
								{ label: '9 / 12', value: '9' },
								{ label: '10 / 12', value: '10' },
								{ label: '11 / 12', value: '11' },
								{ label: '12 / 12', value: '12' },
							] }
							labelPosition="side"
							onChange={ ( value ) => updateColumns( 'xl', value ) }
							__nextHasNoMarginBottom
						/>

						<SelectControl
							label={ __( "Order", 'basetheme' ) }
							value={ xl_order }
							options={ [
								{ label: __('Automatic', 'basetheme'), value: '' },
								{ label: '1', value: '1' },
								{ label: '2', value: '2' },
								{ label: '3', value: '3' },
								{ label: '4', value: '4' },
								{ label: '5', value: '5' }
							] }
							labelPosition="side"
							onChange={ ( value ) => updateOrder( 'xl', value ) }
							__nextHasNoMarginBottom
						/>

					</PanelBody>
				</Panel>
			</InspectorControls>

			<InnerBlocks  defaultBlock={['core/paragraph', {placeholder: "Vestibulum euismod mi vitae magna ultrices imperdiet. Vivamus aliquam porttitor vehicula. Lorem ipsum dolor sit amet, consectetur adipiscing elit."}]} directInsert />
		</div>
	);
}
