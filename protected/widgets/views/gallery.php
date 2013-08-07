<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makc
 * Date: 7/11/13
 * Time: 8:19 PM
 * To change this template use File | Settings | File Templates.
 */?>

<div id="gallery-selector" class="dropdown">
    <span>Choose gallery: </span>
    <a class="dropdown-toggle label label-inverse" data-toggle="dropdown" href="#">
        <?php // If this is an ActiveRecord then return its title, else it is the string 'All'
              echo is_a($activeGallery, 'CActiveRecord') ? $activeGallery->translation->title : $activeGallery ?>
        <i class="icon-caret-down"></i>
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
    <!-- Link to show all galleries -->
        <li>
            <a tabindex="-1" href="<?php echo $this->owner->multiLangUrl('photo/gallery') ?>">
                All
            </a>
        </li>
        <?php // Loop creates a list of the available galleries ?>
        <?php foreach ($galleries as $i => $gall): ?>
            <li>
                <a tabindex="-1" href="<?php echo $this->owner->multiLangUrl('photo/gallery', array('gall'=>$gall->id)) ?>">
                    <?php // If gallery haven't got name then just index it by number
                        echo !empty($gall->translation->title) ? $gall->translation->title : 'Gallery '.++$i ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>