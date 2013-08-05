<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makc
 * Date: 7/3/13
 * Time: 6:39 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<div id="post-content" class="span8">
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'&times;',
    )); ?>

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'contact-form',
        'type' => 'horizontal',
        'enableClientValidation' => true,
        'htmlOptions' => array(
            'class' => 'span10',
        ),
    )); ?>
        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->textFieldRow($model, 'name', array(
            'class' => 'span12',
        )); ?>
        <?php echo $form->textFieldRow($model, 'email', array(
            'class' => 'span12',
        )); ?>
        <?php echo $form->textFieldRow($model, 'subject', array(
            'class' => 'span12',
        )); ?>
        <?php echo $form->textAreaRow($model, 'message', array(
            'class' => 'span12',
            'rows' => '7',
        )); ?>
    <div class="control-group">
        <div class="controls">
           <?php $this->widget('ext.recaptcha.EReCaptcha',array(
                'model'=>$model, 'attribute'=>'verifyCode',
                'theme'=>'red', 'language'=>'en_US',
                'publicKey'=>'6LfO_uMSAAAAANwQV2BYLERj0NFt2gZ85Mkdhavt',
            )); ?>
        </div>
    </div>
        <input type="submit" class="button dark-olive">
    <?php $this->endWidget(); ?>
</div>

<?php
    $script = "$('.alert-block.fade').delay(3500).fadeOut(700)";
    Yii::app()->clientScript->registerScript('alertFadeOut', $script);
?>