<?php
$this->breadcrumbs=array(
	'Tests',
);

$this->menu=array(
	array('label'=>'Create Tests','url'=>array('create')),
	array('label'=>'Manage Tests','url'=>array('admin')),
);
?>

<h1>Tests</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
