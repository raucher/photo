<?php
$this->breadcrumbs=array(
	'Medias',
);

$this->menu=array(
	array('label'=>'Create Media','url'=>array('create')),
	array('label'=>'Manage Media','url'=>array('admin')),
);
?>

<h1>Medias</h1>

<div class="form-header row-fluid">
<?php 
// TODO: Place this ID generator into controller or helper class
$xUploadId = 'xupload-'.str_shuffle('abcdefghijklmnop');

$this->widget('xupload.XUpload', array(
			'url' => $this->createUrl('xupload'),
			'model' => $xUpload,
			'multiple' => true,
			'attribute' => 'file',
			'htmlOptions' => array('id' => $xUploadId),
		));?>
<hr>
</div> <!-- .form-header -->

<div class="item-index-list row-fluid">
	<ul class="thumbnails admin-media-thumbnails">
		<?php $listView = $this->widget('bootstrap.widgets.TbListView',array(
								'dataProvider'=>$dataProvider,
								'itemView'=>'_view',
								'sortableAttributes' => array(
									'update_time',
								),
							)); ?>
	</ul><!-- .admin-media-thumbnails -->
</div> <!-- .item-index-list -->

<?php // TODO: Move scripts to bundles

$deleteMediaButton = "jQuery(document).on('click', '.delete-media', function(){
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

$updateOnAdd = "jQuery('#{$xUploadId}').bind('fileuploadcompleted', function (e, data) {
							jQuery.fn.yiiListView.update('{$listView->id}')
					});";
$updateOnDelete = "jQuery('#{$xUploadId}').bind('fileuploaddestroyed', function (e, data) {
							jQuery.fn.yiiListView.update('{$listView->id}')
						});";

Yii::app()->clientScript->registerScript('updateMedaListOnUpload', $updateOnAdd, CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('updateMedaListOnDelete', $updateOnDelete, CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('deleteMediaButton', $deleteMediaButton);
?>