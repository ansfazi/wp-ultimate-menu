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
class UM_install {
	/**
	 * Hook in tabs.
	 */
	public $menu_name = 'Ultimate Menu';
	public function __construct() {
		// Add menus
		// Check if the menu exists
		$menu_exists = wp_get_nav_menu_object( $this->menu_name );
		// If it doesn't exist, let's create it.
		// if( !$menu_exists){
		//     $menu_id = wp_create_nav_menu($this->$menu_name);

		// 	// Set up default menu items
		//     wp_update_nav_menu_item($menu_id, 0, array(
		//         'menu-item-title' =>  __('Home'),
		//         'menu-item-classes' => 'home',
		//         'menu-item-url' => home_url( '/' ), 
		//         'menu-item-status' => 'publish'));

		//     wp_update_nav_menu_item($menu_id, 0, array(
		//         'menu-item-title' =>  __('Custom Page'),
		//         'menu-item-url' => home_url( '/custom/' ), 
		//         'menu-item-status' => 'publish'));

		// }
	}
}

endif;

return new UM_install();
