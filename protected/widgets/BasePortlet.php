<?php
Yii::import('zii.widgets.CPortlet');

/**
 * Class BasePortlet
 * Super class for portlets, generates portlet's header block and CSS classes
 *
 * @property $titleCssClass string CSS class for title
 * @property $contentCssClass string CSS class for content
 * @property $blockCssClass string CSS class for whole portlet block
 * @property $title string Title for the portlet
 * @property $icon string Icon for the portlet. Uses {@link http://fortawesome.github.io/Font-Awesome/ FontAwesome}
 *
 * @package photo
 * @author raucher <myplace4spam@gmail.com>
 */
class BasePortlet extends CPortlet
{
    public $titleCssClass = 'block-header';
    public $contentCssClass = 'block-content';
    public $blockCssClass = 'content-block';
    public $title='Default title';
    public $icon = 'user';

    protected function renderDecoration()
    {
        if(isset($this->title))
        {
            echo "<h2 class=\"{$this->titleCssClass}\">",
                    "<i class=\"icon-{$this->icon}\"></i>",
                    $this->title,
                 "</h2> <!-- .block-header -->";
        }
    }

    public function init()
    {
        $this->htmlOptions['class'] .= ' '.$this->blockCssClass;
        parent::init();
    }
}