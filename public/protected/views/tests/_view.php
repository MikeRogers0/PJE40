<div class="well">

	<?php /*<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('crunches_required')); ?>:</b>
	<?php echo CHtml::encode($data->crunches_required); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_crunched')); ?>:</b>
	<?php echo CHtml::encode($data->last_crunched); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('completed')); ?>:</b>
	<?php echo CHtml::encode($data->completed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tbl_users_id')); ?>:</b>
	<?php echo CHtml::encode($data->tbl_users_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />*/ ?>
	
	<h2><?php echo CHtml::encode($data->name); ?></h2>
	<p><?php echo CHtml::encode($data->description); ?></p>
	
	<p><?php echo CHtml::encode($data->getAttributeLabel('last_crunched')); ?>: <?php echo CHtml::encode($data->last_crunched); ?></p>
	<p>Total Crunches: <?php echo count($data->completed_crunches); ?> of <?php echo CHtml::encode($data->crunches_required); ?></p>
	<div class="progress progress-striped">
		<div class="bar" style="width:<?php echo (count($data->completed_crunches) / $data->crunches_required) * 100 ?>%;"></div>
	</div>
	<?php
	if($data->completed == '1'){
		echo CHtml::link('View Result',array('view','id'=>$data->id), array('class'=>'btn')); 
	}else{
		echo CHtml::link('Task Unfinished',array('view','id'=>$data->id), array('class'=>'btn btn-danger')); 
	}
	?>
</div>