/**
 * Icon block edit
 *
 * @since 4.0.0
 */

import { useBlockProps } from '@wordpress/block-editor';
import InlineIconPicker from '../../components/inline-icon-picker';

export default function Edit( { attributes, setAttributes } ) {
	const { ucfIconPrefix, ucfIconName } = attributes;

	return (
		<div { ...useBlockProps() }>
			<InlineIconPicker
				name={ ucfIconName }
				prefix={ ucfIconPrefix }
				onChange={ ( { name, prefix } ) =>
					setAttributes( {
						ucfIconPrefix: prefix,
						ucfIconName: name,
					} )
				}
			/>
		</div>
	);
}
