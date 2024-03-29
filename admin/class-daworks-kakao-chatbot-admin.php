<?php
	
	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * @link       https://daworks.io
	 * @since      1.0.0
	 *
	 * @package    Daworks_Kakao_Chatbot
	 * @subpackage Daworks_Kakao_Chatbot/admin
	 */
	
	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * Defines the plugin name, version, and two examples hooks for how to
	 * enqueue the admin-specific stylesheet and JavaScript.
	 *
	 * @package    Daworks_Kakao_Chatbot
	 * @subpackage Daworks_Kakao_Chatbot/admin
	 * @author     Design Arete <cs@daworks.io>
	 */
	class Daworks_Kakao_Chatbot_Admin {
		
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
		 * @param      string $plugin_name The name of this plugin.
		 * @param      string $version The version of this plugin.
		 */
		public function __construct ( $plugin_name, $version ) {
			
			$this -> plugin_name = $plugin_name;
			$this -> version     = $version;
			
		}
		
		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles () {
			
			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Daworks_Kakao_Chatbot_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Daworks_Kakao_Chatbot_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */
			
			wp_enqueue_style ( $this -> plugin_name, plugin_dir_url ( __FILE__ ) . 'css/daworks-kakao-chatbot-admin.css', array (), $this -> version, 'all' );
			
		}
		
		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts () {
			
			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Daworks_Kakao_Chatbot_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Daworks_Kakao_Chatbot_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */
			
			wp_enqueue_script ( $this -> plugin_name, plugin_dir_url ( __FILE__ ) . 'js/daworks-kakao-chatbot-admin.js', array ( 'jquery' ), $this -> version, false );
			
		}
		
		public function add_plugin_admin_menu () {
			add_menu_page (
				'daworks_chatbot',
				'캠페인 챗봇',
				'manage_options',
				'daworks-chatbot',
				array ( $this, 'loading_admin_menu_page' ),
				'dashicons-admin-comments'
			);
			add_submenu_page (
				'daworks-chatbot',
				'챗봇 설정',
				'챗봇 설정',
				'manage_options',
				'daworks-chatbot-setting',
				array ( $this, 'loading_setting_page' )
			);
			add_submenu_page (
				'daworks-chatbot',
				'목록',
				'목록',
				'manage_options',
				'daworks-chatbot-result',
				array ( $this, 'loading_result_page' )
			);
		}
		
		public function loading_admin_menu_page () {
			require plugin_dir_path ( __FILE__ ) . 'partials/daworks-kakao-chatbot-admin-display.php';
		}
		
		public function loading_setting_page () {
			require plugin_dir_path ( __FILE__ ) . 'partials/daworks-kakao-chatbot-setting.php';
		}
		
		public function loading_result_page () {
			require plugin_dir_path ( __DIR__ ) . 'library/PHP-Pagination/Pagination.class.php';
			
			global $wpdb;
			$table = $wpdb -> prefix . 'daworks_chatbot';
			
			$mode = isset($_REQUEST[ 'mode' ]) ? $_REQUEST[ 'mode' ] : 'list';
			
			if ( $mode == 'list') {
					 // 리스트 뷰
					 $page        = isset($_REQUEST[ 'current_page' ]) ? ( (int) $_REQUEST[ 'current_page' ] ) : 1;
					 $start_point = $page - 1;
					 $limit       = 15;
					 
					 $pagination = new Pagination();
					 $pagination -> setCurrent ( $page );
					 $pagination -> setKey ( 'current_page' );
					 $pagination -> setCrumbs ( 10 );
					 $pagination -> setRPP ( $limit );
					 $pagination -> setPrevious ( '이전' );
					 $pagination -> setNext ( '다음' );
					 
					 $query  = "SELECT * FROM {$table} ORDER BY created_at DESC LIMIT {$start_point}, {$limit}";
					 $result = $wpdb -> get_results ( $query, OBJECT );
					 $total  = $wpdb -> get_var ( "SELECT count(*) FROM $table" );
					 
					 $pagination -> setTotal ( $total );
					 
					 require plugin_dir_path ( __FILE__ ) . 'partials/daworks-kakao-chatbot-result.php';
			}
			if ( $mode == 'show' ) {
				$show_id = (null !== $_REQUEST['show_id']) ? $_REQUEST['show_id'] : null;
				if ( null !== $show_id ) {
					$query = "SELECT * FROM $table WHERE id = $show_id";
					$result = $wpdb->get_row($query);
					$current_page = !empty($_REQUEST['current_page']) ? $_REQUEST['current_page'] : 1;
					
					$prev_query = "SELECT MAX(id) FROM $table WHERE id < $show_id";
					$prev_id = $wpdb->get_var($prev_query);
					
					$next_query = "SELECT MIN(id) FROM $table WHERE id > $show_id";
					$next_id = $wpdb->get_var($next_query);
					
					require plugin_dir_path ( __FILE__ ) . 'partials/daworks-kakao-chatbot-show.php';
				}
				else {
					echo '<script>alert("정상적인 경로로 접속하세요.");history.back();</script>';
				}
			}
		}
		
		public function setup_message () {
			$option = get_option ( 'daworks_chatbot_page_slug' );
			if ( ! $option ) :
				$screen = get_current_screen ();
				if ( $screen -> parent_base == 'daworks-chatbot' ) :
					?>
			  <div class="notice notice-success is-dismissible">
				  <p><strong>DAWORKS CHATBOT</strong>이 정상적으로 설치되었습니다. <a href="<?php echo admin_url ( 'admin.php?page=daworks-chatbot' ) ?>">설정하기</a></p>
			  </div>
					<?php
				endif;
			endif;
		}
	}
