<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
	<div id="main-content" class="light-grey-gradient">
		<div class="container">
			<div class="row-fluid">
			<?php echo $content; ?>

		<?php // Echo widgets if is set one
				if($this->hasWidgets()): ?>
			<div id="sidebar" class="span4">
				<?php /*foreach ($this->sidebarWidgets as $widget) {
					echo $widget;
				}*/
                    $this->renderWidgets();
				?>
			</div>
		<?php endif ?>

			</div> <!-- .row-fluid -->
		</div><!-- .container -->
	</div> <!-- #main-content.light-grey-gradient -->
<?php $this->endContent(); ?>