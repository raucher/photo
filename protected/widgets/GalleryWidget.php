<?php
/**
 * Class GalleryWidget
 * Widget to display dropdown gallery menu
 *
 * @property $__galleries array All available Gallery classes
 * @property $__activeGallery Gallery Currently active gallery
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class GalleryWidget extends CWidget
{
    private $_galleries;
    private $_activeGallery;

    public function init()
    {   // TODO: implement translations for galleries
        $this->_galleries = Gallery::model()->with('translation')->findAll();
        // GET['gall'] parameter passed to the action
        $gall = Yii::app()->request->getQuery('gall');
        // If queried gallery exists then return it else show all galleries
        if(($this->_activeGallery = Gallery::model()->with('translation')->findByPk($gall)) === null)
            $this->_activeGallery = 'All';

    }

    public function run()
    {
        $this->render('gallery', array(
            'galleries'=>$this->_galleries,
            'activeGallery'=>$this->_activeGallery,
        ));
    }

}