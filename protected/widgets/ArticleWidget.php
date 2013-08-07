<?php
Yii::import('application.widgets.BasePortlet');

/**
 * Class ArticleWidget
 * Portlet to display article in sidebars, blocks etc.
 *
 * @property $id integer Id of the specified article
 * @property $title string Title of the specified article
 * @property $searchLang string Language in which title is written
 * @property $_content string Content of the specified article
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class ArticleWidget extends BasePortlet
{
    public $id = null;
    public $title = 'About';
    public $searchLang = 'en';
    private $_content;

    public function init()
    {
        $sqlParams = array();
        if(isset($this->id))
            $sqlParams['article_id'] = $this->id;
        if(isset($this->title))
            $sqlParams['title'] = $this->title;

        $this->_content =  ArticleTranslation::model()->with('article')
                            ->forceLanguageScope($this->searchLang) // Override default language scope
                            ->findByAttributes($sqlParams)
                            ->article->translation;

        $this->title = $this->_content->title;
        parent::init();
    }

    public function renderContent()
    {
        $this->render('article', array('data'=>$this->_content));
    }
}