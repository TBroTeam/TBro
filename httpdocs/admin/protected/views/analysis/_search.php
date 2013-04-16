<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'analysis_id'); ?>
		<?php echo $form->textField($model, 'analysis_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'program'); ?>
		<?php echo $form->textField($model, 'program', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'programversion'); ?>
		<?php echo $form->textField($model, 'programversion', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'algorithm'); ?>
		<?php echo $form->textField($model, 'algorithm', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'sourcename'); ?>
		<?php echo $form->textField($model, 'sourcename', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'sourceversion'); ?>
		<?php echo $form->textField($model, 'sourceversion', array('maxlength' => 255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'sourceuri'); ?>
		<?php echo $form->textArea($model, 'sourceuri'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'timeexecuted'); ?>
		<?php echo $form->textField($model, 'timeexecuted'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
