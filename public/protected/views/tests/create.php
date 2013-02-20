<?php
$this->breadcrumbs=array(
	'Tests'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tests','url'=>array('index')),
	array('label'=>'Manage Tests','url'=>array('admin')),
);
?>

<h1>Create Tests</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>