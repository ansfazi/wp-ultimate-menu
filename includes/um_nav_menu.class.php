<?php

if (!defined('ABSPATH')) {
	exit;// disable direct access
}

if (!class_exists('Ultimate_Menu_Nav_Menus')):
/**
 * Handles all admin related functionality.
 */
	class Ultimate_Menu_Nav_Menus {
		/**
		 * Constructor
		 *
		 * @since 1.0
		 */
		public function __construct() {

			add_action('admin_init', array($this, 'register_nav_meta_box'), 11);
			add_action('admin_init', array($this, 'add_label_meta_box_um'), 11);
			// add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_menu_page_scripts' ) );
			add_action('wp_update_nav_menu_item', array($this, 'walker_save_fields'), 10, 3);

			// add_action( 'admin_post_save_ultimate_menu', array( $this, 'save') );
			// add_action( 'ultimate_menu_save_settings', array($this, 'save') );

			// add_filter( 'hidden_meta_boxes', array( $this, 'show_mega_menu_metabox' ) );
			add_filter('wp_edit_nav_menu_walker', array($this, 'walker'), 2001);
			add_filter('wp_nav_menu_item_custom_fields', array($this, 'walker_add_fields'), 10, 4);

		}

		/**
		 * Use our custom Nav Edit walker. This adds a filter which we can use to add
		 * settings to menu items.
		 *
		 * @since 1.0
		 * @param object $walker
		 * @return string
		 */
		public function walker($walker) {
			global $WPUM;
			require_once $WPUM::plugin_path() . '/classes/walker-edit.class.php';

			return 'Ultimate_Menu_Walker_Edit';

		}
		/**
		 * Adds the meta box container
		 *
		 * @since 1.0
		 */

		public function add_label_meta_box_um() {
			global $pagenow;
			if ('nav-menus.php' == $pagenow) {
				global $WPUM;
				if (is_admin()) {
					wp_enqueue_script('jquery-validate-min', $WPUM::plugin_url() . '/assets/js/admin/jquery.validate.min.js');
					wp_enqueue_script('post-validate', $WPUM::plugin_url() . '/assets/js/admin/menu_validate.js');
				}
				add_meta_box(
					'ultimate_menu_meta_box',
					__("Label", "Label"),
					array($this, 'UM_label_metabox_contents'), //        array( $this, 'metabox_contents' ),
					'nav-menus',
					'side',
					'high'
				);

			}
		}
		public function UM_label_metabox_contents() {
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
		public function register_nav_meta_box() {
			global $pagenow;

			if ('nav-menus.php' == $pagenow) {

				add_meta_box(
					'ultimate_menu_meta_box',
					__("ultimate Menu Settings", "ultimatemenu"),
					array($this, 'UM_metabox_contents'), //        array( $this, 'metabox_contents' ),
					'nav-menus',
					'side',
					'high'
				);

			}

		}

		public function UM_metabox_contents() {
			$this->print_enable_ultimatemenu_options(16);

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

	/**
	 * Show custom menu item fields.
	 *
	 * @since 1.0
	 * @param object $item
	 * @param int $depth
	 * @param array $args
	 * @param int $id
	 */
	public function walker_add_fields($id, $item, $depth, $args) {
		global $wp_registered_sidebars;

		$settings = array_filter((array) get_post_meta($item->ID, '_ultimate_menu', true));

		$defaults = array(
			'menu_type' => 'static',
		);

		$settings = array_merge($defaults, $settings);
		?>

					        <div class="mega-menu-wrap description-wide">
					        <h4><?php _e("Ultimate Menu Options", "ultimatemenu");?></h4>

					        <p class="description show-on-depth-0-only">
					            <label>
<?php _e("Menu Type", "ultimate_menu");?>
					                <select name='ultimate_menu[<?php echo $item->ID?>][menu_type]'>
					                    <option <?php selected($settings['menu_type'], 'static')?> value="static"  > Static </option>
					                    <option <?php selected($settings['menu_type'], 'list_posts')?> value="list_posts"> Posts Menu </option>
					                    <option <?php selected($settings['menu_type'], 'label_menu')?>value="label_menu"> Label </option>
					                </select>
					            </label>
					        </p>
					        </p>
					        </div>
<?php
}

	/**
	 * Save custom menu item fields.
	 *
	 * @since 1.0
	 * @param int $menu_id
	 * @param int $menu_item_id
	 * @param array $menu_item_args
	 */
	public static function walker_save_fields($menu_id, $menu_item_id, $menu_item_args) {
		if (!empty($_POST['ultimate_menu'][$menu_item_id])) {
			$value = array_filter((array) $_POST['ultimate_menu'][$menu_item_id]);
		} else {
			$value = array();
		}
		if (!empty($value)) {
			update_post_meta($menu_item_id, '_ultimate_menu', $value);
		} else {
			delete_post_meta($menu_item_id, '_ultimate_menu');
		}
	}

}// class end
endif;