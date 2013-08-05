<?php

/**
 * Class MultiLangBehavior
 * Stores several wrappers and commonly used as helper
 *
 * @package Multi Language Support
 * @author raucher <myplace4spam@gmail.com>
 */

class MultiLangBehavior extends CBehavior
{
    /**
     * Wrapper for CController::createUrl()
     *
     * @param $route
     * @param array $params
     * @param string $ampersand
     * @return string The constructed URL
     */
    public function multiLangUrl($route, array $params=array(), $ampersand='&')
    {
        if(!isset($params['lang'])) $params['lang'] = Yii::app()->language;
        return $this->owner->createUrl($route, $params, $ampersand);
    }
}