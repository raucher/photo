
<h1>Update Gallery <?php echo $model->id; ?></h1>

<a class="btn btn-success btn-large" href="<?php echo $this->createUrl('gallery/addmedia', array('id'=>$model->id)); ?>">
	Add Media
</a>

<?php echo $this->renderPartial('_form',array('model'=>$model, 'translations'=>$translations)); ?>

<div class="item-index-list row-fluid">
	<ul class="thumbnails admin-media-thumbnails">
	<?php $listView = $this->widget('bootstrap.widgets.TbListView', array(
						'dataProvider' => $associatedMedias,
						'itemView' => '/media/_view',
						'viewData' => array('galleryId' => $model->id),
					));?>
	</ul>
</div>

<?php
$removeMediaButton = "jQuery(document).on('click', '.delete-media', function(){
							jQuery.ajax({
								'url': this.href,
								'type': 'POST',
								'dataType': 'json',
								'success': function(data){
									jQuery.fn.yiiListView.update('{$listView->id}');
								}
							});
							return false;
						});";
Yii::app()->clientScript->registerScript('removeMediaButton', $removeMediaButton);?>