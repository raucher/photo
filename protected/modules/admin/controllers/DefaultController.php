<?php

class DefaultController extends AdminController
{
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // All all to admin
				'roles'=>array('admin'),
			),
			array('allow', // Allow any user to view login page
				'actions' => array('login'),
				'users'=>array('*'),
			),
			array('deny',  // Deny all other actions for unregistered users
				'users'=>array('*'),
			),
		);
	}

    public function actions()
    {
        return array(
            // Actions for ImperaviRedactor file and image managing
            'redactorImageUpload' => array(
                'class'=>'ext.imperaviRedactor.actions.ImageUpload',
                'uploadPath'=>Yii::getPathOfAlias('webroot.uploads.images'),
                'uploadUrl'=>Yii::app()->getHomeUrl().'uploads/images',
                'uploadCreate'=>true,
                'permissions'=>0664,
            ),
            'redactorImageList'=>array(
                'class'=>'ext.imperaviRedactor.actions.ImageList',
                'uploadPath'=>Yii::getPathOfAlias('webroot.uploads.images'),
                'uploadUrl'=>Yii::app()->getHomeUrl().'uploads/images',
            ),
            'redactorFileUpload'=>array(
                'class'=>'ext.imperaviRedactor.actions.FileUpload',
                'uploadPath'=>Yii::getPathOfAlias('webroot.uploads.files'),
                'uploadUrl'=>Yii::app()->getHomeUrl().'uploads/files',
                'uploadCreate'=>true,
                'permissions'=>0664,
            ),
        );
    }
	
	public function actionIndex()
	{
        $items = array(
            'mediaCount'=>Media::model()->count(),
            'galleryCount'=>Gallery::model()->count(),
            'articleCount'=>Article::model()->count(),
        );
		$this->render('index', $items);
	}

	public function actionLogin()
	{
		if(Yii::app()->user->checkAccess('admin'))
			$this->redirect('index');

		$this->layout = '/layouts/akira_login';
		$model = new AdminLoginForm;

		if( isset($_POST['AdminLoginForm']))
		{
			$model->attributes = $_POST['AdminLoginForm'];

			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('login_form', array('model' => $model) );
	}

	public function actionLogout()
	{
        if(Yii::app()->user->id === 'demo_mode_user')
        {
            // Sets current connection inactive otherwise unlink will not be able to delete db file
            Yii::app()->db->setActive(false);
            // Set full permissions to file and delete it
            chmod(Yii::app()->user->getState('demoDbPath'), 0777) && unlink(Yii::app()->user->getState('demoDbPath'));
        }

		Yii::app()->user->logout();
		$this->redirect('login');
	}

	public function actionOptions()
	{
        $options = array(
            'info' => Option::model()->findAllByAttributes(array('category'=>'info')),
            'social' => Option::model()->findAllByAttributes(array('category'=>'social')),
            'system' => Option::model()->findAllByAttributes(array('type'=>'system')),
        );

        if( isset($_POST['Option']) )
		{
			$t = Yii::app()->db->beginTransaction();
			$valid = true;
			try
			{	// Separate options by type: 'user' and 'system' in our case
				foreach($options as $type => $optionSet)
				{

					 // Get option model and save it's index for
					 // future usage in received $_POST
					foreach ($optionSet as $i => $option) 
					{
						 // $_POST structure is such:
						 // $_POST['Options']['option_type']['option_index']['option_data']
						 // $_POST['Options']['user'][0]['value'] for example
						$option->value = $_POST['Option'][$type][$i]['value'];
						$valid = $option->save() && $valid;
					}
				}
				$t->commit();
				Yii::app()->user->setFlash('success', '<strong>Success: </strong>Options saved!');
			}
			catch(Exception $e)
			{
				$t->rollback();
				Yii::app()->user->setFlash('warning', '<strong>Error: </strong>Options could not be saved for some reason!');
			}
			$this->refresh();
		}
		$this->render( 'options', array('options' => $options) );
	}

	public function actionNewPass()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
        $user->scenario = 'changePass';
		if( isset($_POST['User']) )
		{
			$user->attributes = $_POST['User'];
			if( $user->validate() && $user->saveNewPass() )
			{
				Yii::app()->user->setFlash('success', '<strong>Success: </strong> password changed!');
				$this->refresh();
			}
		}

		$this->render( 'newpass', array('user'=>$user) );
	}

	public function actionCreateRBAC()
	{
		$auth = Yii::app()->authManager;

		$auth->createOperation('createItem', 'May create a new item');
		$auth->createOperation('viewItem', 'May create view an item');
		$auth->createOperation('updateItem', 'May update an item');
		$auth->createOperation('deleteItem', 'May delete an item');

		$task = $auth->createTask('uploadFile', 'May upload a new file');
		
		$role = $auth->createRole('reader', 'Almost rightless, can only view several items at frontend');
		$role->addChild('viewItem');

		$role = $auth->createRole('admin', 'Has access to dashboard and unlimited privilegies');
		$role->addChild('reader');
		$role->addChild('createItem');
		$role->addChild('updateItem');
		$role->addChild('deleteItem');
	}

    /**
     * Returns tabs for TbTabs widget in the view/options.php
     * @param $options array Set of the CActiveRecord instances
     * @param $form CActiveForm
     * @return array Array of HTML content for each tab
     */
    public function getOptionTabs($options, $form)
	{
        $count=0;
		foreach($options as $type => $optionModels)
		{
			$tabs[] = array(
				// Set only 1st tab active
				'active'  => ++$count === 1,
				'label'   => ucfirst($type).' Options',

				 // Controller that implements this function must have
				 // _option_tab.php into it's views directory
				'content' => $this->renderPartial('_option_tab', array(
								'optionModels' => $optionModels,
								'type'  => $type,
								'form'  => $form,
							), true),
			);
		}
		return $tabs;
	}
}