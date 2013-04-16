<?php
/* @var $this TestsController */
/* @var $model Tests */

$this->breadcrumbs=array(
	'Tests'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Tests', 'url'=>array('index')),
	array('label'=>'Create Tests', 'url'=>array('create')),
	array('label'=>'Update Tests', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Tests', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tests', 'url'=>array('admin')),
);
?>

<h1>View Test: <?php echo $model->name; ?></h1>

<ul>
	<li><?php echo CHtml::encode($model->getAttributeLabel('last_crunched')); ?>: <?php echo CHtml::encode($model->last_crunched); ?></li>
	<li><?php echo CHtml::encode($model->getAttributeLabel('tbl_users_id')); ?>: <?php echo CHtml::encode($model->tbl_users_id); ?></li>
	<li><?php echo CHtml::encode($model->getAttributeLabel('completed')); ?>: <?php echo CHtml::encode($model->completed); ?></li>
	<li><?php echo CHtml::encode($model->getAttributeLabel('crunches_required')); ?>: <?php echo CHtml::encode($model->crunches_required); ?></li>
	<li><?php echo CHtml::encode($model->getAttributeLabel('description')); ?>: <?php echo CHtml::encode($model->description); ?></li>
	<li><?php echo CHtml::encode($model->getAttributeLabel('totalProcessingTime')); ?>: <?php echo CHtml::encode($model->totalProcessingTime); ?> Seconds</li>
	<li><?php echo CHtml::encode($model->getAttributeLabel('avgLatencyTime')); ?>: <?php echo CHtml::encode($model->avgLatencyTime); ?> Seconds</li>
	<li><?php echo CHtml::encode($model->getAttributeLabel('totalRunTime')); ?>: <?php echo $model->getTotalRunTime(); ?></li>
	
</ul>

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