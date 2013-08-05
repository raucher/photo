<?php

/**
 * Class DemoModeDbConnection
 * Changes db connection according to user's id and cdn
 *
 * @package demo-mode extension
 * @author raucher <myplace4spam@gmail.com>
 */
class DemoModeDbConnection extends CDbConnection
{
    public $demoUserId = 'demo_mode_user';
    public function init()
    {
       if(Yii::app()->user->id === $this->demoUserId && Yii::app()->user->hasState('cdn'))
        {
            $this->setActive(false); // Disable current connection
            $this->connectionString = Yii::app()->user->getState('cdn'); // And change cdn
        }
        parent::init(); // init() in super class activates connection again
    }
}