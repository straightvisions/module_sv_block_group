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

			$this->get_setting( 'custom_css' )
				->set_title( __( 'Custom CSS', 'sv100' ) )
				->set_is_responsive(true)
				->load_type( 'textarea' );

			$this->get_setting( 'extra_styles' )
				->set_title( __( 'Extra Styles', 'sv100' ) )
				->load_type( 'group' );

			$this->get_setting('extra_styles')
				->run_type()
				->add_child()
				->set_ID( 'entry_label' )
				->set_title( __( 'Style Label', 'sv100' ) )
				->set_description( __( 'A label to differentiate your Styles.', 'sv100' ) )
				->load_type( 'text' )
				->set_placeholder( __( 'Label', 'sv100' ) );

			$this->get_setting('extra_styles')
				->run_type()
				->add_child()
				->set_ID( 'slug' )
				->set_title( __( 'Slug', 'sv100' ) )
				->set_description( __( 'This slug is used for the helper classes.', 'sv100' ) )
				->load_type( 'text' );

			foreach($this->get_settings() as $setting) {
				if($setting->get_ID() != 'extra_styles') {
					$this->get_setting('extra_styles')
						->run_type()
						->add_child($setting);
				}
			}

			return $this;
		}

		protected function register_scripts(): sv_block_group {
			parent::register_scripts();

			// Register Default Styles
			$this->get_script( 'no_padding' )
				 ->set_is_gutenberg()
				 ->set_path( 'lib/css/common/style_no_padding.css' );

			$this->get_script( 'no_padding_vertical' )
				->set_is_gutenberg()
				->set_path( 'lib/css/common/style_no_padding_vertical.css' );

			// Register Block Styles
			$attributes		= array();
			if($this->get_setting('extra_styles')->get_data() && count($this->get_setting('extra_styles')->get_data()) > 0) {
				foreach ($this->get_setting('extra_styles')->get_data() as $extra_style) {
					$attributes[$extra_style['slug']] = $extra_style['entry_label'];
				}
			}

			if(count($attributes) > 0) {
				$this->get_script('block_extra_styles')->set_localized($attributes);
			}

			return $this;
		}
	}