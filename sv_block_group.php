<?php
	namespace sv100;

	class sv_block_group extends init {
		public function init() {
			$this->set_module_title( __( 'Block: Group', 'sv100' ) )
				->set_module_desc( __( 'Settings for Gutenberg Block', 'sv100' ) )
				->set_css_cache_active()
				->set_section_title( $this->get_module_title() )
				->set_section_desc( $this->get_module_desc() )
				->set_section_type( 'settings' )
				->set_section_template_path()
				->set_section_order(5000)
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
		public function enqueue_scripts(): sv_block_group {
			if(!$this->has_block_frontend('group')){
				return $this;
			}

			if(!is_admin()){
				$this->load_settings()->register_scripts();
			}

			foreach($this->get_scripts() as $script){
				$script->set_is_enqueued();
			}

			return $this;
		}
	}