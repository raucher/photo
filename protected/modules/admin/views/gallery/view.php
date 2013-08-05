
<h1>View Gallery #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'translation.title',
		'translation.description',
	),
)); ?>

<div class="item-index-list row-fluid">
	<ul class="thumbnails admin-media-thumbnails">
	<?php $listView = $this->widget('bootstrap.widgets.TbListView', array(
						'dataProvider' => $associatedMedias,
						'itemView' => '/media/_view',
						'viewData' => array('galleryId' => $model->id),
					));?>
	</ul>
</div>
<?php //TODO: Move scripts to bundles 
$removeMediaButton = "jQuery(document).on('click', '.remove-media', function(){
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
Yii::app()->clientScript->registerScript('removeMediaButton', $removeMediaButton, CClientScript::POS_HEAD); ?>