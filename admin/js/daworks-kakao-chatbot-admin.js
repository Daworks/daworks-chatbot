(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(function(){

		// aws 정보 추가
		$('#aws-access-submit').click(function(){
			var button = $(this);
			if ( $('#aws_s3_key').val() == '' ) {
				alert('s3-key를 입력하세요.');
				$(this).addClass('has-error').focus();
				return false;
			}

			if ( $('#aws_s3_secret').val() == '' ) {
				alert('s3-secret을 입력하세요.');
				$(this).addClass('has-error').focus();
				return false;
			}

			if ( $('#aws_s3_bucket').val() == '' ) {
				alert('버킷명을 입력하세요.');
				$(this).addClass('has-error').focus();
				return false;
			}

			if ( $('#aws_s3_region').val() == '' ) {
				alert('리전을 입력하세요.');
				$(this).addClass('has-error').focus();
				return false;
			}

			var data = $('#aws-info').serializeArray();
			$.post(ajaxurl, data, function(response){
				var rtn = $.parseJSON(response);
				if ( rtn.status === 'fail' ) {
					alert(rtn.message);
				}
				else {
					$('#aws_s3_key').val(rtn.data.key);
					$('#aws_s3_secret').val(rtn.data.secret);
					$('#aws_s3_bucket').val(rtn.data.bucket);
					$('#aws_s3_region').val(rtn.data.region);
					button.removeClass('btn-primary').addClass('btn-success').text('저장되었습니다.');
					button.prop('disabled', 'disabled');
				}
			});
		});

		// 연결 페이지 저장
		$('#savePageinfo').click(function(){
			var src = $('#linked_page_slug'),
					button = $(this);

			if ( src.val() == '' ) {
				alert('연결 페이지를 입력하세요.');
				$(this).focus();
				return false;
			}

			var data = {action:'daworks_chatbot_save_page_slug', slug: src.val()};
			$.post(ajaxurl, data, function(response){

				var rtn = $.parseJSON(response);
				if ( rtn.status === 'success' ) {
					button.removeClass('btn-primary').addClass('btn-success');
					button.text('저장되었습니다.');
				}
				else {
					alert('오류 발생 : '+ rtn.message);
				}
			} );
		});

		// 레코드 삭제
		window.deletePost = function (id)
		{
			var data = {action:'daworks_chatbot_deletePost', id:id};
			$.post(ajaxurl, data, function(response){
				var rtn = $.parseJSON(response);
				if ( rtn.status == 'fail' )
				{
					alert(rtn.error);
					return false;
				}
				else {
					$('#post-'+id).remove();
				}
			});
		}

		// 전체 체크
		$('#checkall').click(function(){
			if ( $(this).is(':checked') ) {
				$('input[type="checkbox"]:not(#checkall)').prop('checked', true);
			}
			else {
				$('input[type="checkbox"]:not(#checkall)').prop('checked', false);
			}
		});

		window.deleteCheckedItems = function(){
			if ( confirm('체크한 항목을 삭제하시겠습니까?') ) {
				var table = $('#daworks-chatbot-list-table tbody tr');

				$.each(table, function(){
					var id = $(this).find('input[type="checkbox"]');
					if ( id.is(':checked') ) {
						deletePost(id.val());
					}
				});
			}
			else {
				return false;
			}
		}

		$('#deleteCheckedItems').click(function(){
			deleteCheckedItems();
			location.reload();
		});

	}); //

})( jQuery );
