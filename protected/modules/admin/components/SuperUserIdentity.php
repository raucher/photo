<?php

/**
 * Class SuperUserIdentity
 * Implements validation for the admins
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class SuperUserIdentity extends CUserIdentity
{
	private $_id;

    public function __construct($username,$password)
    {
        parent::__construct($username,$password);
        $this->init();
    }

    protected function init()
    {
        $this->attachBehaviors($this->behaviors());
    }

    /**
     * Attaches DemoModeBehavior class
     *
     * @return array Behaviors to attach
     */
    protected function behaviors()
    {
        return array(
            'demoModeBehavior' => array(
                'class' => 'ext.demoMode.DemoModeBehavior',
                'sourceDbFileName' => 'photo.db',
            ),
        );
    }

	public function authenticate()
	{
        if(!$this->demoModeUserLogin())
        {
            $user = User::model()->findByAttributes(array('name' => $this->username));

            if($user === null)
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            else if( $user->password !== crypt($this->password, $user->password) )
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            else
            {
                $this->_id = $user->id;
                $this->setState('role', $user->role);
                $this->errorCode = self::ERROR_NONE;
            }
        }

		return !$this->errorCode;
	}

	public function getId()
    {
        return $this->_id;
    }

	public function setId($value)
    {
        $this->_id = $value;
    }

    /**
     * Generates blowfish salt for password
     *
     * @param int $cost Cost of the blowfish algorithm
     * @return string Salt
     * @throws CHttpException
     */
    static public function getPassSalt($cost = 13)
	{
		if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
	        throw new CHttpException(403, "cost parameter must be between 4 and 31");
	    }
	    $rand = array();
	    for ($i = 0; $i < 8; $i += 1) {
	        $rand[] = pack('S', mt_rand(0, 0xffff));
	    }
	    $rand[] = substr(microtime(), 2, 6);
	    $rand = sha1(implode('', $rand), true);
	    $salt = '$2a$' . sprintf('%02d', $cost) . '$';
	    $salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
	    return $salt;
	}
}