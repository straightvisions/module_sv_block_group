<?php
	namespace sv100;

	class sv_block_group extends init {
		public function init() {
			$this->set_module_title( __( 'Block: Group', 'sv100' ) )
				->set_module_desc( __( 'Settings for Gutenberg Block', 'sv100' ) )
				->set_css_cache_active()
				->set_section_title( $this->get_module_title() )
				->set_section_desc( $this->get_module_desc() )
				->set_section_template_path()
				->set_section_order(5000)
				->set_section_icon('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22 6v16h-16v-16h16zm2-2h-20v20h20v-20zm-24-4v20h2v-18h18v-2h-20z"/></svg>')
				->set_block_handle('wp-block-group')
				->set_block_name('core/group')
				->get_root()
				->add_section( $this );
		}

		protected function load_settings(): sv_block_group {
			$this->get_setting( 'margin' )
				->set_title( __( 'Margin', 'sv100' ) )
				->set_is_responsive(true)
				->set_default_value(array(
					'top'		=> '0',
					'right'		=> 'auto',
					'bottom'	=> '0',
					'left'		=> 'auto'
				))
				->load_type( 'margin' );

			$this->get_setting( 'padding' )
				->set_title( __( 'Padding', 'sv100' ) )
				->set_is_responsive(true)
				->load_type( 'margin' );

			$this->get_setting( 'bg_padding' )
				->set_title( __( 'Padding when Group has Background Color', 'sv100' ) )
				->set_is_responsive(true)
				->set_default_value(array(
					'top'		=> '20px',
					'right'		=> '20px',
					'bottom'	=> '20px',
					'left'		=> '20px'
				))
				->load_type( 'margin' );

			$this->get_setting( 'border' )
				->set_title( __( 'Border', 'sv100' ) )
				->set_is_responsive(true)
				->load_type( 'border' );

			return $this;
		}
	}