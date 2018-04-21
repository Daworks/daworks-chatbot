<?php
	/**
	 * Created by PhpStorm.
	 * User: dhlee
	 * Date: 2017. 11. 10.
	 * Time: PM 6:12
	 */
	session_start ();
	
	require plugin_dir_path ( __FILE__ ) . '../vendor/autoload.php';
	
	use Intervention\Image\ImageManager;
	use Aws\S3\S3Client;
	
	global $wpdb;
	$table = $wpdb -> prefix . 'daworks_chatbot';
	
	add_action ( 'rest_api_init', 'add_chatbot_api' );
	function add_chatbot_api () {
		register_rest_route ( 'daworkschatbot/v1', '/keyboard', array (
			'methods'  => 'GET',
			'callback' => 'daworks_chatbot_keyboard',
		) );
		register_rest_route ( 'daworkschatbot/v1', '/message', array (
			'methods'  => 'POST',
			'callback' => 'daworks_chatbot_messsage',
		) );
	}
	
	function daworks_chatbot_keyboard () {
		$campaign_title = get_option('daworks_chatbot_campaign_title');
		$response = [
			'type'    => 'buttons',
			'buttons' => [
				$campaign_title,
				'홈페이지'
			]
		];
		
		return $response;
	}
	
	function daworks_chatbot_messsage () {
		global $wpdb;
		$table = $wpdb -> prefix . 'daworks_chatbot';
		
		$data = json_decode ( file_get_contents ( 'php://input', true ) );
		
		$type     = $data -> type;
		$user_key = $data -> user_key;
		$content  = $data -> content;
		
		$dt       = new DateTime();
		$dt->setTimezone(new DateTimeZone('Asia/Seoul'));
		$now      = $dt -> format ( 'Y-m-d H:i:s' );
		$campaign_title = get_option('daworks_chatbot_campaign_title');
		$homelink = get_option('daworks_chatbot_page_slug');
		$goodjob_url = plugins_url ('library/img/good_job.gif',dirname(__FILE__));
		
		
		if ( $type == 'text' && $content == 'test' )
		{
			return [
				'message' => [
					'text' => $goodjob_url,
					'photo' => [
						'url' => $goodjob_url,
						'width' => 640,
						'height' => 480
					]
				]
			];
		}
		
		if ( $type == 'text' && $content == $campaign_title ) {
			$wpdb -> insert ( $table, array ( 'user_key' => $user_key, 'created_at' => $now ), array ( '%s', '%s' ) );
			
			$response = [
				'message'  => [
					'text' => $campaign_title . '을 시작할까요?'
				],
				'keyboard' => [
					'type'    => 'buttons',
					'buttons' => [ 'GO GO !' ]
				]
			];
			
			return $response;
		}
		
		if ( $type == 'text'  && $content == '홈페이지' ) {
			$response = [
				'message' => [
					'text' => '홈페이지로 이동하시려면 아래 링크를 터치하세요.',
					'message_button' => [
						'label' => '홈페이지로 가기',
						'url' => $homelink
					]
				]
			];
			
			return $response;
		}
		 
		 
		 if ( $type == 'text'  && $content == '사진 업로드' ) {
			 $response = [
				 'message' => [
					 'text' => '[+]버튼을 터치해서 사진을 보내주세요.]'
				 ]
			 ];
			 
			 return $response;
		 }
		
		
		if ( $type == 'text' && ( $content == 'GO GO !' || $content == '다시') ) {
			$query = "SELECT name FROM $table WHERE user_key = '{$user_key}' and name IS NOT NULL LIMIT 1";
			$username   = $wpdb -> get_var ( $query );
			
			if ( $username ) {
				// 이름이 있을 경우
				$temp = dwcb_get_data ( $user_key );
				$wpdb -> update (
					$table,
					array (
						'name' => $username,
						'name_check' => 1
					),
					array (
						'id' => $temp -> id
					)
				);
				
				$response = [
					'message'  => [
						'text' => $username . '님 반갑습니다~
글 제목을 입력해주세요.'
					]
				];
				
				return $response;
				
			} else {
				$response = [
					'message' => [
						'text' => '이름을 알려주세요~'
					]
				];
				
				return $response;
			}
		}
		
		if ( $type == 'text' && $content != 'GO GO !' || $content != '원띵 챌린지' ) {
			$temp = dwcb_get_data ( $user_key );
			
			if ( $content == '네, 제 이름이 맞아요' ) {
				$wpdb -> update (
					$table,
					array (
						'name'       => $temp -> name,
						'name_check' => 1
					),
					array (
						'id' => $temp -> id
					)
				);
				
				$response = [
					'message'  => [
						'text' => '글 제목을 입력해주세요'
					]
				];
				
				return $response;
			}
			
			if ( $content == '아니오, 제 이름이 아니에요' ) {
				$wpdb -> update ( $table, [ 'name' => NULL, 'name_check' => 0 ], [ 'id' => $temp -> id ] );
				
				$response = [
					'message' => [
						'text' => '이름을 입력해주세요~'
					]
				];
				
				return $response;
			}
			
			if ( $temp -> name_check == 0 ) {
				$wpdb -> update (
					$table,
					array (
						'name'       => $content,
						'name_check' => 1
					),
					array (
						'id' => $temp -> id
					)
				);
				
				$response = [
					'message'  => [
						'text' => $content . '님이 맞나요?'
					],
					'keyboard' => [
						'type'    => 'buttons',
						'buttons' => [ '네, 제 이름이 맞아요', '아니오, 제 이름이 아니에요' ]
					]
				];
				
				return $response;
			}
			
			if ( $temp -> name_check == 1 && $temp -> title_check == 0 ) {
				$wpdb->update(
					$table,
					[
						'title' => $content,
						'title_check' => 1
					],
					['id'=>$temp->id]
				);
				
				$response = [
					'message' => [
						'text' => '스토리를 입력해주세요.'
					]
				];
				
				return $response;
			}
			
			if ( $temp -> name_check == 1 && $temp -> title_check == 1 && $temp -> story_check == 0 ) {
				$wpdb -> update (
					$table,
					[
						'story'       => $content,
						'story_check' => 1
					],
					[ 'id' => $temp -> id ]
				);
				
				$response = [
					'message' => [
						'text' => '이제 사진을 올려주실래요?
[+]버튼을 눌러서 사진을 찍어 보내주세요~
사진을 처리하는데 시간이 조금 걸려요~'
					],
					'keyboard' => [
						'type' => 'buttons',
						'buttons' => [
								'사진 업로드',
								'사진은 생략할께요'
						]
					]
				];
				return $response;
			}
			
			if ( $temp -> name_check == 1 && $temp -> title_check == 1 && $temp -> story_check == 1 && $temp->photo_check == 0 && $content == '사진은 생략할께요' )
			{
				$wpdb->update(
					$table,
					array('photo' => 'none', 'photo_check'=> 2, 'created_at'=>$now),
					array('id'=>$temp->id)
				);
				
				$link = get_option('daworks_chatbot_page_slug');
				
				$response = [
					'message' => [
						'text' => '이제 다 됐습니다. 올린 글을 한번 확인해볼까요?',
						'photo' => [
							'url' => $goodjob_url,
							'width' => 640,
							'height' => 480
						],
						'message_button' => [
							'label' => '글 보러가기',
							'url' => $link
						]
					]
				];
				
				return $response;
			}
			
			if ( $temp->name_check > 0 && $temp->title_check > 0 && $temp->story_check > 0 && $temp->photo_check > 0 && $temp->story_check > 0 )
			{
				$link = get_option('daworks_chatbot_page_slug');
				$response = [
					'message' => [
						'text' => '이제 다 됐습니다. 올린 글을 한번 확인해볼까요?',
						'photo' => [
							'url' => $goodjob_url,
							'width' => 640,
							'height' => 480
						],
						'message_button' => [
							'label' => '글 보러가기',
							'url' => $link
						]
					]
				];
				
				return $response;
			}
			
		}
		
		// 사진 처리
		if ( $type == 'photo' ) {
			$temp = dwcb_get_data ( $user_key );
			
			$manager = new ImageManager(array('driver' => 'gd'));
			$image = $manager->make($content)->orientate();
			$image->resize(1024, null, function($constraint){
				$constraint->aspectRatio();
				$constraint->upsize();
			});
			$save_path = wp_upload_dir();
			$upload_dir = $save_path['basedir'].'/daworks_chatbot';
			if ( $_SERVER['HTTPS'] == 'on' )
			{
				$upload_path = str_replace('http://','https://',$save_path['baseurl'] . '/daworks_chatbot');
			}
			else {
				$upload_path = $save_path['baseurl'] . '/daworks_chatbot';
			}
			if ( ! file_exists ( $upload_dir) ) {
				wp_mkdir_p ( $upload_dir );
			}
			
			$filename = sha1($user_key . time()) . '.jpg';
			$image->save( $upload_dir . '/' . $filename );
			
			$wpdb->update (
				$table,
				array(
					'photo'=>$upload_path . '/' . $filename,
					'photo_check' => 1,
					'created_at' => $now
				),
				array('id'=>$temp->id)
			);
			
			$query = "SELECT * FROM {$table} WHERE id = {$temp->id}";
			$record = $wpdb->get_row($query);
			
			if ( $record->name_check == 0 ) {
				$response = [
					'message' => [
						'text' => '이름을 입력해주세요.'
					]
				];
			}
			elseif ( $record -> title_check == 0 ){
				$response = [
					'message' => [
						'text' => '제목을 입력해주세요.'
					]
				];
			}
			elseif ( $record -> story_check == 0 ) {
				$response = [
					'message' => [
						'text' => '스토리를 입력해주세요.'
					]
				];
			}
			elseif ( $record -> photo_check == 0 ) {
				$response = [
					'message' => [
						'text' => '사진을 올려주실래요?'
					],
					'keyboard' => [
						'type' => 'buttons',
						'buttons' => ['사진은 생략할께요']
					]
				];
			}
			else {
				$link = get_option('daworks_chatbot_page_slug');
				$response = [
					'message' => [
						'text' => '이제 다 됐습니다!
올린 글을 한번 볼까요?
다시 시작하려면 "다시" 라고 입력하세요.',
						'photo' => [
							'url' => $goodjob_url,
							'width' => 640,
							'height' => 480
						],
						'message_button' => [
							'label' => '내 글 보기',
							'url' => $link
						]
					]
				];
			}
			
			return $response;
		}
		
	}
	
	function dwcb_get_data ( $user_key ) {
		global $wpdb;
		$table = $wpdb -> prefix . 'daworks_chatbot';
		
		$query = "SELECT * FROM {$table} ";
		$query .= "WHERE user_key = '" . $user_key . "'";
		$query .= " AND (name_check = 0 OR title_check = 0 OR photo_check = 0 OR story_check = 0)";
		$query .= " ORDER BY id DESC LIMIT 1";
		
		$result = $wpdb -> get_row ( $query );
		
		return $result;
	}
	
	add_action ( 'wp_ajax_daworks_chatbot_save_option', 'daworks_chatbot_save_option' );
	function daworks_chatbot_save_option () {
		$opt = [];
		
		$opt[ 'key' ]    = $_REQUEST[ 'aws_s3_key' ];
		$opt[ 'secret' ] = $_REQUEST[ 'aws_s3_secret' ];
		$opt[ 'bucket' ] = $_REQUEST[ 'aws_s3_bucket' ];
		$opt[ 'region' ] = $_REQUEST[ 'aws_s3_region' ];
		
		function errorReport ( $message ) {
			return json_encode ( [ 'status' => 'fail', 'message' => $message ] );
		}
		
		if ( empty( $opt[ 'key' ] ) ) {
			echo errorReport ( 'KEY를 입력하세요.' );
			wp_die ();
		}
		if ( empty( $opt[ 'secret' ] ) ) {
			echo errorReport ( 'SECRET을 입력하세요.' );
			wp_die ();
		}
		if ( empty( $opt[ 'bucket' ] ) ) {
			echo errorReport ( '버킷이름을 입력하세요.' );
			wp_die ();
		}
		if ( empty( $opt[ 'region' ] ) ) {
			echo errorReport ( '리전을 입력하세요.' );
			wp_die ();
		}
		
		$save_option = update_option ( 'daworks_chatbot_opt_aws_info', json_encode ( $opt ) );
		if ( $save_option ) {
			echo errorReport ( '옵션 저장 실패' );
		} else {
			$saved_option = get_option ( 'daworks_chatbot_opt_aws_info' );
			echo json_encode ( [ 'status' => 'success', 'data' => json_decode ( $saved_option ) ] );
			wp_die ();
		}
	}
	
	add_action ( 'wp_ajax_daworks_chatbot_save_page_slug', 'daworks_chatbot_save_page_slug' );
	function daworks_chatbot_save_page_slug () {
		try {
			$slug = $_REQUEST[ 'slug' ];
			
			if ( empty( $slug ) ) {
				throw new Exception( '페이지 슬러그를 입력하세요.' );
			}
			if ( get_option ( 'daworks_chatbot_page_slug' ) ) {
				$result = update_option ( 'daworks_chatbot_page_slug', $slug );
			} else {
				$result = add_option ( 'daworks_chatbot_page_slug', $slug );
			}
			
			if ( ! $result ) {
				throw new Exception( '저장 중 오류 발생. 다시 저장해보세요.' );
			}
			
			echo json_encode ( [ 'status' => 'success' ] );
		}
		catch ( Exception $e ) {
			echo json_encode ( [ 'status' => 'fail', 'message' => $e -> getMessage () ] );
		}
		finally {
			wp_die ();
		}
	}
	
	add_action('wp_enqueue_scripts', 'daworks_chatbot_load_lightbox');
	add_action('admin_enqueue_scripts', 'daworks_chatbot_load_lightbox');
	function daworks_chatbot_load_lightbox()
	{
		wp_enqueue_style( 'lightbox_css',plugin_dir_url ( __DIR__ ) . 'library/lightbox2/css/lightbox.min.css');
		wp_enqueue_script( 'lightbox_js',plugin_dir_url (__DIR__) . 'library/lightbox2/js/lightbox.min.js', array('jquery'), '2.0', true);
	}
	
	add_action('wp_ajax_daworks_chatbot_deletePost', 'daworks_chatbot_deletePost');
	function daworks_chatbot_deletePost()
	{
		try {
			global $wpdb;
			$table = $wpdb->prefix . 'daworks_chatbot';
			$id = null !== $_REQUEST['id'] ? $_REQUEST['id'] : null;
			
			if ( $id == null ) throw new Exception('삭제할 글이 없습니다.');
			
			$query = "SELECT COUNT(*) FROM $table WHERE id = $id";
			$is_exist = $wpdb->get_var($query);
			
			if ( $is_exist > 0 ) {
				// 사진 삭제
				$query = "SELECT * FROM $table WHERE id = $id";
				$row = $wpdb->get_row($query);
				if ( $row->photo_check == 1 ) {
					// 사진이 있으면 삭제
					$photo_url = $row->photo;
					$filename = end(explode('/', $photo_url));
					$upload_dir = wp_upload_dir();
					$filepath = $upload_dir['basedir'] . '/daworks_chatbot/' . $filename;
					
					if ( file_exists ( $filepath) ) {
						unlink($filepath);
					}
				}
				
				$result = $wpdb->delete($table, array('id'=>$id), array('%d'));
				if ( !$result ) throw new Exception('삭제 실패');
				
				echo json_encode(['status' => 'success']);
			}
		
		} catch (Exception $e) {
			echo json_encode([
				'status' => 'fail',
				'error'  => $e->getMessage()
			                 ]);
		}
		finally {
			wp_die();
		}
	}
	
	// 캠페인 제목 저장
	add_action('wp_ajax_daworks_chatbot_save_campaign_title', 'daworks_chatbot_save_campaign_title');
	function daworks_chatbot_save_campaign_title()
	{
		try {
			$title = (null !== $_REQUEST['title']) ? sanitize_text_field ( $_REQUEST['title'] ) : null;
			if ( get_option('daworks_chatbot_campaign_title') ) {
				if ( !update_option('daworks_chatbot_campaign_title', $title) ) throw new Exception('업데이트 실패');
			}
			else {
				if ( !add_option('daworks_chatbot_campaign_title', $title) ) throw new Exception('캠페인 제목 저장 실패');
			}
			
			echo json_encode(['status'=>'success']);
			
		} catch (Exception $e) {
			echo json_encode(['status'=>'fail', 'message'=>$e->getMessage ()]);
		}
		finally {
			wp_die();
		}
	}
	
	add_action('wp_footer', 'fb_script');
	function fb_script()
	{
		?>
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = 'https://connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v2.11&appId=1617805988472516';
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
 <?php
	}