<?php
/**
 * Setup menus in WP admin.
 *
 * @author 		Abuzer
 * @category 	Admin
 * @package 	UltimateMenu/Admin
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'UM_Admin_Views' ) ) :

class UM_Admin_Views {

	public function __construct() {
	}

	public static function index() {
	    //include ('views/index.php');
	}
}

endif;