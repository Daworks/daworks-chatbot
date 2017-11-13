<?php
	
	$aws_option = get_option('daworks_chatbot_opt_aws_info');
	
	if ( $aws_option ) {
		$aws = json_decode($aws_option);
	}
	else {
		$aws->key = '';
		$aws->secret = '';
		$aws->bucket= '';
		$aws->region= '';
	}
	
	$campaign_title = ( get_option('daworks_chatbot_campaign_title') ) ? get_option('daworks_chatbot_campaign_title') : '';
	
	$page_slug = get_option('daworks_chatbot_page_slug') ? get_option('daworks_chatbot_page_slug') : '';
?>

<div class="container-fluid">
	<div class="col-sm-12 col-md-10">
		<h3 class="page-title">앱 설정하기</h3>
		<hr>
		<!--
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">AWS S3 버킷 설정</h4>
			</div>
			<div class="panel-body">
				<form id="aws-info" class="form-horizontal">
					<input type="hidden" name="action" value="daworks_chatbot_save_option">
					<div class="form-group">
						<label for="aws-s3-key" class="control-label col-sm-2">AWS S3 Access Key</label>
						<div class="col-sm-10">
							<input type="text" name="aws_s3_key" id="aws_s3_key" class="form-control" value="<?php echo $aws->key ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="aws-s3-secret" class="control-label col-sm-2">AWS S3 Secret</label>
						<div class="col-sm-10">
							<input type="password" name="aws_s3_secret" id="aws_s3_secret" class="form-control" value="<?php echo $aws->secret ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="aws-bucket" class="control-label col-sm-2">AWS 버킷</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="aws_s3_bucket" name="aws_s3_bucket" value="<?php echo $aws->bucket ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="aws-region" class="control-label col-sm-2">AWS 리전</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="aws_s3_region" name="aws_s3_region" value="<?php echo $aws->region ?>">
							<span class="help-block">서울리전 : <code>ap-northeast-2</code></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<button class="btn btn-primary" type="button" id="aws-access-submit">저장</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		-->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">캠페인 제목 설정</h3>
			</div>
			<div class="panel-body">
				<form id="campaign-setting" class="form-horizontal">
					<div class="form-group">
						<label for="campaign_title" class="control-label col-sm-2">캠페인 제목</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="campaign_title" name="campaign_title" value="<?php print $campaign_title ?>" autofocus>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<button class="btn btn-primary" type="button" id="campaign-title-save">저장</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">결과 페이지 설정</h4>
			</div>
			<div class="panel-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="linked_page_slug" class="control-label col-sm-2">결과 표시 페이지</label>
						<div class="col-sm-10">
							<span class="help-block">연결할 페이지의 주소를 입력하세요.</span>
							<input type="text" class="form-control" id="linked_page_slug" name="linked_page_slug" value="<?php echo $page_slug ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<button class="btn btn-primary" type="button" id="savePageinfo">저장</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<img src="<?php echo plugin_dir_url(__DIR__) . '../library/img/plusfriend.png'?>" alt="" width="32" height="32"> 카카오플러스친구 설정방법
				</h3>
			</div>
			<div class="panel-body">
				<p>먼저 카카오플러스친구를 등록한 후 <b>스마트채팅</b>메뉴에서 API형을 선택합니다.</p>
				<p class="text-primary">카카오플러스친구 > 스마트채팅 > API형 사용 : 아래 그림과 같은 화면입니다.</p>
				<p>아래 설치 설명을 참고해서 설정해주세요.</p>
				<div class="alert alert-danger">
					<span class="label label-danger">주의!</span> 결과 표시 페이지를 설정한 후 플러스친구 API 테스트를 진행</strong>하세요.
					연결할 페이지를 설정하지 않으면 API 테스트를 통과할 수 없습니다.
				</div>
				<div class="alert alert-info">
					<strong>플러스친구 관리자센터 바로가기</strong> <a href="https://center-pf.kakao.com/" target="_blank">https://center-pf.kakao.com/</a>
				</div>
				<figure class="thumbnail">
					<img src="<?php echo plugin_dir_url(__FILE__) . '../img/kakao-screenshot.png' ?>" alt="" class="img-responsive">
				</figure>
				<ol>
					<li>[1]번 항목에 사용하실 앱 이름을 등록하세요. 예) 캠페인 챗봇</li>
					<li>
						<p>[2]번 항목에 아래 주소를 입력하신 후 API 테스트 버튼을 클릭해서 <code>"Keyboard Ok"</code> 메시지가 나오는지 확인</p>
						<div class="well well-sm">
							<code><?php echo home_url('wp-json/daworkschatbot/v1') ?></code><br>
						</div>
					</li>
					<li>API 테스트를 통과하지 못하면 앱을 실행할 수 없습니다. <span class="text-danger">챗봇 설정에서 연결할 페이지를 반드시 <u>먼저! 설정한 후</u> 진행하세요.</span></li>
					<li>[3]번 항목에 앱에 대한 설명 입력</li>
					<li>알림 받을 전화번호를 입력하고 인증버튼을 클릭해서 받은 인증 번호를 입력</li>
					<li>설정이 완료되면 API형 저장하기 버튼을 클릭해서 저장합니다.</li>
					<li>스마트 채팅 메뉴에서 API형 <code>시작하기</code>를 클릭!</li>
				</ol>
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">적용방법</h4>
			</div>
			<div class="panel-body">
				<p>
					챗봇 결과는 숏코드로 추가합니다. 페이지 설정에서 입력한 페이지에 아래 Shortcode 를 입력하세요.
				</p>
				<p><code>[daworks-chatbot-view]</code></p>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">문의</h3>
			</div>
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>디자인아레테 홈페이지</dt>
					<dd><a href="https://daworks.io">https://daworks.io</a></dd>
					<dd>다양하게 응용해서 사용할 수 있는 챗봇입니다. 각종 캠페인 및 지원서 접수, 보고서 접수 등 개발 문의는 아래 연락처로 문의주세요.</dd>
				</dl>
				<dl class="dl-horizontal">
					<dt>연락처</dt>
					<dd>카카오 플러스친구로 1:1문의 가능합니다.</dd>
					<dd><a href="http://pf.kakao.com/_PxmwBd">http://pf.kakao.com/_PxmwBd</a></dd>
				</dl>
			</div>
		</div>
		
	</div>
</div>
