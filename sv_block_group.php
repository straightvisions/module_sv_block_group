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
				->register_scripts()
				->get_root()
				->add_section( $this );
		}

		protected function register_scripts(): sv_block_group {
			// Register Styles
			$this->get_script( 'common' )
				->set_is_gutenberg()
				->set_path( 'lib/frontend/css/common.css' );

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

			return $this;
		}
	}