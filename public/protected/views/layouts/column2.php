<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
	<div class="span8">
		<?php echo $content; ?>
	</div>
	<div class="offset1 span3">
	<?php
		$this->widget('bootstrap.widgets.TbMenu', array(
			'type'=>'list',
			'items'=>array_merge(array(array('label'=>'Operations')), $this->menu),
		));
	?>
	</div>
</div>
<?php $this->endContent(); ?>