<?php
$this->breadcrumbs=array(
	'Tasks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tasks','url'=>array('index')),
);
?>

<h1>Create Task</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>