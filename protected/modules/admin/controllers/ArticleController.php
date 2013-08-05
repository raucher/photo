<?php

class ArticleController extends AdminController
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$langs = array('en', 'ru', 'lv');		
		foreach ($langs as $lang) {
			$translations[$lang] = new ArticleTranslation;
		}

		$model=new Article;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
			/**
			 * TODO: Check for default app. language, not directly for 'en'!
			 * TODO: Maybe make $title required in ArticleTranslations
			 */
			if( isset($_POST['ArticleTranslation']['en']) )
			{
				$title2url = $_POST['ArticleTranslation']['en']['title'];
				$model->url = str_replace(' ', '-', mb_strtolower( trim($title2url) ));
			}
            if($model->save() && $model->saveTranslations($translations, 'ArticleTranslation'))
            {
                Yii::app()->user->setFlash('success', 'Gallery was successfully created');
                $this->redirect(array('index'));
            }
            else
                Yii::app()->user->setFlash('error', 'Error occurred during creation');
		}

		$this->render('create',array(
			'model'        => $model,
			'translations' => $translations,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$langs = array('en', 'ru', 'lv');
		foreach ($langs as $lang){
			// Get translation associated with language
			$translation = ArticleTranslation::model()->findByPk(array(
                'article_id' => $model->id,
                'lang' => $lang,
            ));
			/**
			 * If translation already exists then assign it
			 * otherwise assign a new instance of MediaTranslation
			 */
			$translation = is_null($translation) ? new ArticleTranslation : $translation;
			$translations[$lang] = $translation;
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
			/**
			 * TODO: Check for default app. language, not directly for 'en'!
			 */
			/*if( isset($_POST['ArticleTranslation']['en']) )
			{
				$title = $_POST['ArticleTranslation']['en']['title'];
                if($model->isNewRecord || empty($model->url))
				    $model->url = str_replace(' ', '-', mb_strtolower( trim($title) ));
			}*/
            if($model->save() && $model->saveTranslations($translations, 'ArticleTranslation'))
            {
                Yii::app()->user->setFlash('success', 'Article was successfully updated');
                $this->redirect(array('index'));
            }
            else
                Yii::app()->user->setFlash('error', 'An error occurred during updating');
		}
		$this->render('update',array(
			'model'        => $model,
			'translations' => $translations
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Article');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Article('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Article']))
			$model->attributes=$_GET['Article'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
