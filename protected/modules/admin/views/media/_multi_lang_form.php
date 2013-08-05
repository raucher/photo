<?php
/**
 * var $model object MediaTranslation instance
 * var $lang string Language ID 
 * var $form object CActiveForm instance
 */
?>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model, "[$lang]title", array('class' => 'span12')) ?>
		<?php echo $form->textFieldRow($model, "[$lang]alt", array('class' => 'span12')) ?>
	</div>
	<div class="span7 offset1">
		<?php $this->widget('ext.imperaviRedactor.ImperaviRedactorWidget', array(
            'model'     => $model,
            'attribute' => "[$lang]description",
            'options'   => array(
                'lang'        => 'en',
                'minHeight'=>200,
                'imageUpload' => $this->createUrl('default/redactorImageUpload', array(
                    'attr'=>"content",
                )),
                'imageGetJson' => $this->createUrl('default/redactorImageList',array(
                    'attr'=>"content",
                )),
                'imageUploadErrorCallback' => 'js:function(obj, json){ alert(json.error);}',
                'fileUpload' => $this->createUrl('default/redactorFileUpload', array(
                    'attr'=>"content",
                )),
                'fileUploadErrorCallback'=>new CJavaScriptExpression(
                    'function(obj,json) { alert(json.error); }'
                ),
            ),
        ));?>
	</div>
</div>
