<?php

class MediaController extends AdminController
{
	public function actions()
	{
		return array(
			'xupload' => array(
				'class'         => 'XUploadExtAction',
				'path'          => realpath( Yii::app()->getBasePath().'/../media' ),
				'publicPath'    => Yii::app()->getBaseUrl().'/media',
				'stateVariable' => 'images',
			),
		);
	}

    /**
     * Lists all medias.
     */
    public function actionIndex()
    {
        Yii::import('xupload.models.XUploadForm');
        $xUpload = new XUploadForm;

        $mediaModel = new Media;

        $dataProvider = new CActiveDataProvider('Media', array(
            'sort' => array(
                'attributes'=>array(
                    'update_time'=>array(
                        'asc'=>'update_time',
                        'desc'=>'update_time DESC',
                        'default'=>'desc',
                    ),
                ),
                'defaultOrder'=>array(
                    'update_time'=>CSort::SORT_DESC,
                )
            ),
            'pagination' => array(
                'pageSize' => 12,
            ),
        ));
        $this->render('index',array(
                'dataProvider'=>$dataProvider,
                'mediaModel' => $mediaModel,
                'xUpload' => $xUpload,
            )
        );
    }

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
		$model=new Media;
		if(isset($_POST['Media']))
		{
			$model->attributes=$_POST['Media'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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
		foreach ($this->langs as $lang){
			// Get translation associated with language
			$translation = MediaTranslation::model()->findByPk(array(
												'media_id' => $model->id,
												'lang'     => $lang,
											));
			/**
			 * If translation already exists then assign it
			 * otherwise assign a new instance of MediaTranslation
			 */
			$translation = is_null($translation) ? new MediaTranslation : $translation;
			$translations[$lang] = $translation;
		}

		if(isset($_POST['Media']))
		{
			$model->attributes=$_POST['Media'];
            if($model->save() && $model->saveTranslations($translations, 'MediaTranslation'))
            {
                Yii::app()->user->setFlash('success', 'Media was successfully updated');
                $this->redirect(array('index'));
            }
            else
                Yii::app()->user->setFlash('error', 'Error occurred during updating');
		}

		$this->render('update',array(
			'model'=>$model, 'translations'=> $translations ));
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
			$this->loadModel($id)->delete();
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!Yii::app()->request->isAjaxRequest)
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin/media'));

			echo json_encode('Model successfuly deleted!');
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Media('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Media']))
			$model->attributes=$_GET['Media'];

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
		$model=Media::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='media-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
