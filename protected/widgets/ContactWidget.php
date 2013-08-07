<?php
Yii::import('application.widgets.BasePortlet');
/**
 * Class ContactWidget
 * Portlet to display contacts in sidebars, blocks etc.
 *
 * @property $_data Option ActiveRecord Option model
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class ContactWidget extends BasePortlet
{
    protected $_data = array();
    public function init()
    {
        Yii::import('admin.models.Option');
        $this->_data = Option::model()->findAllByAttributes(array(
            'category' => 'info',
            'specific' => 'address',
        ));
        parent::init();
    }

    public function renderContent()
    {
        $this->render('contact', array(
            'options' => $this->_data,
        ));
    }
}