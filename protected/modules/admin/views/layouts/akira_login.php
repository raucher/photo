<!DOCTYPE html>
<!--[if lt IE 7 ]><html lang="en" class="ie6 ielt7 ielt8 ielt9"><![endif]--><!--[if IE 7 ]><html lang="en" class="ie7 ielt8 ielt9"><![endif]--><!--[if IE 8 ]><html lang="en" class="ie8 ielt9"><![endif]--><!--[if IE 9 ]><html lang="en" class="ie9"> <![endif]--><!--[if (gt IE 9)|!(IE)]><!--> 
<html lang="en"><!--<![endif]--> 
	<head>
		<meta charset="utf-8">
		<title>Dashboard - Akira</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?php echo Yii::app()->baseUrl ?>/css/site.css" rel="stylesheet">
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<?php Yii::app()->bootstrap->register(); ?>
	</head>
	<body>
		<div class="container">
			<?php $this->widget('bootstrap.widgets.TbNavbar',array(
							'fixed' => false,
							'fluid' => false,
							'collapse' => true,
							'brand' => 'Admin Area',
						    'htmlOptions' => array('style'=>'margin-bottom:25px;'),
						)); ?>

			<div class="row">
				<?php echo $content; ?>
			</div>
		</div>
	</body>
</html>
