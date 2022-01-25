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
				->add_metaboxes()
				->get_root()
				->add_section( $this );

			/*add_action('init', function(){
				$this->load_settings()->add_metaboxes();
			});*/
		}

		protected function load_settings(): sv_block_group {
			$this->get_setting( 'sticky_offset' )
				->set_title( __( 'Style Sticky: Offset', 'sv100' ) )
				->set_description( __( 'Top Offset in Pixel for Sticky style.', 'sv100' ) )
				->set_is_responsive(true)
				->set_default_value(0)
				->load_type( 'number' );

			$this->get_setting( 'section_dynamic_visibility' )
				->set_title( __( 'Sections: Dynamic Visibility', 'sv100' ) )
				->set_description( __( 'Enable this if groups with section-tag should be hidden (except first one). Use navigation elements with anchor to section-IDs to switch through sections.', 'sv100' ) )
				->set_is_responsive(true)
				->load_type( 'checkbox' );

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

		private function add_metaboxes(): sv_block_group{
			$this->metaboxes = $this->get_root()->get_module('sv_metabox');

			$states = array(
				'0' => __('Disabled', 'sv100'),
				'1' => __('Enabled', 'sv100')
			);

			$this->metaboxes->get_setting( $this->get_prefix('sections_dynamic_visibility') )
				->set_title( __('Group Sections: Dynamic Visibility', 'sv100') )
				->set_description( __('Enable this to allow showing/hiding Block Group Sections.', 'sv100') )
				->set_default_value('0')
				->load_type( 'select' )
				->set_options($states);

			return $this;
		}

		public function section_dynamic_visibility_status(): bool{
			$section_status = $this->get_setting('section_dynamic_visibility')->get_data();
			$load_section_script		= false;
			if(is_string($section_status) && $section_status == 1){
				$load_section_script	= true;
			}
			if(is_array($section_status)){
				foreach($section_status as $section_status_responsive){
					if($section_status_responsive == 1){
						$load_section_script	= true;
					}
				}
			}

			return $load_section_script;
		}

		public function section_dynamic_visibility_status_post(): string{
			global $post;

			if (!$post) {
				return false;
			}

			if(!$this->section_dynamic_visibility_status()){
				return false;
			}

			$setting = $this->metaboxes->get_data($post->ID, $this->get_prefix('sections_dynamic_visibility'), 0);

			return boolval($setting);
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

			$this->get_script( 'sticky' )
				->set_is_gutenberg()
				->set_path( 'lib/css/common/style_sticky.css' );

			if(is_admin() ? $this->section_dynamic_visibility_status() : $this->section_dynamic_visibility_status_post()){
				$this->get_script( 'section_visibility' )
					->set_path( 'lib/css/common/section_visibility.css' );

				$this->get_script( 'section_visibility_editor' )
					->set_is_backend()
					->set_is_gutenberg()
					->set_path( 'lib/css/common/section_visibility_editor.css' );

				$this->get_script( 'section_visibility_js' )
					->set_type('js')
					->set_path( 'lib/js/frontend/section_visibility.js' );
			}
			
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
				// CSS inline due to sections may be on some pages, on some not
				if($script->get_type() === 'css'){
					$script->set_inline(true);
				}

				$script->set_is_enqueued();
			}

			return $this;
		}
	}