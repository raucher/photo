<?php
$this->breadcrumbs=array(
	'Galleries',
);

$this->menu=array(
	array('label'=>'Create Gallery','url'=>array('create')),
	array('label'=>'Manage Gallery','url'=>array('admin')),
);
?>

<h1>Galleries</h1>
<a class="btn btn-success btn-large" href="<?php echo $this->createUrl('gallery/create'); ?>">
	Create Gallery
</a>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'type'         => 'striped',
	'dataProvider' => $dataProvider,
	'columns'      => array(
		array('name'=>'id', 'header'=>'#'),
		array('header'=>'Title', 'value'=>'$data->translation->title'),
		//array('name'=>'translation.title', 'header'=>'Title'),
		//array('name'=>'translation.description', 'value'=>'mb_substr($data->description, 0, 75)." ..."'),
		array('header'=>'Medias', 'value'=>'count($data->medias)'),
		array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
	),
)); ?>
