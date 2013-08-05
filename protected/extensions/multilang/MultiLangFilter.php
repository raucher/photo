<?php

/**
 * Class MultiLangFilter
 *
 * Filter to process language parameter
 *
 * @package Multi Language Support
 * @author raucher <myplace4spam@gmail.com>
 */
class MultiLangFilter extends CFilter
{
    /**
     * @param CFilterChain $filterChain
     * @return bool
     */
    public function preFilter($filterChain)
    {
        $langs = Yii::app()->params->langs;
        $cookies = Yii::app()->request->getCookies();

        $queryLang = Yii::app()->request->getQuery('lang');
        $valid = in_array($queryLang, $langs);

        if((!isset($queryLang) || !$valid) && Yii::app()->controller->action->id !== 'error')
        {
            if(isset($cookies['lang']) && in_array($cookies['lang']->value, $langs))
                $lang = $cookies['lang']->value;
            else // Set default language
                $lang = Option::getOption('default_language', 'system');

            $url = Yii::app()->controller->createUrl('',array('lang' => $lang));
            Yii::app()->request->redirect($url);
        }

        // If new language is chosen
        if($queryLang !== Yii::app()->getLanguage() && $valid)
        {
            Yii::app()->setLanguage($queryLang);
            $cookies['lang'] = new CHttpCookie('lang', $queryLang, array(
                'expire' => time()+60*60*24, // 24 hours
            ));
        }

        return parent::preFilter($filterChain);
    }
}