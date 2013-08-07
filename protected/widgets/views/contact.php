<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makc
 * Date: 7/23/13
 * Time: 3:00 PM
 * To change this template use File | Settings | File Templates.
 */
?>

<?php foreach ($options as $option): ?>
    <address>
        <strong><?php echo ucfirst($option->name) ?></strong><br>
        <span><?php echo $option->value ?></span>
    </address>
<?php endforeach ?>
