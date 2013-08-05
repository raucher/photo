<!DOCTYPE html>
<!--[if lt IE 7 ]><html lang="en" class="ie6 ielt7 ielt8 ielt9"><![endif]--><!--[if IE 7 ]><html lang="en" class="ie7 ielt8 ielt9"><![endif]--><!--[if IE 8 ]><html lang="en" class="ie8 ielt9"><![endif]--><!--[if IE 9 ]><html lang="en" class="ie9"> <![endif]--><!--[if (gt IE 9)|!(IE)]><!--> 
<html lang="en"><!--<![endif]--> 
	<head>
		<meta charset="utf-8">
		<title>Dashboard - <?php echo CHtml::encode($this->pageTitle) ?> | <?php echo CHtml::encode(Yii::app()->name) ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?php echo Yii::app()->baseUrl ?>/css/site.css" rel="stylesheet">
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<?php Yii::app()->bootstrap->register(); ?>
	</head>
	<body>
		<div class="container">
            <?php // Display demo-mode alert
                $this->widget('bootstrap.widgets.TbAlert', array(
                    'id'=>'demo-alert',
                    'alerts'=>array( // configurations per alert type
                        'demo'=>array('block'=>true, 'fade'=>true, 'closeText'=>false),
                    ),
                    'htmlOptions'=>array(
                        'class'=>'text-center',
                    ),
                )); ?>
			<?php $this->widget('bootstrap.widgets.TbNavbar',array(
							'fixed' => false,
							'fluid' => false,
							'collapse' => true,
							'brand' => 'Dashboard',
                            'brandUrl' => Yii::app()->createUrl('/admin/index'),
						    'items'=>array(
						        array(
						            'class'=>'bootstrap.widgets.TbMenu',
						            'items'=>array(
						                array('label'=>'View site', 'url'=>array('/index')),
						            ),
						        ),
						        array(
									'class'       => 'bootstrap.widgets.TbMenu',
									'htmlOptions' => array('class'=>'pull-right'),
									'items'       => array(
										array('label'=>'Login', 'icon'=>'off', 'url'=>array('/admin/default/login'), 'visible'=>Yii::app()->user->isGuest),
						                array('label'=>'Logout ('.Yii::app()->user->name.')', 'icon'=>'off', 'url'=>array('/admin/default/logout'), 'visible'=>!Yii::app()->user->isGuest),
									)
						        ),
						    ),
						    'htmlOptions' => array('style'=>'margin-bottom:25px;'),
						)); ?>

			<div class="row">
				<div class="span3">
					<div class="well" style="padding: 8px 0;">
						<?php $this->widget('bootstrap.wisgets.TbMenu', array(
								'type'  => 'list',
								'items' => array(
									array('label'=>'ITEMS'),
									array('label'=>'Medias', 'icon'=>'camera', 'url'=>array('/admin/media/index') ),
									array('label'=>'Galleries', 'icon'=>'th', 'url'=>array('/admin/gallery/index') ),
									array('label'=>'Articles', 'icon'=>'book', 'url'=>array('/admin/article/index') ),
									array('label'=>'CONFIGURATION'),
									array('label'=>'Options', 'icon'=>'cog', 'url'=>array('/admin/default/options') ),
									array(
                                        'label'=>'Change Password',
                                        'icon'=>'lock',
                                        'url'=>array('/admin/default/newpass'),
                                        'visible'=> Yii::app()->user->id !== 'demo_mode_id',
                                    ),
								),
						)); ?>
					</div>
				</div>
				<div class="span9">
					<?php $this->widget('bootstrap.widgets.TbAlert', array(
				        'block'=>true, // display a larger alert block?
				        'fade'=>true, // use transitions?
				        'closeText'=>'&times;', /* close link text - if set to false, no close link is displayed*/)); ?>
					<?php echo $content; ?>
				</div>
			</div>
		</div>
	</body>
</html>