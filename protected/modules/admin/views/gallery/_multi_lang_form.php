<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makc
 * Date: 7/13/13
 * Time: 3:30 PM
 * To change this template use File | Settings | File Templates.
 *
 * var $model object MediaTranslation instance
 * var $lang string Language ID
 * var $form object CActiveForm instance
 */
?>

<div class="row-fluid">
    <?php echo $form->textFieldRow($model, "[$lang]title", array('class' => 'span8')) ?>

    <?php $this->widget('ext.imperaviRedactor.ImperaviRedactorWidget', array(
        'model'     => $model,
        'attribute' => "[$lang]description",
        'options'   => array(
            'lang'        => 'en',
            'imageUpload' => $this->createUrl('default/redactorImageUpload', array(
                'attr'=>"content",
            )),
            'imageGetJson' => $this->createUrl('default/redactorImageList',array(
                'attr'=>"content",
            )),
            'imageUploadErrorCallback' => new CJavaScriptExpression(
                'function(obj,json) { alert(json.error); }'
            ),
            'fileUpload' => $this->createUrl('default/redactorFileUpload', array(
                'attr'=>"content",
            )),
            'fileUploadErrorCallback'=>new CJavaScriptExpression(
                'function(obj,json) { alert(json.error); }'
            ),
        ),
        //'htmlOptions' => array('height' => '200px'),
    ));?>
</div>
