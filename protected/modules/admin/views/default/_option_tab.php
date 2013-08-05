<legend><?php echo ucfirst($type); ?> options</legend>

<?php foreach($optionModels as $i => $option)
		{
			echo $form->errorSummary($option);
            if($option->specific === 'list')
            {
                switch($option->category)
                {
                    case 'language':
                        $listData =  array_combine(Yii::app()->params['langs'], Yii::app()->params['langs']);
                        break;
                    case 'slider':
                        $listData =  CHtml::listData(Gallery::model()->findAll(), 'translation.title', 'translation.title');
                        natcasesort($listData);
                        array_unshift($listData, 'All'); // If user wants to show all galleries
                }
                echo $form->dropDownListRow($option, "[{$type}][{$i}]value", array($listData));
            }
            else
                echo $form->textFieldRow($option, "[{$type}][{$i}]value", array(
                    'labelOptions' => array(
                        'label' => ucwords($option->name).':',
                    ),
                ));
		}
 ?>