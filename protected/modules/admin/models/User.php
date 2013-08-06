<?php

/**
 * This is the model class for table "tbl_user".
 *
 * Extends /components/ActiveRecordExt.php
 * 
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $name
 * @property string $role
 * @property string $password
 *
 * The followings are used during the password change proccess
 * @property string $checkCurrentPass
 * @property string $newPass
 * @property string $newPass_repeat
 */
class User extends ActiveRecordExt
{
	public $checkCurrentPass, $newPass, $newPass_repeat;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, role, password', 'safe', 'on'=>'search'),
			// The following rules are used by password change.
			array(
                'checkCurrentPass, newPass, newPass_repeat, name',
                'filter',
                'filter'=>'trim',
                'on'=>'changePass'),
			array('checkCurrentPass', 'required', 'on'=>'changePass'),
			array('name, newPass, newPass_repeat', 'length', 'min'=>5),
			array('newPass', 'compare', 'message'=>'Repeat password exactly', 'on'=>'changePass'),
			array('checkCurrentPass', 'passValidator', 'on' => 'changePass'),
		);
	}

	// Checks current password validity
	public function passValidator($attr=null, $val=null)
	{
		if($this->password !== crypt($this->checkCurrentPass, $this->password))
			$this->addError('checkCurrentPass', 'Current password is incorrect');

		return !$this->hasErrors();
	}

	// Saves new pass
	public function saveNewPass()
	{
		if(!$this->passValidator())
			return false;

        if(!empty($this->newPass))
		    $this->password = crypt($this->newPass, SuperUserIdentity::getPassSalt(9));

		return $this->update(array('password', 'name'));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'role' => 'Role',
			'password' => 'Password',
			// On password change attributes
			'checkCurrentPass' => 'Current Password',
			'newPass' => 'Repeat New Password',
			'newPass_repeat' => 'New Password',
		);
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}