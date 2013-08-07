<?php

/**
 * Class DemoModeBehavior
 * Implements functionality for demo mode.
 * Expects that application uses SQLite as DBMS
 *
 * @property $demoUserId string User ID in demo mode
 * @property $demoUserRole string User role in demo mode
 * @property $demoUserLogin string Login to get into the demo mode
 * @property $demoUserPassword string Password to get into the demo mode
 * @property $dbPathAlias string Alias of the temp db folder
 * @property $sourceDbPathAlias string Alias of the source db folder
 * @property $sourceDbFileName string Name of the source db file
 *
 * @package demo-mode extension
 * @author raucher <myplace4spam@gmail.com>
 */
class DemoModeBehavior extends CBehavior
{
    public $demoUserId = 'demo_mode_user';
    public $demoUserRole = 'admin';
    public $demoUserLogin = 'demo';
    public $demoUserPassword = 'demo';
    public $dbPathAlias = 'application.runtime.demo_mode_db';
    public $sourceDbPathAlias = 'application.data';
    public $sourceDbFileName;

    /**
     * Logs in user in demo mode and stores useful info in session
     * @return bool
     */
    public function demoModeUserLogin()
    {
        if($this->owner->username !== $this->demoUserLogin
            && $this->owner->password !== $this->demoUserPassword)
            return false;

        // Create new db file with unique name
        $path = $this->createTempDbFile();

        // Set user id ,role
        // Also set CDN and path to newly created SQLite file for future use
        $this->owner->setId($this->demoUserId);
        $this->owner->setState('cdn', 'sqlite:'.$path);
        $this->owner->setState('demoDbPath', $path);
        $this->owner->setState('role', $this->demoUserRole);

        return !$this->owner->errorCode = CUserIdentity::ERROR_NONE;
    }

    /**
     * Creates new db file with unique name
     * @param null $alias Alias of the temp db folder
     * @return string Path to created db file
     * @throws CHttpException If problems occurs
     */
    public function createTempDbFile($alias = null)
    {
        $alias = is_null($alias) ? $this->dbPathAlias : $alias;

        if(($path = Yii::getPathOfAlias($alias)) === false)
            throw new CHttpException(409, 'Method expects parameter to be a valid path alias');

        //$path = Yii::getPathOfAlias($alias).DIRECTORY_SEPARATOR; // TODO: remove if not necessary
        $path = Yii::getPathOfAlias($alias);

        // Delete old db files
        $this->clearDemoModeDirectory($path);

        // Create directory to store demo-mode databases and name it by current time in 'd-m-Y' format
        if(!(is_dir($dir = $path.DIRECTORY_SEPARATOR.date('d-m-Y')) || mkdir($dir, 0777, true)))
            throw new CHttpException(409, 'Can\'t create directory');

        // Create cloned databases for user logged in demo-mode with unique suffix to avoid collisions
        $dbFileName = sprintf('demo_mode_user_%s.db', uniqid(rand()));
        $dbSourceFile = Yii::getPathOfAlias($this->sourceDbPathAlias).DIRECTORY_SEPARATOR.$this->sourceDbFileName;
        $dbClonedFile = $dir.DIRECTORY_SEPARATOR.$dbFileName;
        if(!copy($dbSourceFile, $dbClonedFile))
            throw new CHttpException(409, 'Can\'t copy db file');

        return $dbClonedFile;
    }

    /**
     * Removes all temporary folders and db files according to current time
     * @param $path string Path to temporary db folder
     * @return bool Whether the cleaning process was successful
     */
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
    }
}