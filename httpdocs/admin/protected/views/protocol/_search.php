<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'protocol_id'); ?>
		<?php echo $form->textField($model, 'protocol_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'type_id'); ?>
		<?php echo $form->dropDownList($model, 'type_id', GxHtml::listDataEx(Cvterm::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'pub_id'); ?>
		<?php echo $form->dropDownList($model, 'pub_id', GxHtml::listDataEx(Pub::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'dbxref_id'); ?>
		<?php echo $form->dropDownList($model, 'dbxref_id', GxHtml::listDataEx(Dbxref::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textArea($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'uri'); ?>
		<?php echo $form->textArea($model, 'uri'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'protocoldescription'); ?>
		<?php echo $form->textArea($model, 'protocoldescription'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'hardwaredescription'); ?>
		<?php echo $form->textArea($model, 'hardwaredescription'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'softwaredescription'); ?>
		<?php echo $form->textArea($model, 'softwaredescription'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
