<?php

/**
 * Class PhotoController
 * Main controller for front-end
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class PhotoController extends Controller
{
    public $layout = '//layouts/post_layout';

    /**
     * Defines behaviors
     * @return array
     */
    public function behaviors()
    {
        return array(
            'widgetCollection' => array(
                'class' => 'application.components.WidgetCollectionBehavior',
                'widgetSuffix' => 'Widget',
                'widgetPath' => 'application.widgets',
            ),
            'multiLangBehavior'=>array(
                'class'=>'ext.multilang.MultiLangBehavior',
            ),
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
        $this->render('error', $error);
    }

    /**
     * Defines filters
     * @return array
     */
    public function filters()
    {
        return array(
            'pageTitleRewrite', // Rewrites page title
            array(
                'ext.multilang.MultiLangFilter', // Supports language switching
            ),
            array(
                'ext.demoMode.DemoModeFilter', // Enables demo mode alerts
                'message' => '<strong>You are in demo mode now!</strong>
                             <p>You can see here all changes made by you at the dashboard</p>',
            ),
            array(
                'COutputCache',
                'duration' => 15*60, // 15 minutes
                'varyByParam' => array('lang'),
                'varyByExpression'=>function(){ return Yii::app()->user->id; },
                'dependency' => array(
                    'class' => 'CDbCacheDependency',
                    'sql' => 'SELECT MAX(update_time) FROM (SELECT update_time FROM tbl_gallery
                              UNION SELECT update_time FROM tbl_media
                              UNION SELECT update_time FROM tbl_option)',
                ),
            ),
        );
    }

    /**
     * Customizes the page title
     * @param $fChain CFilterChain
     */
    public function filterPageTitleRewrite($fChain)
    {
        $controllerId = $this->id === 'default' ? '' : $this->id;
        $actionId = $this->action->id === 'index' ? '' : $this->action->id;
        $this->pageTitle = ucwords($controllerId .' '. $actionId);
        $fChain->run();
    }

    /**
     * Default action
     */
    public function actionIndex()
    {
        $this->layout = '//layouts/main';

        $photos = Media::getSliderMedia();

        $this->addWidget('article', array(
            'title'=>'A little about us',
            'icon'=>'pencil',
            'htmlOptions'=>array(
                'class'=>'span6 my-class'
            ),
        ));
        $this->addWidget('Gmap', array(
            'title'=>'Location',
            'icon'=>'pencil',
            'htmlOptions'=>array(
                'class'=>'span6 my-class'
            ),
        ));

        $this->render('index', array(
            'photos' => $photos,
            'mediaUrl' => Yii::app()->homeUrl.'media/',
        ));
    }

    /**
     * Action to display galleries
     * @param string $gall Either id or title of gallery
     */
    public function actionGallery($gall='all')
    {
        $this->subtitle = 'Gallery';
        if($gall === 'all' || !Gallery::model()->exists('id=:ID', array(':ID'=>$gall)))
        {
            $photos = Media::model()->with('translation')->findAll();
        }
        else
        {
            $photos = Gallery::model()
                     ->with('medias.translation')
                     ->findByPk($gall)
                     ->medias;
        }

        $this->render('gallery', array(
            'photos'=>$photos,
            'homeUrl'=>Yii::app()->homeUrl,
        ));
    }

    /**
     * Action to display pages
     * @param $page
     */
    public function actionPage($page){
        $model = $this->getPageModel($page);
        $this->subtitle = $model->translation->title;
        $this->render('page', array('model'=>$model));
    }

    /**
     * Returns Page model depending on id or title
     * @param $article
     * @return CActiveRecord
     */
    private function getPageModel($article){
        if(is_numeric($article))
            $article = Article::model()->with('translation')->findByPk($article);
        else
            $article = Article::model()
                       ->with('translation')
                       ->findByAttributes(array('url'=>$article));
        if(is_null($article))
            throw new CHttpException('404', 'Requested page doesn\'t exists');
        return $article;
    }

    /**
     * Action to display contact page
     */
    public function actionContact()
    {
        $this->addWidget('contact', array('title'=>'Contacts', 'icon'=>'phone'));
        $this->addWidget('gmap', array('title'=>'Google Map', 'icon'=>'home'));

        $model = new ContactForm();
        if(isset($_POST['ContactForm']))
        {
            $model->attributes = $_POST['ContactForm'];
            if($model->validate())
            {
                Yii::app()->user->setFlash('success', 'Thanks, Your message was successfully sent!');
                $this->refresh();
            }
            else
                Yii::app()->user->setFlash('error', 'Sorry, some problems occured while sending!');
        }
        $this->render('contact', array('model' => $model));
    }
}