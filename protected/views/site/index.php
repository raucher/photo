<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Congratulations! You have successfully created your Yii application.</p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <code><?php echo __FILE__; ?></code></li>
	<li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
</ul>

<p>For more details on how to further develop this application, please read
the <a href="http://www.yiiframework.com/doc/">documentation</a>.
Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
should you have any questions.</p>

<?php echo Yii::app()->baseUrl ?>
<br>
<?php echo Yii::app()->basePath ?>

<?php /*$this->widget('ext.ckeditor.TheCKEditorWidget', array(
				'name' => 'testEditor',
				'toolbarSet' => 'Full',
				'ckeditor' => Yii::app()->basePath.'/../js/ckeditor3/ckeditor.php',
				'ckBasePath' => Yii::app()->baseUrl.'/js/ckeditor3/',
			));*/
?>

<?php $this->widget('ext.imperaviRedactor.ImperaviRedactorWidget', array(
			// можно использовать пару имя модели - имя свойства
			'model' => Media::model(),
			'attribute' => '[my]src',

			// или только имя поля ввода
			//'name' => 'testInput',

			// немного опций, см. http://imperavi.com/redactor/docs/
			'options' => array(
				'lang' => 'lv',
				'imageUpload' => '/image_upload.php',
			),
		));
?>

ckfinder_gecko.js Line:43 Col:4763
