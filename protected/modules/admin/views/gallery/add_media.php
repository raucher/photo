<?php
/**
 * @var $gallery Gallery instance of gallery model
 * @var $medias CActiveDataProvider of Media model
 */ 
?>
<form method="post" class="row-fluid">
	<input type="submit" class="btn btn-success btn-large" value="Add Medias">
	
	<ul class="thumbnails admin-media-thumbnails">
	<?php $this->widget('bootstrap.widgets.TbListView', array(
            'dataProvider' => $medias,
            'itemView' => '_media_list',
            'sortableAttributes' => array(
                'update_time',
            ),
    ));?>
	</ul>
</form>