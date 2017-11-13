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
		<h3 class="page-title">캠페인 챗봇 설정</h3>
		<hr>
		<p>디자인아레테에서 개발한 캠페인 챗봇을 이용해주셔서 감사합니다.</p>
		<ol>
			<li>챗봇 설정 메뉴에서 설정을 완료하신 후 사용하세요.</li>
			<li>목록 페이지에서 등록된 글을 관리할 수 있습니다.</li>
			<li>설치에 관한 문의는 디자인아레테 플러스친구에서 1:1로 처리해드립니다.</li>
			<li>디자인아레테 플러스친구 : <a href="http://pf.kakao.com/_PxmwBd" target="_blank">http://pf.kakao.com/_PxmwBd</a></li>
			<li>캠페인 챗봇을 다양하게 응용할 수 있습니다. 각종 결과 보고 및 신청서 자동 접수 등 개발 문의 환영합니다.</li>
		</ol>
		<br><br>
		<a href="<?php echo admin_url('admin.php?page=daworks-chatbot-setting') ?>" class="btn btn-primary">플러그인 설정</a>
	</div>
</div>