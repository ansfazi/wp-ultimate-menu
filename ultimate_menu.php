<?php
/**
 * Plugin Name: Ultimate Menu
 * Plugin URI: http://github.com/abuzer
 * Description: Plugin to extened wordpress menu
 * Version: 1.0.0
 * Author: Abuzer
 * Author URI: http://github.com/abuzer
 *
 * @package UltimateMenu
 * @category Core
 * @author Abuzer
 */
if (!defined('ABSPATH')) {
	exit;// Exit if accessed directly
}

if (!class_exists('DealOfDay')):

	final class UltimateMenu {

		protected static $_instance = null;

		public static function instance() {
			if (is_null(self::$_instance)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		public function __construct() {
			add_filter('wp_nav_menu_args', array($this, 'modify_nav_menu_args'), 9999);
			$this->define_constants();
			$this->includes();
		}

		/**
		 * Define Include files
		 */
		public function includes() {
			$meun_name = 'Ultimae Menu1';
			//wp_delete_nav_menu($meun_name);
			$menu_exists = wp_get_nav_menu_object($meun_name);
			//print_r( $menu_exists->term_id  );
			$menu_id = $menu_exists->term_id;
			if (!$menu_exists) {
				include (ABSPATH . 'wp-admin/includes/nav-menu.php');
				$menu_id = wp_create_nav_menu($meun_name);
				$locations = get_theme_mod('nav_menu_locations');
				$locations['primary-menu'] = $menu_id;
				set_theme_mod('nav_menu_locations', $locations);
			}
			/*
			$arr = array(
			'menu-item-title' =>  __('Shop'),
			'menu-item-classes' => 'programme',
			'menu-item-url' => home_url( '/' ),
			'menu-item-status' => 'publish'
			);
			echo '<pre>';
			print_r( $arr );
			echo '</pre>';
			wp_update_nav_menu_item($menu_id, 0, $arr);
			 */

			include ('includes/install.class.php');
			include ('includes/admin-menu.class.php');
			include ('includes/um_nav_menu.class.php');
			include ('includes/um_ajax.class.php');
			include ('includes/admin-views.class.php');
			if (is_admin()) {
				new Ultimate_Menu_Nav_Menus();
			}
		}

		/**
		 * Define Constants
		 */
		private function define_constants() {
			define('DD_PLUGIN_FILE', __FILE__);
		}
		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit(plugins_url('/', __FILE__));
		}
		public function default_img_src() {
			return $this->plugin_url() . '/assets/images/dd-placeholder.gif';
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit(plugin_dir_path(__FILE__));
		}
		/**
		 * Use the Mega Menu walker to output the menu
		 * Resets all parameters used in the wp_nav_menu call
		 * Wraps the menu in mega-menu IDs and classes
		 *
		 * @since 1.0
		 * @param $args array
		 * @return array
		 */
		public function modify_nav_menu_args($args) {

			$defaults = array(
				'walker' => new Walker_Ultimate_Menu()
			);

			$args = array_merge($args, $defaults);

			return $args;
		}
	}
/**
 * Returns the main instance of DOD to prevent the need to use globals.
 *
 */
	function UltimateMenu() {
		return UltimateMenu::instance();
	}
// Global for backwards compatibility.
	$GLOBALS['WPUM'] = UltimateMenu();
endif;

function render_ultimate_menu() {
	$meun_name = 'Ultimae Menu1';
	//$args = array(    'nopaging'               => false,);
	$args = array();
	$items = wp_get_nav_menu_items($meun_name, $args);
	include 'render_menu.php';

}

function pr($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}
//require_once dirname(__FILE__) . '/menu-item-custom-fields/doc/menu-item-custom-fields-example.php';

class Walker_Ultimate_Menu extends Walker_Nav_Menu {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	function start_lvl(&$output, $depth = 0, $args = array()) {

		echo 'asdf';
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	function end_lvl(&$output, $depth = 0, $args = array()) {
		echo 'asdf';
	}

	/**
	 * Custom walker. Add the widgets into the menu.
	 *
	 * @see Walker::start_el()
	 *
	 * @since 1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		echo ' -- ';
		$output = 'asdf';
	}
}