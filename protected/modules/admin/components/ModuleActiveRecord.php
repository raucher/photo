<?php

/**
 * Class DemoModeDbConnection
 * Super class for some models
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
}

?>