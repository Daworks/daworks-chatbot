<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://daworks.io
 * @since             1.0.0
 * @package           Daworks_Kakao_Chatbot
 *
 * @wordpress-plugin
 * Plugin Name:       daworks-kakao-chatbot
 * Plugin URI:        https://daworks.io
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Design Arete
 * Author URI:        https://daworks.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       daworks-kakao-chatbot
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-daworks-kakao-chatbot-activator.php
 */
function activate_daworks_kakao_chatbot() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-daworks-kakao-chatbot-activator.php';
	Daworks_Kakao_Chatbot_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-daworks-kakao-chatbot-deactivator.php
 */
function deactivate_daworks_kakao_chatbot() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-daworks-kakao-chatbot-deactivator.php';
	Daworks_Kakao_Chatbot_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_daworks_kakao_chatbot' );
register_deactivation_hook( __FILE__, 'deactivate_daworks_kakao_chatbot' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-daworks-kakao-chatbot.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_daworks_kakao_chatbot() {

	$plugin = new Daworks_Kakao_Chatbot();
	$plugin->run();
	
}
run_daworks_kakao_chatbot();
require plugin_dir_path(__FILE__) . 'includes/functions.php';