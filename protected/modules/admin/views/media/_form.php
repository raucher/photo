<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'media-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
		<div class="thumbnail span8" style="max-height:300px; overflow:hidden;">
			<img src="<?php echo Yii::app()->baseUrl.'/media/'.$model->src; ?>" style="min-width:100%">
		</div>
		<div class="span4">
		<?php echo $form->textFieldRow($model,'src',array('class'=>'span12')); ?>

		<?php //echo $form->textFieldRow($model,'type',array('class'=>'span12')); ?>
		</div>
	</div>
	
	<hr>
	
	<?php $this->widget('bootstrap.widgets.TbTabs', array(
					'tabs' => $this->getMultilangTabs($translations, $form),
				)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>


<?php function publishTranslations( $models, $form, $controller )
		{
			echo '<div class="tabbable"> <!-- Only required for left/right tabs -->
		    		<ul class="nav nav-tabs">';
		    	foreach( $models as $lang => $langModel ){
					echo '<li class="', (++$i===1) ? 'active' : '' , '"><a href="#tab-' . $lang . '" data-toggle="tab">', strtoupper($lang), ' Content </a></li>';
				}

		    echo '</ul> 
		    		<div class="tab-content">';

			foreach( $models as $lang => $langModel ){

				echo '<div class="tab-pane', (++$n === 1) ? ' active' : '', '" id="tab-'.$lang.'">';
				echo $form->errorSummary($langModel);
				$controller->renderPartial('_multi_lang_form', array(
							'model' => $langModel,
							'lang' => $lang,
							'form' => $form,
							));
				echo '</div>';
			
			}
			    
			echo '</div> <!-- .tab-content -->';
			echo '</div> <!-- .tabbable -->';
		}
?>