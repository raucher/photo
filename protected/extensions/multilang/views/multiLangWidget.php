<div class="dropdown">
    <a class="dropdown-toggle label label-inverse" data-toggle="dropdown" href="#">
        <?php echo Yii::app()->language ?>
        <i class="icon-caret-down"></i>
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
        <?php // Loop creates a list of the available languages
                foreach ($this->langs as $lang): $_GET['lang'] = $lang ?>
        <li>
            <a tabindex="-1" href="<?php echo Yii::app()->controller->createUrl('', $_GET) ?>">
                <?php echo $lang ?>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
</div>