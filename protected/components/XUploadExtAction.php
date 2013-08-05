<?php

Yii::import('xupload.actions.XUploadAction');

/**
 * Extended action for XUpload with ability to create Media models after file uploading
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 *
 * Based on:
 * ###Resources
 * - [xupload](http://www.yiiframework.com/extension/xupload)
 * @version 0.3
 * @author Asgaroth (http://www.yiiframework.com/user/1883/)
*/
class XUploadExtAction extends XUploadAction
{
	/**
     * Uploads file to temporary directory
     *
     * @throws CHttpException
     */
    protected function handleUploading()
    {
        $this->init();
        $model = $this->formModel;
        $model->{$this->fileAttribute} = CUploadedFile::getInstance($model, $this->fileAttribute);
        if ($model->{$this->fileAttribute} !== null) {
            $model->{$this->mimeTypeAttribute} = $model->{$this->fileAttribute}->getType();
            $model->{$this->sizeAttribute} = $model->{$this->fileAttribute}->getSize();
            $model->{$this->displayNameAttribute} = $model->{$this->fileAttribute}->getName();
            $model->{$this->fileNameAttribute} = $model->{$this->displayNameAttribute};

            if ($model->validate()) {

                $path = $this->getPath();

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                    chmod($path, 0777);
                }

                $model->{$this->fileAttribute}->saveAs($path . $model->{$this->fileNameAttribute});
                chmod($path . $model->{$this->fileNameAttribute}, 0777);

                // start: Save Media model
                $mediaFilePath = basename($path).'/'.$model->{$this->fileNameAttribute};
                $mediaModel = new Media;
                $mediaModel->src = $mediaFilePath;
                // end: Save Media model

                $returnValue = $this->beforeReturn();
                if ($mediaModel->save() && $returnValue === true) {
                    echo json_encode(array(array(
                        "name" => $model->{$this->displayNameAttribute},
                        "type" => $model->{$this->mimeTypeAttribute},
                        "size" => $model->{$this->sizeAttribute},
                        "url" => $this->getFileUrl($model->{$this->fileNameAttribute}),
                        "thumbnail_url" => $model->getThumbnailUrl($this->getPublicPath()),
                        "delete_url" => $this->getController()->createUrl($this->getId(), array(
                            "_method" => "delete",
                            "file" => $model->{$this->fileNameAttribute},
                            // Add Media model id to the delete link 
                            //  for further use in self::handleDeleting()
                            'modelId' => $mediaModel->id,
                        )),
                        "delete_type" => "POST"
                    )));
                } else {
                    echo json_encode(array(array("error" => $returnValue,)));
                    Yii::log("XUploadAction: " . $returnValue, CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction");
                }
            } else {
                echo json_encode(array(array("error" => $model->getErrors($this->fileAttribute),)));
                Yii::log("XUploadAction: " . CVarDumper::dumpAsString($model->getErrors()), CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction");
            }
        } else {
            throw new CHttpException(500, "Could not upload file");
        }
    }

	/**
     * Removes temporary file from its directory and from the session
     *
     * @return bool Whether deleting was meant by request
     */
    protected function handleDeleting()
    {
        if (isset($_GET["_method"]) && $_GET["_method"] == "delete") {
            $success = false;
            if ($_GET["file"][0] !== '.' && Yii::app()->user->hasState($this->stateVariable)) {
                // pull our userFiles array out of state and only allow them to delete
                // files from within that array
                $userFiles = Yii::app()->user->getState($this->stateVariable, array());

                // Return Media model found by id otherwise null 
                $mediaModel = Media::model()->findByPk($_GET['modelId']);
                // If file and model corresponding to it are found  
                if ($mediaModel && $this->fileExists($userFiles[$_GET["file"]])) 
                {	// If model and corresponding file deletion is successful
                	// Cause Media class implements afterDelete() we don't need to unlink file
                    if ( $mediaModel->delete() ) 
                    {
                        unset($userFiles[$_GET["file"]]); // remove it from our session and save that info
                        Yii::app()->user->setState($this->stateVariable, $userFiles);
                    }
                }
            }
            echo json_encode($success);
            return true;
        }
        return false;
    }
}

?>