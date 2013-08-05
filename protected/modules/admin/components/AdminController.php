<?php

/**
 * Super class for admin-side classes
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class AdminController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/akira'; // Default layout for the dashboard

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            // perform access control for CRUD operations
			'accessControl',
            // Look for the filterPageTitleRewrite() method for more information
            'pageTitleRewrite',
            array(
                // Enables a warning message that the user is currently in demo-mode
                'admin.components.DemoModeFilter',
            ),
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    /**
     * Customizes the page title
     * @param $fChain CFilterChain
     */
    public function filterPageTitleRewrite($fChain)
    {
        $controllerId = $this->id === 'default' ? '' : $this->id;
        $actionId = $this->action->id === 'index' ? '' : $this->action->id;
        $this->pageTitle = ucwords($controllerId .' '. $actionId);
        $fChain->run();
    }

	/**
	 * Generates tabs for the multi-language content
	 * @param $models array() Set of translation models 
	 * @param $form CActiveForm Instance of CActiveForm
     * @return array Array with content for each tab in it
	 */
	public function getMultilangTabs($models, $form)
	{
        $count = 0;
		foreach($models as $lang => $langModel)
		{
            $tabs[] = array(
				// Set only 1st tab active
				'active'  => ++$count === 1,
				'label'   => strtoupper($lang).' Content',

				// Controller which implements this function must have
				//  _multi_lang_form.php partial view into it's views directory
				'content' => $this->renderPartial('_multi_lang_form', array(
                    'model' => $langModel,
                    'lang'  => $lang,
                    'form'  => $form,
                ), true),
			);
		}
		return $tabs;
	}

}