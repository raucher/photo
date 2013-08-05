<?php 
/**
 * @var $user User instance
 * @var $this DefaultController instance
 */ ?>

 <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
 			'id' => 'new-pass',
 			'type' => 'horizontal',
 			'enableClientValidation' => true,
 		)); ?>

<legend>Change pass for <?php echo $user->name; ?></legend>

<?php echo $form->errorSummary($user); ?>

<?php echo $form->passwordFieldRow($user, 'checkCurrentPass'); ?>
<?php echo $form->passwordFieldRow($user, 'newPass_repeat'); ?>
<?php echo $form->passwordFieldRow($user, 'newPass'); ?>
<?php echo $form->textFieldRow($user, 'name'); ?>

<input class="btn btn-primary" type="submit" value="Change Password">

<?php $this->endWidget(); ?>