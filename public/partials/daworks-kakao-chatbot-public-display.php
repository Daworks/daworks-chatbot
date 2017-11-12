<div class="container">
	<?php
		if ( count ( $records ) == 0 ) :
			echo '<p class="text-center">등록된 스토리가 없습니다.</p>';
		else :
			echo '<p class="text-center">'.$total.'개의 글이 등록되었습니다</p>';
		endif;
	?>
</div>
<div class="container" id="daworks-chatbot-wrap">
	<?php
		foreach ( $records as $card )  :
	?>
		 <div class="card">
				 <?php if ( $card -> photo_check == 1 ) : ?>
				<picture>
					<a href="<?php echo $card -> photo ?>" data-lightbox="daworks-chatbot-show">
						<img src="<?php echo $card -> photo ?>" alt="" class="img-responsive">
					</a>
				</picture>
				 <?php endif ?>
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
								  $dt = new DateTime( $card -> created_at );
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
