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
                'class' => 'admin.components.DemoModeBehavior',
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

    /*protected function demoModeUserLogin()
    {
        if($this->username !== 'demo' && $this->password !== 'demo')
            return false;

        $this->_id = 'demo_mode_user';

        $path = $this->createTempDbFile();

        $this->setState('cdn', 'sqlite:'.$path);
        $this->setState('demoDbPath', $path);
        $this->setState('role', 'admin');

        return !$this->errorCode = self::ERROR_NONE;
    }

    public function createTempDbFile($alias = 'application.runtime.demo_mode_db')
    {
        if(($path = Yii::getPathOfAlias($alias)) === false)
            throw new CHttpException(409, 'Method expects parameter to be a valid path alias');

        $path = Yii::getPathOfAlias($alias);

        // Delete old db files
        $this->clearDemoModeDirectory($path);

        // Create directory to store demo-mode databases and name it by current time in 'd-m-Y' format
        if(!(is_dir($dir = $path.DIRECTORY_SEPARATOR.date('d-m-Y')) || mkdir($dir, 0777, true)))
            throw new CHttpException(409, 'Can\'t create directory');

        // Create cloned database for user loged in demo-mode with unique suffix to avoid collisions
        $dbFileName = sprintf('demo_mode_user_%s.db', uniqid(rand()));
        $dbSourceFile = Yii::getPathOfAlias('application.data').DIRECTORY_SEPARATOR.'photo.db';
        $dbClonedFile = $dir.DIRECTORY_SEPARATOR.$dbFileName;
        if(!copy($dbSourceFile, $dbClonedFile))
            throw new CHttpException(409, 'Can\'t copy db file');

        return $dbClonedFile; // Return path to newly created db file for further use in cdn
    }

    public function clearDemoModeDirectory($path)
    {
        if(!is_dir($path))
            return false;

        foreach (scandir($path) as $el) {
            // Delete all files within a directory
            if(is_file($deleteMe = $path.DIRECTORY_SEPARATOR.$el))
                $ret = unlink($deleteMe);

            // If current element is a directory
            //  and it's name represents time 2 days later than today
            //  remove it and all files within
            else if( is_dir($deleteMe) && (strtotime($el) < strtotime('-2 days')) )
            {
                $this->clearDemoModeDirectory($deleteMe);
                $ret = rmdir($deleteMe);
            }
        }
        return $ret;
    }*/
}