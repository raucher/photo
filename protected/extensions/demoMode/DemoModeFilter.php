<?php
/**
 * Class DemoModeFilter
 * Enables a warning message that the user is currently in demo-mode
 *
 * @property $demoUserId string User id in demo mode
 * @property $message string Message to show in demo mode alert
 * @property $messageType string Must be specified in 'alerts' property
 * of {@link http://www.cniska.net/yii-bootstrap/#tbAlert TbAlert} widget in the case of using it
 *
 * @package demo-mode extension
 * @author raucher <myplace4spam@gmail.com>
 */

class DemoModeFilter extends CFilter
{
    public $demoUserId = 'demo_mode_user';
    public $message = '<strong>You are in demo mode now! You are able to manage site through the dashboard until you are log out</strong>
                       <p>All changes which you are made will also appears on front-end</p>';
    public $messageType = 'demo';

    public function preFilter($cChain)
    {
        if(Yii::app()->user->id === $this->demoUserId)
            Yii::app()->user->setFlash($this->messageType, $this->message);

        return true;
    }
}