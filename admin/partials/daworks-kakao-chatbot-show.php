<div class="container-fluid" id="daworks-chatbot-wrap">
	<div class="col-sm-12 col-md-10">
		<h3 class="page-title">캠페인 내용보기</h3>
		<hr>
		<h4 class="page-title">
		  <?php echo $result->title?>
			<small class="pull-right">
				<ul class="list-inline">
					<li class="name"><?php echo $result->name ?></li>
					<li class="date"><?php echo $result->created_at ?></li>
				</ul>
			</small>
		</h4>
		<div class="entry-content">
		<?php if ( (int) $result->photo_check == 1) : ?>
			<picture class="thumbnail">
				<img src="<?php echo $result->photo; ?>" alt="" class="img-responsive center-block">
			</picture>
		<?php endif ?>
			<?php echo $result->story ?>
			<div class="clearfix"></div>
			<hr>
			<script>console.log(pagenow)</script>
			<a href="<?php echo admin_url('admin.php?page=daworks-chatbot-result&current_page='.$current_page.'&mode=list') ?>" class="btn btn-default">목록으로</a>
			<a href="javascript:;" class="btn btn-danger" onclick="if(confirm('삭제할까요?')) {deletePost(<?php echo $result->id?>)};redirectToList(<?php echo $current_page?>);">이 글 삭제</a>
			<div class="pull-right">
				<?php if ( $prev_id ) : ?>
				<a href="<?php echo admin_url('admin.php?page=daworks-chatbot-result&current_page='.$current_page.'&mode=show&show_id='.$prev_id) ?>" class="btn btn-default">이전 글</a>
				<?php endif ?>
				<?php if ( $next_id ) : ?>
				<a href="<?php echo admin_url('admin.php?page=daworks-chatbot-result&current_page='.$current_page.'&mode=show&show_id='.$next_id) ?>" class="btn btn-default">다음 글</a>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>
