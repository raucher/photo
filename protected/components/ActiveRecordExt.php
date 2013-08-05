<?php

/**
 * Implements some behaviors and another useful features
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
*/
class ActiveRecordExt extends CActiveRecord
{
	/**
	 * Attachs the CTimestampBehavior and set some of its options
	 * @return array
	 */  
	public function behaviors()
	{
		return array(
			'CTimestampBehavior' => array(
				'class'             => 'zii.behaviors.CTimestampBehavior',
				'setUpdateOnCreate' => true,
			),
		);
	}

    /**
     * Saves the translations for the current model
     * @param array $translations An array of CActiveRecord instances
     * @throws CDbException In case of db errors during saving
     * @return bool Whether all translations have been saved or not
     */
    public function saveTranslations(array $translations, $postVarName)
    {
        $incTransl = Yii::app()->request->getPost($postVarName);
        if(!isset($this->_translForeignKey) && empty($translations) && !is_array($incTransl))
            return false;

        $t = Yii::app()->db->beginTransaction();
        $valid = true;
        try
        {
            // Save or update each translation model
            //  presented in $translations array
            foreach ( $translations as $lang => $langModel )
            {   // If the supported language is given
                if( isset($incTransl[$lang]) )
                {
                    $langModel->attributes = $incTransl[$lang];
                    $langModel->{$this->_translForeignKey} = $this->id;
                    $langModel->lang = $lang;
                    $valid = $langModel->save() && $valid;
                }
            }
            if($valid === true)
                $t->commit();
        }
        catch(Exception $e)
        {
            $t->rollback();
            $valid = false;
            Yii::app()->handleException($e);
        }
        return $valid;
    }
}