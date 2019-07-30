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
	 * @author     Design Arete <cs@daworks.io>
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

				$host = $_SERVER['HTTP_HOST'];
				if ( $host === 'dev.daworks.io' ) :
                    $info = <<< HTML
<div id="daworks-ad">
    <p>
        <strong>Daworks Chatbot</strong>은 카카오톡 플러스친구의 스마트 채팅과 연동하여 사용하는 워드프레스용 챗봇 플러그인 입니다.<br>
        캠페인 참여 유도, SNS Posting, 설문조사 및 결과 자동 수합 등 다양하게 응용하여 사용할 수 있습니다.<br>
        워드프레스로 제작된 홈페이지는 간편하게 플러그인을 설치하여 연동할 수 있습니다.
    </p>
    <p style="color:#B9314D;margin-top:.5rem;">현재 카카오플러스친구의 스마트채팅 서비스의 api형 서비스는 종료되어서 신규 가입자는 서비스 이용을 하실 수 없습니다. 단 기존에 스마트채팅 API 서비스를 이용중이셨던 고객은 2019년 12월 31일까지 현재 서비스를 계속 이용하실 수 있습니다.</p>   
    <br>
    <p align="center">
        문의 : <a href="mailto:cs@daworks.io">cs@daworks.io</a> / TEL <a href="tel:07044047726">070-4404-7726</a> / <a href="http://pf.kakao.com/_PxmwBd">카카오톡 오픈채팅</a>
    </p>
    <p align="center">
        다운로드 : <a href="https://github.com/Daworks/daworks-chatbot">https://github.com/Daworks/daworks-chatbot</a>
    </p>
</div>
HTML;
					echo $info;

				endif;
					
				global $wpdb;
				$table = $wpdb -> prefix . 'daworks_chatbot';
				$mode = ! empty( $_REQUEST[ 'mode' ] ) ? $_REQUEST[ 'mode' ] : 'list';
				
				$http_scheme = 'http://';
				if ( $_SERVER['HTTPS'] == 'on' ) {
					$http_scheme = 'https://';
				}
				$host = $_SERVER['HTTP_HOST'];
				$request = $_SERVER['REQUEST_URI'];
				$current_uri = $http_scheme . $host . $request;

				switch( $mode ) {
                    case "list" :
	                    require plugin_dir_path ( __DIR__ ) . 'library/PHP-Pagination/Pagination.class.php';
	                    $page        = isset( $_REQUEST[ 'current_page' ] ) ? ( (int) $_REQUEST[ 'current_page' ] ) : 1;
	                    $limit       = 9;
	                    $start_point = $page * $limit - $limit;

	                    $pagination = new Pagination();
	                    $pagination -> setCurrent ( $page );
	                    $pagination -> setKey ( 'current_page' );
	                    $pagination -> setCrumbs ( 10 );
	                    $pagination -> setRPP ( $limit );
	                    $pagination -> setClasses ( 'daworks-chatbot-pagination' );
	                    $pagination -> setPrevious ( '이전' );
	                    $pagination -> setNext ( '다음' );

	                    $query   = "SELECT * FROM {$table} WHERE name_check > 0 AND title_check > 0 AND story_check > 0 AND photo_check > 0";
	                    $query   .= " ORDER BY id DESC LIMIT {$start_point}, {$limit}";
	                    $records = $wpdb -> get_results ( $query );
	                    $total   = $wpdb -> get_var ( "SELECT count(*) FROM {$table} WHERE name_check > 0 AND title_check > 0 AND story_check > 0 AND photo_check > 0" );

	                    $pagination -> setTotal ( $total );
	                    $markup = $pagination -> parse ();

	                    require (plugin_dir_path ( __FILE__ ) . 'partials/daworks-kakao-chatbot-public-display.php');
                        break;

                    case "show" :

                        $show_id = ( NULL !== $_REQUEST[ 'show_id' ] ) ? $_REQUEST[ 'show_id' ] : NULL;

	                    if ( $show_id ) {

		                    $query = "select * from {$table} where id = {$show_id}";
		                    $prev_query = "SELECT max(id) prev_id FROM {$table} WHERE id < {$show_id} AND name_check > 0 AND title_check > 0 AND story_check > 0 AND photo_check > 0";
		                    $next_query = "SELECT min(id) next_id FROM {$table} WHERE id > {$show_id} AND name_check > 0 AND title_check > 0 AND story_check > 0 AND photo_check > 0";

		                    $card  = $wpdb -> get_row ( $query );
		                    $prev_id    = $wpdb -> get_var ( $prev_query );
		                    $next_id    = $wpdb -> get_var ( $next_query );

		                    $prev_title = (null !== $prev_id) ? $wpdb -> get_var ( "SELECT title FROM {$table} WHERE id = {$prev_id}" ) : '';
		                    $next_title = (null !== $next_id) ? $wpdb -> get_var ( "SELECT title FROM {$table} WHERE id = {$next_id}" ) : '';

		                    require(plugin_dir_path ( __FILE__ ) . 'partials/daworks-kakao-chatbot-public-show.php');


	                    } else {
		                    print("<script>history.back();</script>");
	                    }

                        break;
                }

				echo sprintf('<p class="daworks-copyright"><a href="https://daworks.io">&copy;%s 디자인아레테</a></p>', date('Y'));

			}
		}
		
	}
