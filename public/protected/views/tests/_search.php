<?php
/* @var $this TestsController */
/* @var $model Tests */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crunch_file'); ?>
		<?php echo $form->textField($model,'crunch_file',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'display_file'); ?>
		<?php echo $form->textField($model,'display_file',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'crunches_required'); ?>
		<?php echo $form->textField($model,'crunches_required'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_crunched'); ?>
		<?php echo $form->textField($model,'last_crunched'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'completed'); ?>
		<?php echo $form->textField($model,'completed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tbl_users_id'); ?>
		<?php echo $form->textField($model,'tbl_users_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->