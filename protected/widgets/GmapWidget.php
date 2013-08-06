<?php
Yii::import('application.widgets.BasePortlet');
/**
 * Class GmapWidget
 * Portlet to display GoogleMap in sidebars, blocks etc.
 * @uses Option::getOption() Gets address from options
 *
 * @property $_assetUrl string URL of published assets
 * @property $address string Address received from options
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class GmapWidget extends BasePortlet
{
    private $_assetUrl;
    public $address;

    public function init()
    {
        Yii::import('admin.models.Option');
        // TODO: cache option
        $this->address = Option::getOption('address');
        CGoogleApi::register('maps', '3', array(
            'other_params'=>'sensor=false',
        ));

        // Publish assets, register address in custom namespace and fire up scripts
        $this->_assetUrl = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets', false, -1, true);
        $script = "jQuery.gmapWidgetNS={'address':'{$this->address}'};";
        Yii::app()->clientScript->registerScript('gmapWidgetAddress', $script, CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile($this->_assetUrl.'/gmap.js', CClientScript::POS_END);

        parent::init();
    }

    public function renderContent()
    {
        // Form correct address for the static GoogleMap map
        $address = str_replace(array(', ', ' '), array(',', '+'), $this->address);
        $this->render('gmap', array(
            'address'=>$address,
        ));
    }
}