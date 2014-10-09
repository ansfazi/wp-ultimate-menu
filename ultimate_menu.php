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