<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id' => 'admin-login-form',
				'htmlOptions' => array(
					'class' => 'span4 offset4 well',
				),
			)); 

echo $form->textFieldRow($model, 'username', array(
							'class'   => 'span3', 
							'prepend' => '<i class="icon-user"></i>',
						));

echo $form->passwordFieldRow($model, 'password', array(
							'class'   => 'span3', 
							'prepend' => '<i class="icon-lock"></i>',
						));

echo $form->checkboxRow($model, 'rememberMe'); ?>

<input class="btn btn-success btn-large span2" type="submit" value="Log In" style="margin-top:10px">

<?php $this->endWidget(); ?>