<?php
/**
 *
 * @author      Abuzer
 * @category    Admin
 * @package     UltimateMenu/Admin
 * @version     1.0
 */
class UM_Ajax {

	/**
	 * init() function to be called on initilization.
	 */
	public static function init() {
		$ajax_events = array(
			'um_save_settings',
		);
		foreach ($ajax_events as $ajax_event) {
			add_action('wp_ajax_' . $ajax_event, array(__CLASS__, $ajax_event));
		}
	}

	/**
	 * Ajax action to update the deal status. Hide/Show from listing on deal page
	 * @return void
	 **/
	public static function um_save_settings() {
		print_r($_POST);
		update_option('um_menu_theme', $_POST['um_menu_theme']);
		update_option('um_enable_logo', $_POST['um_enable_logo']);
		die();// this is required to terminate immediately and return a proper response
	}
}
UM_Ajax::init();