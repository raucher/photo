<?php

/**
 * Class MultiLangAR
 * Super class for translation tables
 *
 * @package Multi Language Support
 * @author raucher <myplace4spam@gmail.com>
 */
class MultiLangAR extends CActiveRecord
{
    /**
     * Default scope which helps us to avoid language selection in each query
     * @return array
     */
    public function defaultScope()
    {
        $module = Yii::app()->controller->module->id;
        return array(
            // We don't need this in admin module
            'condition' => $module==='admin' ? '' : "lang='".Yii::app()->language."'",
        );
    }

    /**
     * Selects desirable language despite the default scope
     * @param $lang string Desirable language
     * @return $this CActiveRecord
     */
    public function forceLanguageScope($lang)
    {
        // We have to merge conditions by OR here
        //  because by default they are concatenated by AND statement,
        //  that isn't right in our case
        $this->getDbCriteria()->mergeWith(array(
            'condition' => "lang=:lang",
            'params'=>array(':lang'=>$lang),
        ), 'OR');
        return $this;
    }
}