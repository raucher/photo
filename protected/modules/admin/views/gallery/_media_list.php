<li class="span3 <?php echo ($index%4 == 0) ? 'first-inrow' : ''; ?>">
	<div class="thumbnail">
		<div style="margin-bottom:6px">
			<input type="checkbox" name="Medias[]" value="<?php echo $data->id ?>">
            <span class="title pull-right" ><?php echo basename($data->src) ?></span>
		</div>
		<img src="<?php echo Yii::app()->baseUrl.'/media/'.$data->src; ?>">
	</div>
</li>