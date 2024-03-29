wp.blocks.registerBlockStyle( 'core/group', {
	name: 'default',
	label: 'Default',
	isDefault: true,
} );

wp.blocks.registerBlockStyle( 'core/group', {
	name: 'no-padding',
	label: 'No Padding',
} );

wp.blocks.registerBlockStyle( 'core/group', {
	name: 'no-padding-vertical',
	label: 'No Padding Vertical'
} );

if(typeof js_sv100_sv_block_group_scripts_block_extra_styles  !== 'undefined') {
	jQuery.each(js_sv100_sv_block_group_scripts_block_extra_styles , function (key, value) {
		wp.blocks.registerBlockStyle('core/group', {
			name: key,
			label: value
		});
	})
}