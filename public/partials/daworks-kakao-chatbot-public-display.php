<div>
	<?php
		if ( count ( $records ) == 0 ) :
			echo '<p class="text-center">등록된 스토리가 없습니다.</p>';
		else :
			echo '<p class="text-center daworks-chatbot-leading">&quot;'.$total.'개&quot;의 스토리가 있습니다.</p>';
		endif;
	?>
</div>
<div id="daworks-chatbot-wrap">
	<?php
		foreach ( $records as $card )  :
	?>
		 <div class="card" onclick="location.href='<?php printf('%s?mode=show&show_id=%s&current_page=%s', get_permalink(), $card->id, $page) ?>'">
			 <?php
				$now = new DateTime("now", new DateTimeZone("Asia/Seoul"));
				$regist_day = new DateTime($card->created_at, new DateTimeZone("Asia/Seoul"));
				$diff = $now->diff($regist_day);
				if ( $diff->days < 2 ) :
			 ?>
			   <span class="badge">NEW</span>
			 <?php endif ?>
				<div class="picture">
					<img src="<?php echo ($card -> photo_check==1) ? $card -> photo : plugin_dir_url(__DIR__) . '../library/img/noimg.jpg'; ?>" alt="">
				</div>
			 <div class="card-title">
				<?php echo $card -> title ?>
			 </div>
			 <div class="card-content">
				<?php echo $card -> story ?>
			 </div>
			 <div class="card-name">
				 <?php echo $card -> name ?>
				 <span class="card-date">
					 <?php
						  $dt = new DateTime( $card -> created_at, new DateTimeZone("Asia/Seoul") );
						  echo $dt -> format ( 'Y-m-d H:i' );
					  ?>
			</span>
			 </div>
		 </div>
	<?php endforeach ?>
</div>
<div id="daworks-chatbot-pagination">
	<?php print $markup ?>
</div>
