<div class="container-fluid" id="daworks-chatbot-wrap">
	<div class="col-sm-12 col-md-10">
		<h3 class="page-title">캠페인 목록</h3>
		<hr>
		<p class="pull-left">총 <?php echo $total ?>개의 글이 있습니다.</p>
		<a href="javascript:;" class="btn btn-danger pull-right" id="deleteCheckedItems">선택한 항목 삭제</a>
		<table class="table table-striped" id="daworks-chatbot-list-table">
			<thead>
			<tr>
				<th width="30" class="text-center"><input type="checkbox" id="checkall"></th>
				<th width="150" class="text-center">사진</th>
				<th width="120" class="text-center">이름</th>
				<th>제목 / 내용</th>
				<th width="150" class="text-center">등록일</th>
				<th width="40"></th>
			</tr>
			</thead>
			<tbody>
			<?php if ( count($result) === 0 ) : ?>
				<tr>
					<td colspan="6" class="text-center">등록된 글이 없습니다.</td>
				</tr>
			<?php endif ?>
			<?php foreach($result as $item) : ?>
			  <tr id="post-<?php echo $item->id?>">
				  <td class="text-center"><input type="checkbox" name="id[]" value="<?php echo $item->id ?>"></td>
				  <td class="text-center">
					  <?php if ( $item->photo !== 'none' ) : ?>
						  <a href="<?php echo $item->photo ?>" data-lightbox="daworks-chatbot">
							  <picture style="background-image:url(<?php echo $item->photo ?>)">
							  </picture>
						  </a>
					  <?php else : ?>
					    사진 없음
					  <?php endif ?>
				  </td>
				  <td class="text-center"><?php echo $item->name ?></td>
				  <td>
					  <a href="<?php echo admin_url('admin.php?page=daworks-chatbot-result&current_page='.$page.'&mode=show&show_id=' . $item->id)?>">
						  <p>
						    <?php echo $item->title ?><br>
							  <?php
								  if ( mb_strlen($item->story) > 50 ) {
									  echo mb_substr($item->story, 0, 50) . '...';
								  }
								  else {
									  echo sanitize_text_field ( $item->story );
								  }
							  ?>
						  </p>
					  </a>
				  </td>
				  <td class="text-center"><?php echo $item->created_at ?></td>
				  <td>
					  <a href="javascript:;" class="btn btn-link" onclick="deletePost(<?php echo $item->id ?>)">삭제</a>
				  </td>
			  </tr>
			<?php endforeach ?>
			</tbody>
		</table>
		<div class="text-center">
			<?php echo $pagination->parse(); ?>
		</div>
	</div>
</div>
