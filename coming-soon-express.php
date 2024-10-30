<?php
/*
 * Plugin Name: 	Coming Soon Express
 * Description: 	The fastest, easiest 'Coming Soon' page for your website! Use the WP Customizer to see a Live Preview of your page as you edit. Launch a temporary page in minutes!
 * Version: 		1.0.7
 * Author: 			brandiD
 * Author URI: 		https://thebrandid.com
 * Text Domain:		coming_soon_express_domain
 * License:			GPL-2.0+
 * License URI:		http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

//* Exit if not WordPress
if ( ! defined( 'WPINC' ) ) {
	die;
}

//* Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//* Default Constants
define( 'CSEXPRESS_SLUG', 'coming-soon-express/coming-soon-express.php' );
define( 'CSEXPRESS_TEXTDOMAIN', 'coming_soon_express_domain' );
define( 'CSEXPRESS_PLUGIN_NAME', __( 'Coming Soon Express', 'coming_soon_express_domain' ) );
define( 'CSEXPRESS_PLUGIN_VERSION', '1.0.6' );
define( 'CSEXPRESS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) ); // Example output: /Applications/MAMP/htdocs/{yoursite}/wp-content/plugins/coming-soon-express/
define( 'CSEXPRESS_PLUGIN_ABS_URL', plugin_dir_url( __FILE__ ) ); // Example output: http://localhost/{yoursite}/wp-content/plugins/coming-soon-express/
define( 'CSEXPRESS_ADMIN_PATH', plugin_dir_url( __FILE__ ) . 'admin' );
define( 'CSEXPRESS_TEMPLATE_PATH', plugin_dir_url( __FILE__ ) . 'template' );

// Actions to run on Plugin Activation
register_activation_hook( __FILE__, 'csx_activation_actions' );
function csx_activation_actions(){
    do_action( 'csx_extension_activation' );
}

// Set Plugin Defaults
add_action( 'csx_extension_activation', 'csx_set_default_options' );
function csx_set_default_options(){

	// Show BG Image setting
	if ( null == get_option( 'csx_show_bg_image' ) ) {
		update_option( 'csx_show_bg_image', '1' );
	}

	// Default BG Image
	if ( null == get_option( 'csx_bg_image' ) ) {
		update_option( 'csx_bg_image', CSEXPRESS_TEMPLATE_PATH . '/img/default-bg.jpg' );
	}

	// Show Big Title setting
	if ( null == get_option( 'csx_show_bigtitle' ) ) {
		update_option( 'csx_show_bigtitle', '1' );
	}

	// Show Headline setting
	if ( null == get_option( 'csx_show_headline' ) ) {
		update_option( 'csx_show_headline', '1' );
	}

	// Show Description setting
	if ( null == get_option( 'csx_show_description' ) ) {
		update_option( 'csx_show_description', '1' );
	}

}

//* Include required files
require_once plugin_dir_path( __FILE__ ) . 'includes/class-coming-soon-express.php';

//* Run main plugin function
function run_coming_soon_express() {

	//* Create new object
	$coming_soon_object = new Coming_Soon_Express();

	//* Do 'run' function inside object
	$coming_soon_object->run();

}

//* Go
run_coming_soon_express();
?>
