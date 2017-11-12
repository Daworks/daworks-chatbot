<?php
	
	/**
	 * Fired during plugin activation
	 *
	 * @link       https://daworks.io
	 * @since      1.0.0
	 *
	 * @package    Daworks_Kakao_Chatbot
	 * @subpackage Daworks_Kakao_Chatbot/includes
	 */
	
	/**
	 * Fired during plugin activation.
	 *
	 * This class defines all code necessary to run during the plugin's activation.
	 *
	 * @since      1.0.0
	 * @package    Daworks_Kakao_Chatbot
	 * @subpackage Daworks_Kakao_Chatbot/includes
	 * @author     Design Arete <cs@daworks.org>
	 */
	class Daworks_Kakao_Chatbot_Activator {
		
		/**
		 * Short Description. (use period)
		 *
		 * Long Description.
		 *
		 * @since    1.0.0
		 */
		public static function activate () {
			global $wpdb;
			$table_name = $wpdb->prefix . 'daworks_chatbot';
			$db_version = '1.0';
			
			if ( $wpdb->get_var("SHOW TABLE LIKE '$table_name'") !== $table_name ) {
				$charset_collate = $wpdb->get_charset_collate();
				$sql = "CREATE TABLE {$table_name} (
								  id int(11) unsigned NOT NULL AUTO_INCREMENT,
								  user_key varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
								  name varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
								  name_check tinyint(1) DEFAULT '0',
								  title varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
								  title_check tinyint(1) DEFAULT '0',
								  photo text COLLATE utf8mb4_unicode_ci,
								  photo_check tinyint(1) DEFAULT '0',
								  story text COLLATE utf8mb4_unicode_ci,
								  story_check tinyint(1) DEFAULT '0',
								  created_at datetime DEFAULT '0000-00-00 00:00:00',
								  PRIMARY KEY (`id`)
								) {$charset_collate};";
				
				
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
				
				add_option('daworks_chatbot_db_ver', $db_version);
			}
		}
	}
