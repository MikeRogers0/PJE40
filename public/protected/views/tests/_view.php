<?php
/* @var $this TestsController */
/* @var $data Tests */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('crunch_file')); ?>:</b>
	<?php echo CHtml::encode($data->crunch_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('display_file')); ?>:</b>
	<?php echo CHtml::encode($data->display_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('crunches')); ?>:</b>
	<?php echo CHtml::encode($data->crunches); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_crunched')); ?>:</b>
	<?php echo CHtml::encode($data->last_crunched); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('completed')); ?>:</b>
	<?php echo CHtml::encode($data->completed); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_users_id')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_users_id); ?>
	<br />

	*/ ?>

</div>