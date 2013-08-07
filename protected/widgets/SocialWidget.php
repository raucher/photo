<?php
/**
 * Class SocialWidget
 * Widget to display social networks
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class SocialWidget extends CWidget
{
    public $htmlOptions = array();

    public function run()
    {
        Yii::import('admin.models.Option');
        $this->render('social');
    }
}