<?php
/**
 * @var $options array() Set of the Option instances indexed by type: 'user', 'system'
 * @var $this object CController instance of the admin/defaultController
*/?>

<h2>Options</h2>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'   => 'option-form',
				'type' => 'horizontal',
			));?>

<?php $this->widget('bootstrap.widgets.TbTabs', array(
			'tabs' => $this->getOptionTabs($options, $form),
		)); ?>

<input class="btn btn-primary" type="submit" value="Set options">
<?php $this->endWidget(); ?>