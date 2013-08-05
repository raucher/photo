<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makc
 * Date: 7/3/13
 * Time: 6:38 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<div id="post-content" class="span12">
    <ul id="og-grid" class="og-grid">
    <?php foreach($photos as $photo): ?>
            <?php $mediaData = $photo->translation ?>
        <li>
            <a href="http://cargocollective.com/jaimemartinez/" data-largesrc="<?php echo $homeUrl.'media/'.$photo->src ?>" data-title="<?php echo $mediaData->title ?>" data-description="<?php echo $mediaData->description ?>">
                <img src="<?php echo $homeUrl.'media/'.$photo->src ?>" alt="<?php $mediaData->alt ?>">
            </a>
        </li>
    <?php endforeach ?>
    </ul> <!-- #og-grid.og-grid -->
</div> <!-- #post-content -->

<?php // TODO: place this code in package
    $initScript = 'jQuery(function() {
                    Grid.init();
                });';
    Yii::app()->clientScript->registerScriptFile($homeUrl.'og-grid/js/modernizr.custom.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile($homeUrl.'og-grid/js/grid.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScript('og_grid_init', $initScript, CClientScript::POS_END);

    Yii::app()->clientScript->registerCssFile($homeUrl.'og-grid/css/default.css');
    Yii::app()->clientScript->registerCssFile($homeUrl.'og-grid/css/component.css');
?>
