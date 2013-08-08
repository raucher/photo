<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<meta name="language" content="en" />
    <?php $homeUrl = Yii::app()->homeUrl ?>

    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo $homeUrl ?>font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->
    <!--[if gte IE 9]>
    <style type="text/css">
        .gradient {
            filter: none;
        }
    </style>
    <![endif]-->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php // Register TBootstrap and additional CSS which overwrites some TBootstrap styles
        Yii::app()->bootstrap->register();
        Yii::app()->clientScript->registerCssFile($homeUrl.'font-awesome/css/font-awesome.css');
        Yii::app()->clientScript->registerCssFile($homeUrl.'css/user-style.css'); ?>
</head>

<body>

<div id="wrapper">
    <!-- HEADER -->
    <?php // Display demo-mode alert
    $this->widget('bootstrap.widgets.TbAlert', array(
        'id'=>'demo-alert',
        'alerts'=>array( // configurations per alert type
            'demo'=>array('block'=>true, 'fade'=>false, 'closeText'=>false),
        ),
        'htmlOptions'=>array(
            'class'=>'text-center',
        ),
    )); ?>
    <div id="header">
        <div class="container">
            <div class="row-fluid">
                <div id="lang-selector" class="span1">
                    <?php $this->widget('ext.multilang.MultiLangWidget') ?>
                </div>
                <!--<div id="main-logo" class="text-center span4">-->
                <div id="main-logo" class="text-center pull-left">
                    <?php $siteName = explode(' ', Option::getOption('sitename'), 2) ?>
                    <?php printf('<h3><a href="%s"><span class="olive">%s</span> %s</a></h3>',
                            $this->multiLangUrl('/photo/index'), $siteName[0], $siteName[1]); ?>
                </div> <!-- #main-logo -->
            <!-- start: NAV MENU -->
                <?php // multiLangUrl() is used to render correct url with default $lang parameter
                    $this->widget('zii.widgets.CMenu', array(
                        'id'=>'main-nav-menu',
                        'items' => array(
                            array(
                                'label'=>'Home',
                                'url'=>$this->multiLangUrl('/photo/index'),
                            ),
                            array(
                                'label'=>'Gallery',
                                'url'=>$this->multiLangUrl('/photo/gallery'),
                            ),
                            array(
                                'label'=>'About',
                                'url'=>$this->multiLangUrl('/photo/page', array(
                                    'page'=>'about',
                                )),
                            ),
                            array(
                                'label'=>'Contact',
                                'url'=>$this->multiLangUrl('/photo/contact'),
                            ),
                        ),
                        'htmlOptions' => array(
                            'class'=>'nav-menu inline text-center pull-right',
                        ),
                    )); ?>
            <!-- end: NAV MENU -->
            </div> <!-- .row-fluid -->
        </div><!-- .container -->
    </div> <!-- #header -->
<?php if(isset($this->subtitle)): ?>
    <!-- PAGE SUBTITLE -->
    <div id="page-subtitle" class="dark-grey-gradient">
        <h3 class="container"><?php echo $this->subtitle ?></h3>
        <?php if($this->action->id === 'gallery') $this->widget('application.widgets.GalleryWidget') ?>
    </div> <!-- #page-subtitle.dark-grey-gradient -->
<?php endif ?>

	<?php echo $content; ?>

</div><!--#wrapper -->

<!-- FOOTER -->
<div id="footer">
    <div class="container">
        <div class="row-fluid">
            <!-- start: NAV MENU -->
            <?php // multiLangUrl() is used to render correct url with default $lang parameter
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label'=>'Home',
                            'url'=>$this->multiLangUrl('/photo/index'),
                        ),
                        array(
                            'label'=>'Gallery',
                            'url'=>$this->multiLangUrl('/photo/gallery'),
                        ),
                        array(
                            'label'=>'Contact',
                            'url'=>$this->multiLangUrl('/photo/contact'),
                        ),
                    ),
                    'htmlOptions' => array(
                        'class'=>'nav-menu text-center inline pull-left',
                    ),
                )); ?>
            <?php $this->widget('application.widgets.SocialWidget', array(
                'htmlOptions'=>array(
                    'class'=>'inline text-center pull-right',
                ),
            ));
            ?>
        </div><!-- .row-fluid -->
    </div><!-- .container -->
</div> <!-- #footer -->


</body>
</html>
