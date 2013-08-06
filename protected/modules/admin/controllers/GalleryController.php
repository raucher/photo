<?php

class GalleryController extends AdminController
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);

		$dataProvider = new CArrayDataProvider($model->medias, array(
			'pagination' => array(
				'pageSize' => 12, 
			),
		));

		$this->render('view',array(
			'model'=>$model,
			'associatedMedias' => $dataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        foreach ($this->langs as $lang) {
            $translations[$lang] = new GalleryTranslation;
        }

		$model = new Gallery;

		if(isset($_POST['GalleryTranslation']))
		{
            if($model->save() && $model->saveTranslations($translations, 'GalleryTranslation'))
            {
                Yii::app()->user->setFlash('success', 'Gallery was successfully created');
                $this->redirect(array('index'));
            }
            else
                Yii::app()->user->setFlash('error', 'Error occurred during saving');
		}

		$this->render('create',array(
			'model'=>$model,
			'translations'=>$translations,
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
            $translation = GalleryTranslation::model()->findByPk(array(
                'gallery_id' => $model->id,
                'lang'       => $lang,
            ));

             // If translation already exists then assign it
             //  otherwise assign a new instance of MediaTranslation
            $translation = is_null($translation) ? new GalleryTranslation : $translation;
            $translations[$lang] = $translation;
        }

        $dataProvider = new CArrayDataProvider($model->medias, array(
			'pagination' => array(
				'pageSize' => 12, 
			),
		));

		if(isset($_POST['GalleryTranslation']))
		{
            if($model->save() && $model->saveTranslations($translations, 'GalleryTranslation'))
            {
                Yii::app()->user->setFlash('success', 'Gallery was successfully updated');
                $this->redirect(array('index'));
            }
            else
                Yii::app()->user->setFlash('error', 'Error occurred during updating');
		}

		$this->render('update',array(
			'model'=>$model,
            'translations' => $translations,
			'associatedMedias' => $dataProvider,
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
		$dataProvider=new CActiveDataProvider('Gallery', array(
            'criteria'=>array(
                'with'=>array('translation'),
            ),
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Gallery('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Gallery']))
			$model->attributes=$_GET['Gallery'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Adds medias to gallery
	 * @param integer the ID of the model to which medias will be added to
	 */
	public function actionAddMedia($id)
	{
		$gallery = $this->loadModel($id);

		// Select only those medias, that hasn't been yet associated with current model
		$medias = new CActiveDataProvider('Media', array(
            'criteria' => array(
                'join' => 'LEFT JOIN tbl_gallery_media_assoc AS a ON a.media_id=id',
                'condition' => '(a.gallery_id <> :gall_id AND media_id
                                    NOT IN (SELECT media_id FROM tbl_gallery_media_assoc
                                                WHERE gallery_id=:gall_id))
                                    OR a.gallery_id IS NULL',
                'params' => array(
                    ':gall_id'=>$gallery->id,
                ),
                'distinct'=>true,
            ),
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

		if( isset($_POST['Medias']) && is_array($medias = $_POST['Medias']) )
		{
			$sql = 'INSERT INTO tbl_gallery_media_assoc(media_id, gallery_id)
									VALUES(:mediaId, :galleryId)';
			$query = Yii::app()->db->createCommand($sql);
			
			$t = Yii::app()->db->beginTransaction();
			
			try{
				foreach ($medias as $mediaId) {
					$query->execute(array(
							':mediaId' => (int) $mediaId,
							':galleryId' => $gallery->id,
						));
				}
				$t->commit();
				$this->redirect(array('/admin/gallery'));
			}
			catch(CDbException $e){
				$t->rollback();
				Yii::app()->handleException($e);
			}
		}

		$this->render('add_media', array('gallery'=>$gallery, 'medias'=>$medias));
	}

	/**
	 * Removes media from gallery
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRemoveMedia($mediaId, $galleryId)
	{
		$sql = "DELETE FROM tbl_gallery_media_assoc 
					WHERE media_id=:mediaId AND gallery_id=:galleryId";
		Yii::app()->db->createCommand($sql)
					  ->execute(array(
					  		':mediaId' => $mediaId,
					  		':galleryId' => $galleryId,
					  	));
		if(Yii::app()->request->isAjaxRequest)
			echo json_encode('Media was successfuly removed!');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Gallery::model()->with('translation')->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='gallery-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
