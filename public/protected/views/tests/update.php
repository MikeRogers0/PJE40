<?php
$this->breadcrumbs=array(
	'Tasks'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tasks','url'=>array('index')),
	array('label'=>'Create Task','url'=>array('create')),
	array('label'=>'View Task','url'=>array('view','id'=>$model->id)),
);
?>

<h1>Update Task: <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>