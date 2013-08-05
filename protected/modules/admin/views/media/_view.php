<li class="span3 <?php echo ($index%4 == 0) ? 'first-inrow' : ''; ?>">
	<div class="thumbnail">
		<span class="title"><?php echo basename($data->src); ?></span>
	<?php if($this->id === 'media'): // If view runs under the MediaController ?> 
		<a class="delete-media btn btn-mini btn-danger pull-right" href="<?php echo $this->createUrl('media/delete', array('id'=>$data->id)) ?>">
			&times;
		</a>
	<?php elseif($this->id === 'gallery'): // Or under the GalleryController ?>
		<a class="delete-media btn btn-mini btn-danger pull-right" href="<?php echo $this->createUrl('gallery/removemedia', array('galleryId'=>$galleryId, 'mediaId'=>$data->id)) ?>">
			&times;
		</a>
	<?php endif; ?>
		<a href="<?php echo $this->createUrl('media/update', array('id'=>$data->id)) ?>">
			<img style="margin-top:5px" src="<?php echo Yii::app()->baseUrl.'/media/'.$data->src; ?>">
		</a>
	</div>
</li>