<?php
/* @var $this TestsController */
/* @var $model Tests */

$this->breadcrumbs=array(
	'Tasks'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Tasks', 'url'=>array('index')),
	array('label'=>'Create Task', 'url'=>array('create')),
	array('label'=>'Update Task', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Task', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Task: <?php echo $model->name; ?></h1>

<p><?php echo CHtml::encode($model->description); ?></p>

<ul>
	<li><strong><?php echo CHtml::encode($model->getAttributeLabel('totalProcessingTime')); ?></strong>: <?php echo CHtml::encode($model->totalProcessingTime); ?> Seconds</li>
	<li><strong><?php echo CHtml::encode($model->getAttributeLabel('avgLatencyTime')); ?></strong>: <?php echo CHtml::encode($model->avgLatencyTime); ?> Seconds</li>
	<li><strong><?php echo CHtml::encode($model->getAttributeLabel('totalRunTime')); ?></strong>: <?php echo $model->getTotalRunTime(); ?></li>
	<li><strong><?php echo CHtml::encode($model->getAttributeLabel('last_crunched')); ?></strong>: <?php echo CHtml::encode($model->last_crunched); ?></li>
	<li><strong><?php echo CHtml::encode($model->getAttributeLabel('crunches_required')); ?></strong>: <?php echo CHtml::encode($model->crunches_required); ?></li>
	<li><strong><?php echo CHtml::encode($model->getAttributeLabel('completed')); ?></strong>: <?php 
	if($model->completed === '0'){
		echo 'Processing';
	}elseif($model->completed === '1'){
		echo 'Completed';
	}else{
		echo 'Failed';
	}?></li>
</ul>

<p><?php echo CHtml::link('Re-Run Task',array('restart','id'=>$model->id), array('class'=>'btn'));  ?></p>

<h2>Results</h2>

<div id="testResults">
	<p>Results are loading.</p>
</div>

<div id="results" style="display:none;">
	<?php echo $results; ?>
</div>


<script>
	var config = {
		results: JSON.parse(document.getElementById('results').innerHTML),
		wrapper: document.getElementById('testResults'),
	};
</script>

<script src="<?php echo CHtml::encode($model->display_file); ?>"></script>