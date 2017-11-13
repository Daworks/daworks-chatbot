<?php
	
	$aws_option = get_option('daworks_chatbot_opt_aws_info');
	$page_slug = get_option('daworks_chatbot_page_slug') ? get_option('daworks_chatbot_page_slug') : '';
	
	if ( $aws_option ) {
		$aws = json_decode($aws_option);
	}
	else {
		$aws->key = '';
		$aws->secret = '';
		$aws->bucket= '';
		$aws->region= '';
	}
	
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
				<h4 class="panel-title">페이지 설정</h4>
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
