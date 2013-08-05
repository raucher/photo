<?php
$this->breadcrumbs=array(
	'Articles',
);

$this->menu=array(
	array('label'=>'Create Article','url'=>array('create')),
	array('label'=>'Manage Article','url'=>array('admin')),
);
?>

<h1>Articles</h1>
<a class="btn btn-success btn-large" href="<?php echo $this->createUrl('article/create'); ?>">
	Create Article
</a>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'type' => 'striped',
	'dataProvider'=>$dataProvider,
	'columns'      => array(
		array('name'=>'id', 'header'=>'#'),
		array('name'=>'url', 'header'=>'URL'),
		//array('name'=>'description', 'value'=>'mb_substr($data->description, 0, 75)." ..."'),
		//array('header'=>'Medias', 'value'=>'count($data->medias)'),
		array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
	),
)); ?>
