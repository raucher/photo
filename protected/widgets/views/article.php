<p>
    <?php printf('%s ...', mb_substr($data->content, 0, 400)) ?>
</p>
<a class="button dark-olive" href="<?php echo $this->owner->multiLangUrl('photo/page', array('page'=>$data->article->url)) ?>">
    Read more <i class="icon-caret-right"></i>
</a>