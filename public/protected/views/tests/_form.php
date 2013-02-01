<?php
/* @var $this TestsController */
/* @var $model Tests */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tests-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crunch_file'); ?>
		<?php echo $form->textField($model,'crunch_file',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'crunch_file'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'display_file'); ?>
		<?php echo $form->textField($model,'display_file',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'display_file'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'crunches_required'); ?>
		<?php echo $form->textField($model,'crunches_required'); ?>
		<?php echo $form->error($model,'crunches_required'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_crunched'); ?>
		<?php echo $form->textField($model,'last_crunched'); ?>
		<?php echo $form->error($model,'last_crunched'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'completed'); ?>
		<?php echo $form->textField($model,'completed'); ?>
		<?php echo $form->error($model,'completed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tbl_users_id'); ?>
		<?php echo $form->textField($model,'tbl_users_id'); ?>
		<?php echo $form->error($model,'tbl_users_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->