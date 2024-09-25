/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

import clsx from 'clsx';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	InnerBlocks,
	useInnerBlocksProps,
	InspectorControls,
} from '@wordpress/block-editor';

import {
	Panel,
	PanelBody,
	__experimentalToggleGroupControl as ToggleGroupControl,
	__experimentalToggleGroupControlOption as ToggleGroupControlOption,
	__experimentalToggleGroupControlOptionIcon as ToggleGroupControlOptionIcon,
} from '@wordpress/components';

import { select } from '@wordpress/data';

import {
	justifyLeft,
	justifyCenter,
	justifySpaceBetween,
	justifyRight,
	sidesAll,
	arrowDown,
	pageBreak,
	arrowUp,
	code,
	mobile as IconMobile,
	tablet as IconTablet,
	desktop as IconDesktop,
} from '@wordpress/icons'

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit( {attributes, setAttributes}) {

	const {
		xs_alignItems, xs_justifyContent,
		md_alignItems, md_justifyContent,
		xl_alignItems, xl_justifyContent,
		xs_gutter, md_gutter, xl_gutter,
		className
	} = attributes;

	let editorClasses = {};
	let publishedClasses = {};

	const deviceType = select( ( select ) => {
		return select( 'core/block-editor' ).getDeviceType() ?? 'Desktop';
	}, [] );

	['xs', 'md', 'xl'].map((breakpoint)=>{

		let key = breakpoint==='xs' ? '-' : '-'+breakpoint+'-';

		// Reset align classes
		['start', 'center', 'end'].map((direction)=>{
			editorClasses['align-items' + key + direction] = false;
			publishedClasses['align-items' + key + direction] = false;
		});

		// Reset justify classes
		['start', 'center', 'between', 'around', 'end'].map((direction)=>{
			editorClasses['justify-content' + key + direction] = false;
			publishedClasses['justify-content' + key + direction] = false;
		});

		// Reset justify classes
		['0','1','2','3','4','5'].map((space)=>{
			editorClasses['g' + key + space] = false;
			publishedClasses['g' + key + space] = false;
		});

		const align_key = `${breakpoint}_alignItems`;
		if( attributes[align_key] ) {
			const align_class = 'align-items' + key + attributes[align_key];
			editorClasses[align_class] = (attributes[align_key] !== '');
		}

		const justify_key = `${breakpoint}_justifyContent`;
		if( attributes[justify_key] ) {
			const justify_class = 'justify-content' + key + attributes[justify_key];
			editorClasses[justify_class] = (attributes[justify_key] !== '');
		}

		const gutter_key = `${breakpoint}_gutter`;
		if( attributes[gutter_key] ) {
			const g_class = 'g' + key + attributes[gutter_key];
			editorClasses[g_class] = (attributes[gutter_key] !== '');
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
		className: clsx('row', editorClasses),
	})

	const updateAlignItems = (breakpoint, value ) => {
		setAttributes( {
			[breakpoint+"_alignItems"]: value === undefined ? '' : value,
		} );
	};
	const updateJustifyContent = (breakpoint, value ) => {
		setAttributes( {
			[breakpoint+"_justifyContent"]: value === undefined ? '' : value,
		} );
	};

	const updateGutter = (breakpoint, value ) => {
		setAttributes( {
			[breakpoint+"_gutter"]: value === undefined ? '' : value+"",
		} );
	};

	const TEMPLATE = [ [ 'bootstrap/column' ] ];
	const DEFAULT_BLOCK = { name: 'bootstrap/column', attributes: {  } };
	const ALLOWED_BLOCKS = ['bootstrap/column'];

	const { children, ...innerBlocksProps } = useInnerBlocksProps( blockProps, {
		allowedBlocks: ALLOWED_BLOCKS,
		template: TEMPLATE,
		defaultBlock: DEFAULT_BLOCK,
		orientation: "horizontal",
		directInsert: true,
		templateInsertUpdatesSelection: true,
	} );


	return (
		<div { ...blockProps }>
			<InspectorControls key="setting">
				<Panel>

					<PanelBody title={ __( 'Smartphone (≥0px)', 'basetheme' ) } icon={ IconMobile } initialOpen={ deviceType==='Mobile' }>

						<ToggleGroupControl label={ __("Gutter", 'basetheme') } value={ (xs_gutter) } isBlock isDeselectable onChange={ (value)=>updateGutter('xs', value)  }>
							<ToggleGroupControlOption value="0" label="0" />
							<ToggleGroupControlOption value="1" label="1" />
							<ToggleGroupControlOption value="2" label="2" />
							<ToggleGroupControlOption value="3" label="3" />
							<ToggleGroupControlOption value="4" label="4" />
							<ToggleGroupControlOption value="5" label="5" />
						</ToggleGroupControl>

						<ToggleGroupControl label={ __("Vertical alignment", 'basetheme') } value={ (xs_alignItems) } isBlock isDeselectable onChange={ (value)=>updateAlignItems('xs', value)  }>
							<ToggleGroupControlOptionIcon
								value="start"
								label={ __("Start", 'basetheme') }
								icon = { arrowDown }
							/>
							<ToggleGroupControlOptionIcon
								value="center"
								label={ __("Center", 'basetheme') }
								icon = { pageBreak }
							/>
							<ToggleGroupControlOptionIcon
								value="end"
								label={ __("End", 'basetheme') }
								icon = { arrowUp }
							/>
						</ToggleGroupControl>

						<ToggleGroupControl label={ __("Horizontal alignment", 'basetheme') } value={ (xs_justifyContent) } isBlock isDeselectable onChange={ (value)=>updateJustifyContent('xs', value)  }>
							<ToggleGroupControlOptionIcon
								value="start"
								label={ __("Start", 'basetheme') }
								icon = { justifyLeft }
							/>
							<ToggleGroupControlOptionIcon
								value="center"
								label={ __("Center", 'basetheme') }
								icon = { justifyCenter }
							/>
							<ToggleGroupControlOptionIcon
								value="between"
								label={ __("Between", 'basetheme') }
								icon = { justifySpaceBetween }
							/>
							<ToggleGroupControlOptionIcon
								value="around"
								label={ __("Around", 'basetheme') }
								icon = { sidesAll }
							/>
							<ToggleGroupControlOptionIcon
								value="end"
								label={ __("End", 'basetheme') }
								icon = { justifyRight }
							/>
						</ToggleGroupControl>
					</PanelBody>
					<PanelBody title={ __( 'Tablet (≥768px)', 'basetheme' ) } icon={ IconTablet } initialOpen={ deviceType==='Tablet' }>

						<ToggleGroupControl label={ __("Gutter", 'basetheme') } value={ (md_gutter) } isBlock isDeselectable onChange={ (value)=>updateGutter('md', value)  }>
							<ToggleGroupControlOption value="0" label="0" />
							<ToggleGroupControlOption value="1" label="1" />
							<ToggleGroupControlOption value="2" label="2" />
							<ToggleGroupControlOption value="3" label="3" />
							<ToggleGroupControlOption value="4" label="4" />
							<ToggleGroupControlOption value="5" label="5" />
						</ToggleGroupControl>

						<ToggleGroupControl label={ __("Vertical alignment", 'basetheme') } value={ (md_alignItems) } isBlock isDeselectable onChange={ (value)=>updateAlignItems('md', value)  }>
							<ToggleGroupControlOptionIcon
								value="start"
								label={ __("Start", 'basetheme') }
								icon = { arrowDown }
							/>
							<ToggleGroupControlOptionIcon
								value="center"
								label={ __("Center", 'basetheme') }
								icon = { pageBreak }
							/>
							<ToggleGroupControlOptionIcon
								value="end"
								label={ __("End", 'basetheme') }
								icon = { arrowUp }
							/>
						</ToggleGroupControl>

						<ToggleGroupControl label={ __("Horizontal alignment", 'basetheme') } value={ (md_justifyContent) } isBlock isDeselectable onChange={ (value)=>updateJustifyContent('md', value)  }>
							<ToggleGroupControlOptionIcon
								value="start"
								label={ __("Start", 'basetheme') }
								icon = { justifyLeft }
							/>
							<ToggleGroupControlOptionIcon
								value="center"
								label={ __("Center", 'basetheme') }
								icon = { justifyCenter }
							/>
							<ToggleGroupControlOptionIcon
								value="between"
								label={ __("Between", 'basetheme') }
								icon = { justifySpaceBetween }
							/>
							<ToggleGroupControlOptionIcon
								value="around"
								label={ __("Around", 'basetheme') }
								icon = { sidesAll }
							/>
							<ToggleGroupControlOptionIcon
								value="end"
								label={ __("End", 'basetheme') }
								icon = { justifyRight }
							/>
						</ToggleGroupControl>
					</PanelBody>
					<PanelBody title={ __( 'Desktop (≥1200px)', 'basetheme' ) } icon={ IconDesktop } initialOpen={ deviceType==='Desktop' }>

						<ToggleGroupControl label={ __("Gutter", 'basetheme') } value={ (xl_gutter) } isBlock isDeselectable onChange={ (value)=>updateGutter('xl', value)  }>
							<ToggleGroupControlOption value="0" label="0" />
							<ToggleGroupControlOption value="1" label="1" />
							<ToggleGroupControlOption value="2" label="2" />
							<ToggleGroupControlOption value="3" label="3" />
							<ToggleGroupControlOption value="4" label="4" />
							<ToggleGroupControlOption value="5" label="5" />
						</ToggleGroupControl>

						<ToggleGroupControl label={ __("Vertical alignment", 'basetheme') } value={ (xl_alignItems) } isBlock isDeselectable onChange={ (value)=>updateAlignItems('xl', value)  }>
							<ToggleGroupControlOptionIcon
								value="start"
								label={ __("Start", 'basetheme') }
								icon = { arrowDown }
							/>
							<ToggleGroupControlOptionIcon
								value="center"
								label={ __("Center", 'basetheme') }
								icon = { pageBreak }
							/>
							<ToggleGroupControlOptionIcon
								value="end"
								label={ __("End", 'basetheme') }
								icon = { arrowUp }
							/>
						</ToggleGroupControl>

						<ToggleGroupControl label={ __("Horizontal alignment", 'basetheme') } value={ (xl_justifyContent) } isBlock isDeselectable onChange={ (value)=>updateJustifyContent('xl', value)  }>
							<ToggleGroupControlOptionIcon
								value="start"
								label={ __("Start", 'basetheme') }
								icon = { justifyLeft }
							/>
							<ToggleGroupControlOptionIcon
								value="center"
								label={ __("Center", 'basetheme') }
								icon = { justifyCenter }
							/>
							<ToggleGroupControlOptionIcon
								value="between"
								label={ __("Between", 'basetheme') }
								icon = { justifySpaceBetween }
							/>
							<ToggleGroupControlOptionIcon
								value="around"
								label={ __("Around", 'basetheme') }
								icon = { sidesAll }
							/>
							<ToggleGroupControlOptionIcon
								value="end"
								label={ __("End", 'basetheme') }
								icon = { justifyRight }
							/>
						</ToggleGroupControl>
					</PanelBody>
				</Panel>
			</InspectorControls>

			{ children }
		</div>
	);
}
