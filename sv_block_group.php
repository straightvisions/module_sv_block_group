<?php
	namespace sv100;

	/**
	 * @version         4.001
	 * @author			straightvisions GmbH
	 * @package			sv100
	 * @copyright		2019 straightvisions GmbH
	 * @link			https://straightvisions.com
	 * @since			1.000
	 * @license			See license.txt or https://straightvisions.com
	 */

	class sv_block_group extends init {
		public function init() {
			$this->set_module_title( __( 'Block: Group', 'sv100' ) )
				->set_module_desc( __( 'Settings for Gutenberg Block', 'sv100' ) )
				->load_settings()
				->register_scripts()
				->set_section_title( $this->get_module_title() )
				->set_section_desc( $this->get_module_desc() )
				->set_section_type( 'settings' )
				->set_section_template_path( $this->get_path( 'lib/backend/tpl/settings.php' ) )
				->get_root()
				->add_section( $this );
		}

		protected function load_settings(): sv_block_group {
			$this->get_setting( 'margin' )
				->set_title( __( 'Margin', 'sv100' ) )
				->set_is_responsive(true)
				->load_type( 'margin' );

			$this->get_setting( 'padding' )
				->set_title( __( 'Padding', 'sv100' ) )
				->set_is_responsive(true)
				->load_type( 'margin' );

			$this->get_setting( 'border' )
				->set_title( __( 'Border', 'sv100' ) )
				->set_is_responsive(true)
				->load_type( 'border' );

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
			$attributes		= array();

			if($this->get_setting('extra_styles')->get_data() && count($this->get_setting('extra_styles')->get_data()) > 0) {
				foreach ($this->get_setting('extra_styles')->get_data() as $extra_style) {
					$attributes[$extra_style['slug']] = $extra_style['entry_label'];
				}
			}

			// Register Block Styles
			if(count($attributes) > 0) {
				$this->get_script('block')
					->set_path('lib/backend/js/block.js')
					->set_type('js')
					->set_is_gutenberg()
					->set_is_backend()
					->set_deps(array('wp-blocks', 'wp-dom'))
					->set_localized($attributes)
					->set_is_enqueued();
			}

			// Register Styles
			$this->get_script( 'common' )
				->set_is_gutenberg()
				->set_path( 'lib/frontend/css/common.css' );

			$this->get_script( 'config' )
				->set_path( 'lib/frontend/css/config.php' )
				->set_is_gutenberg()
				->set_inline( true );

			add_action('wp', array($this,'enqueue_scripts'));
			add_action('admin_init', array($this,'enqueue_scripts'));

			return $this;
		}
		public function enqueue_scripts(): sv_block_group {
			if( ! is_admin() ) {
				$post = get_post();

				if ( !has_block( 'group', $post )) {
					return $this;
				}
			}

			$this->get_script( 'common' )->set_is_enqueued();
			$this->get_script( 'config' )->set_is_enqueued();

			return $this;
		}
	}