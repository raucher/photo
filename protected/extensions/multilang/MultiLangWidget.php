<?php

/**
 * Class MultiLangWidget
 * Display dropdown language menu
 *
 * @property $langs array Storage for available languages
 *
 * @package Multi Language Support
 * @author raucher <myplace4spam@gmail.com>
 */
class MultiLangWidget extends CWidget
{
    public $langs = array();

    /**
     * Sets the available languages
     */
    public function init(){
        $this->langs = Yii::app()->params->langs;
    }

    /**
     * Runs the view
     */
    public function run()
    {
        $this->render('multiLangWidget', array(
            'langs'=>$this->langs,
        ));
    }
}
