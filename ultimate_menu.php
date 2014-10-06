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

function ultimate_menu_cb() {
	echo 'asdf';
}
function render_ultimate_menu() {
	$meun_name = 'Ultimae Menu1';
	//$args = array(    'nopaging'               => false,);
	$args = array();
	$items = wp_get_nav_menu_items($meun_name, $args);
	include 'render_menu.php';

}

add_action('admin_init', 'add_custom_meta_box_um');
add_action('admin_init', 'add_label_meta_box_um');

function add_custom_meta_box_um() {
	global $pagenow;
	if ('nav-menus.php' == $pagenow) {

		add_meta_box(
			'ultimate_menu_meta_box',
			__("ultimate Menu Settings", "ultimatemenu"),
			'UM_metabox_contents', //        array( $this, 'metabox_contents' ),
			'nav-menus',
			'side',
			'high'
		);

	}
}

function add_label_meta_box_um() {
	global $pagenow;
	if ('nav-menus.php' == $pagenow) {

		add_meta_box(
			'ultimate_menu_meta_box',
			__("Label", "Label"),
			'UM_label_metabox_contents', //        array( $this, 'metabox_contents' ),
			'nav-menus',
			'side',
			'high'
		);

	}
}
//require_once dirname(__FILE__) . '/menu-item-custom-fields/doc/menu-item-custom-fields-example.php';

function UM_label_metabox_contents() {
	?>
<div id='megamenu_accordion'>
    <div class='accordion_content'>
        <div class="inside">
            <div class="customlinkdiv" id="customlinkdiv">
                <input type="hidden" value="custom" name="menu-item[-33][menu-item-type]">
                <p id="menu-item-url-wrap" style="z-index: -1;position: absolute">
                    <label class="howto" for="custom-menu-item-url">
                        <span>URL</span>
                        <input id="custom-menu-item-url" name="menu-item[-33][menu-item-url]" type="text" class="code menu-item-textbox" value="http://#">
                    </label>
                </p>
                <p id="menu-item-name-wrap">
                    <label class="howto" for="custom-menu-item-name">
                        <span>Label Text</span>
                        <input id="custom-menu-item-name" name="menu-item[-33][menu-item-title]" type="text" class="regular-text menu-item-textbox input-with-default-title" title="Label Text">
                    </label>
                </p>

                <p class="button-controls">
                    <span class="add-to-menu">
                        <input type="submit" class="button-secondary submit-add-to-menu right" value="Add to Menu" name="add-custom-menu-item" id="submit-customlinkdiv">
                        <span class="spinner"></span>
                    </span>
                </p>

            </div>
            <!-- /.customlinkdiv -->
        </div>
    </div>
</div>

<?php
}
function UM_metabox_contents() {
	print_enable_ultimatemenu_options(16);

}

function print_enable_ultimatemenu_options($menu_id) {

	$theme_locations = get_registered_nav_menus();

	$saved_settings = get_site_option('megamenu_settings');

	if (!count($theme_locations)) {

		echo "<p>" . __("This theme does not have any menu locations.", "megamenu") . "</p>";

		//} else if ( ! count ( $tagged_menu_locations ) ) {
	} else if (0) {

		echo "<p>" . __("This menu is not tagged to a location. Please tag a location to enable the Mega Menu settings.", "megamenu") . "</p>";

	} else {?>

<?php if (count($tagged_menu_locations) == 1):?>

<?php

		$locations = array_keys($tagged_menu_locations);
		$location = $locations[0];

		if (isset($tagged_menu_locations[$location])) {
			$this->settings_table($location, $saved_settings);
		}

		?>

<?php else:?>
<div id='megamenu_accordion'>

<?php foreach ($theme_locations as $location => $name):?>

<?php if (isset($tagged_menu_locations[$location])):?>

                            <h3 class='theme_settings'><?php echo $name;?></h3>

                            <div class='accordion_content' style='display: none;'>
<?php $this->settings_table($location, $saved_settings);?>
</div>

<?php endif;?>

<?php endforeach;?>
</div>

<?php endif;?>

<?php

		submit_button(__('Save'), 'button-primary alignright');

	}

}

function pr($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}