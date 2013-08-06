
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->homeUrl.'js/debounce.min.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->homeUrl.'js/jquery.carouFredSel-6.0.4-packed.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->homeUrl.'js/site-carousel.js') ?>


<!-- BIG INDEX-PAGE SLIDER/CAROUSEL -->
<div id="main-slider">
    <div id="carousel">
        <?php foreach($photos as $photo): ?>
            <img src="<?php echo $mediaUrl.$photo->src ?>" alt="<?php echo $photo->translation->alt ?>">
        <? endforeach; reset($photos); ?>
    </div>
    <div class="prev"> </div>
    <div class="next"> </div>
</div> <!-- #main-slider -->

<!-- MAIN CONTENT -->
<div id="main-content"  class="light-grey-gradient gradient">
    <div class="container">
        <div class="row-fluid"> <!-- MINI CAROUSEL -->
            <div class="mini-carousel">
                <div id="mini-wrapper">
                    <div id="pager-carousel">
                    <?php foreach($photos as $photo): ?>
                        <img src="<?php echo $mediaUrl.$photo->src ?>" alt="<?php echo $photo->translation->alt ?>" width="80" height="80" >
                    <?php endforeach ?>
                    </div>
                </div>
                <a href="#" class="prev" title="Show previous"> </a>
                <a href="#" class="next" title="Show next"> </a>
            </div> <!-- .mini-carousel -->
        </div>
        <div id="homepage-widgets" class="row-fluid">
            <?php if($this->hasWidgets()) $this->renderWidgets()?>
        </div> <!-- .row-fluid -->
    </div><!-- .container -->
</div> <!-- #main-content.light-grey-gradient -->
