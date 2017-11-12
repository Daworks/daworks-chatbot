<?php
	
	/**
	 * Provide a admin area view for the plugin
	 *
	 * This file is used to markup the admin-facing aspects of the plugin.
	 *
	 * @link       https://daworks.io
	 * @since      1.0.0
	 *
	 * @package    Daworks_Kakao_Chatbot
	 * @subpackage Daworks_Kakao_Chatbot/admin/partials
	 */
	$app_key    = "";
	$app_secret = "";
	
	if ( get_option ( 'daworks_chatbot_app_key', false ) ) {
		$app_key = get_option ( 'daworks_chatbot_app_key', false );
	}
	
	if ( get_option ( 'daworks_chatbot_app_secret', false ) ) {
		$app_secret = get_option ( 'daworks_chatbot_app_secret', false );
	}

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="container-fluid">
	<div class="col-sm-12 col-md-10 col-lg-10">
		<h3 class="page-title">Daworks 카카오 챗봇 설정</h3>
		<hr>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					설치방법
				</h3>
			</div>
			<div class="panel-body">
				<p class="text-primary">카카오플러스친구 > 스마트채팅 > API형 사용 : 아래 그림과 같은 화면입니다.</p>
				<figure class="thumbnail">
					<img src="<?php echo plugin_dir_url(__FILE__) . '../img/kakao-screenshot.png' ?>" alt="" class="img-responsive">
				</figure>
				<ol>
					<li>[1]번 항목에 사용하실 앱 이름을 등록하세요. 예) 캠페인 챗봇</li>
					<li>
						<span class="help-block">
							[2]번 항목에 아래 주소를 입력하신 후 API 테스트 버튼을 클릭해서 "Keyboard Ok" 메시지가 나오는지 확인
						</span>
						<div class="well well-sm">
							<code><?php echo home_url('wp-json/daworkschatbot/v1') ?></code><br>
						</div>
					</li>
					<li>API 테스트를 통과하지 못하면 앱을 실행할 수 없습니다.</li>
					<li>[3]번 항목에 앱에 대한 설명 입력</li>
					<li>알림 받을 전화번호를 입력하고 인증버튼을 클릭해서 받은 인증 번호를 입력</li>
					<li>설정이 완료되면 API형 저장하기 버튼을 클릭해서 저장합니다.</li>
				</ol>
			</div>
		</div>
		<a href="<?php echo admin_url('admin.php?page=daworks-chatbot-setting') ?>" class="btn btn-primary">플러그인 설정</a>
	</div>
</div>