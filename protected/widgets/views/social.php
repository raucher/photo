<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makc
 * Date: 7/11/13
 * Time: 4:54 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<ul class="social-networks <?php echo $this->htmlOptions['class'] ?>">
    <li><a href="https://www.facebook.com/<?php echo strtolower(str_replace(' ', '.', Option::getOption('facebook'))) ?>">
            <i class="icon-facebook-sign icon-large"></i>
        </a>
    </li>
    <li><a href="https://twitter.com/<?php echo ltrim(Option::getOption('twitter'), '@#') ?>">
            <i class="icon-twitter-sign icon-large"></i>
        </a>
    </li>
    <li><a href="http://<?php echo trim(Option::getOption('tumblr')) ?>.tumblr.com/">
            <i class="icon-tumblr-sign icon-large"></i>
        </a>
    </li>
    <li><a href="http://www.flickr.com/photos/<?php echo trim(Option::getOption('flickr')) ?>">
            <i class="icon-flickr icon-large"></i>
        </a>
    </li>
    <li><a href="http://instagram.com/<?php echo trim(Option::getOption('instagram'), '@#') ?>#">
            <i class="icon-instagram icon-large"></i>
        </a>
    </li>
</ul> <!-- .social-icons -->