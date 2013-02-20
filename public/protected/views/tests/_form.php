<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tests-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'crunch_file',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'display_file',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'crunches_required',array('class'=>'span5')); ?>

	<?php /*<?php echo $form->textFieldRow($model,'last_crunched',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'completed',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tbl_users_id',array('class'=>'span5')); ?> */ ?>

	<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
