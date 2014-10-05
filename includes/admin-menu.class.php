<?php
/**
 *
 * @author 		Abuzer
 * @category 	Admin
 * @package 	UltimateMenu/Admin
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'UM_Admin_Menus' ) ) :

/**
 */
class UM_Admin_Menus {
	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		// Add menus
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
	}

	/**
	 * Add menu items
	 */
	public function admin_menu() {
		global $menu;
		$main_page = add_menu_page( 'Ultimate Menu', 'Ultimate Menu', 'manage_options', 'wp-ultimate-menu',  array($this, 'render_menu_page'), null, '41' );
	}
	public function render_menu_page(){
			UM_Admin_Views::index();
		}
}

endif;

return new UM_Admin_Menus();
