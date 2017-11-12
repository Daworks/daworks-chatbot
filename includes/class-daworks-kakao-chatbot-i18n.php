<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://daworks.io
 * @since      1.0.0
 *
 * @package    Daworks_Kakao_Chatbot
 * @subpackage Daworks_Kakao_Chatbot/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Daworks_Kakao_Chatbot
 * @subpackage Daworks_Kakao_Chatbot/includes
 * @author     Design Arete <cs@daworks.org>
 */
class Daworks_Kakao_Chatbot_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'daworks-kakao-chatbot',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
