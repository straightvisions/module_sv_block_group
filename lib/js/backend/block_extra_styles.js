wp.blocks.registerBlockStyle( 'core/group', {
	name: 'default',
	label: 'Default',
	isDefault: true,
} );
jQuery.each( js_sv100_sv_block_group_scripts_block, function( key, value ) {
	wp.blocks.registerBlockStyle( 'core/group', {
		name: key,
		label: value
	} );
})