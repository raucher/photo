<?php

/**
 * This is the model class for table "tbl_option".
 *
 * The followings are the available columns in table 'tbl_option':
 * @property string $name
 * @property string $value
 * @property string $type
 */
class Option extends ActiveRecordExt
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Option the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('value', 'type', 'type'=>'string'),
			array('value', 'filter', 'filter'=>'trim'),
			array('value', 'filter', 'filter'=>'strip_tags'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, value, type, category', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Name',
			'value' => 'Value',
			'type' => 'Type',
		);
	}

	/**
	 * Unserializes the option value after model insatnce is created
	 */
	protected function afterFind()
	{
        // TODO: see why serializing is neccessary
		$this->value = unserialize($this->value);
		parent::afterFind();
	}

	/**
	 * Serializes the option value before saving
	 */
	protected function beforeSave()
	{
		$this->value = serialize(CHtml::encode($this->value));
		return parent::beforeSave();
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns option value
	 * @param $name string option name
	 * @param $type string option type. Default 'user'
	 * @return mixed option value
	 */
	static public function getOption($name, $type='user')
	{
		$option = self::model()->findByPk(array(
			'name' => $name,
			'type' => $type,
		));
		if(is_null($option))
			throw new CDbException("Option {$name} doesn't exists!");

		return $option->value;
	}

	/**
	 * Set option value
	 * @param $name string option name
	 * @param $type mixed option value
	 * @param $type string option type. Default 'user'
	 * @return boolean Whether Option model has errors or not
	 */
	static public function setOption($name, $value, $type='user')
	{
		$option = self::model()->findByPk(array(
			'name' => $name,
			'type' => $type,
		));
		
		if(is_null($option))
			$option = new Option;
				
		$option->attributes = array(
			'name'=>$name, 
			'value'=>serialize($value), 
			//'type'=> $option->isNewRecord ? $type : $option->type);
			'type'=> $type);

		if(!$option->save())
			throw new CDbException("Option {$name} couldn't be saved for some reasons!");

		return $option->hasErrors();
	}

	/**
	 * Set system option value. Depends on Option::setOption()
	 * @param $name string option name
	 * @param $value mixed option value
	 * @return boolean whether Option model has errors
	 */
	static public function setSystemOption($name, $value)
	{
		self::setOption($name, $value, 'system');
	}
}