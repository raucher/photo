<?php

/**
 * Class AdminLoginForm
 * Login model for admin user
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class AdminLoginForm extends CFormModel
{
	private $_user;
	public $username, $password, $rememberMe;

	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('username, password', 'filter', 'filter'=>'trim'),
			array('password', 'checkPassword'),
			array('rememberMe', 'boolean'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'rememberMe' => 'Remember me next time',
		);
	}

    /**
     * Validators for the password
     *
     * @param $attrs
     * @param $params
     */
    public function checkPassword($attrs, $params)
	{
		if(!$this->hasErrors())
		{
			$this->_user = new SuperUserIdentity($this->username, $this->password);
			$this->_user->authenticate();

			if($this->_user->errorCode === CUserIdentity::ERROR_USERNAME_INVALID)
				$this->addError('username', 'Incorrect username');
			if($this->_user->errorCode === CUserIdentity::ERROR_PASSWORD_INVALID)
				$this->addError('password', 'Incorrect password');
		}
	}

    /**
     * Logs in user and creates role for him if necessary
     *
     * @return bool Whether login process was successful
     */
    public function login()
	{
		if(!isset($this->_user))
			$this->_user = new SuperUserIdentity($this->username, $this->password);
		
		if($this->_user->authenticate())
		{
			$duration = $this->rememberMe ? 60*60*24*3 : 0; // 3 days
			Yii::app()->user->login($this->_user, $duration);
			Yii::app()->user->returnUrl = 'index';
			
			// In case of logged user currently doesn't have a role assigned then assigned it to him
			if( !Yii::app()->authManager->isAssigned(Yii::app()->user->role , Yii::app()->user->id) )
				Yii::app()->authManager->assign(Yii::app()->user->role , Yii::app()->user->id);

			return true;
		}
		return false;
	}
}

?>