<?php
	
	/**
	 * The public-facing functionality of the plugin.
	 *
	 * @link       https://daworks.io
	 * @since      1.0.0
	 *
	 * @package    Daworks_Kakao_Chatbot
	 * @subpackage Daworks_Kakao_Chatbot/public
	 */
	
	/**
	 * The public-facing functionality of the plugin.
	 *
	 * Defines the plugin name, version, and two examples hooks for how to
	 * enqueue the public-facing stylesheet and JavaScript.
	 *
	 * @package    Daworks_Kakao_Chatbot
	 * @subpackage Daworks_Kakao_Chatbot/public
	 * @author     Design Arete <cs@daworks.org>
	 */
	class Daworks_Kakao_Chatbot_Public {
		
		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string $plugin_name The ID of this plugin.
		 */
		private $plugin_name;
		
		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string $version The current version of this plugin.
		 */
		private $version;
		
		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 *
		 * @param      string $plugin_name The name of the plugin.
		 * @param      string $version The version of this plugin.
		 */
		public function __construct ( $plugin_name, $version ) {
			
			$this -> plugin_name = $plugin_name;
			$this -> version     = $version;
			
		}
		
		/**
		 * Register the stylesheets for the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles () {
			
			wp_enqueue_style ( $this -> plugin_name, plugin_dir_url ( __FILE__ ) . 'css/daworks-kakao-chatbot-public.css', array (), $this -> version, 'all' );
			
		}
		
		/**
		 * Register the JavaScript for the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts () {
			wp_enqueue_script ( $this -> plugin_name, plugin_dir_url ( __FILE__ ) . 'js/daworks-kakao-chatbot-public.js', array ( 'jquery' ), $this -> version, false );
		}
		
		
		public function frontend_page_show () {
			
			add_shortcode ( 'daworks-chatbot-view', 'show_frontend_page' );
			
			function show_frontend_page () {
				global $wpdb;
				$table   = $wpdb -> prefix . 'daworks_chatbot';
				
				$mode = !empty($_REQUEST['mode']) ? $_REQUEST['mode'] : 'list';
				
				if ( $mode == 'list' ) :
				
					require plugin_dir_path ( __DIR__ ) . 'library/PHP-Pagination/Pagination.class.php';
					$page        = (Null !== $_REQUEST[ 'current_page' ]) ? ( (int) $_REQUEST[ 'current_page' ] ) : 1;
					$limit       = 9;
					$start_point = $page * $limit - $limit;
					
					$pagination = new Pagination();
					$pagination -> setCurrent ( $page );
					$pagination -> setKey ( 'current_page' );
					$pagination -> setCrumbs ( 10 );
					$pagination -> setRPP ( $limit );
					$pagination -> setClasses ('daworks-chatbot-pagination');
					$pagination -> setPrevious ( '이전');
					$pagination -> setNext ( '다음');
					
					$query   = "SELECT * FROM {$table} WHERE name_check > 0 AND title_check > 0 AND story_check > 0 AND photo_check > 0";
					$query   .= " ORDER BY id DESC LIMIT {$start_point}, {$limit}";
					$records = $wpdb -> get_results ( $query );
					$total = $wpdb->get_var("SELECT count(*) FROM {$table} WHERE name_check > 0 AND title_check > 0 AND story_check > 0 AND photo_check > 0");
					
					$pagination -> setTotal ( $total );
					$markup = $pagination -> parse ();
					
					require plugin_dir_path ( __FILE__ ) . 'partials/daworks-kakao-chatbot-public-display.php';
				
				elseif ($mode == 'show') :
					
					$show_id = (null !== $_REQUEST['show_id']) ? $_REQUEST['show_id'] : null;
					if ( null !== $show_id ) {
						$query = "select * from $table where id = $show_id";
						$card = $wpdb->get_row($query);
						
						$prev_query = "SELECT max(id) prev_id FROM $table WHERE id < $show_id name_check > 0 AND title_check > 0 AND story_check > 0 AND photo_check > 0";
						$next_query = "SELECT min(id) next_id FROM $table WHERE id > $show_id name_check > 0 AND title_check > 0 AND story_check > 0 AND photo_check > 0";
						
						$prev_id = $wpdb->get_var($prev_query);
						$next_id = $wpdb->get_var($next_query);
						$prev_title = $wpdb->get_var("SELECT title FROM $table WHERE id = $prev_id name_check > 0 AND title_check > 0 AND story_check > 0 AND photo_check > 0");
						$next_title = $wpdb->get_var("SELECT title FROM $table WHERE id = $next_id name_check > 0 AND title_check > 0 AND story_check > 0 AND photo_check > 0");
						
						require plugin_dir_path ( __FILE__ )  . 'partials/daworks-kakao-chatbot-public-show.php';
						
					}
					else {
						echo "<script>history.back();</script>";
					}
				else :
				
				endif;
				
			}
		}
		
	}
