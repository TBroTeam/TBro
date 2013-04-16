<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'acquisition_id'); ?>
		<?php echo $form->textField($model, 'acquisition_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'assay_id'); ?>
		<?php echo $form->dropDownList($model, 'assay_id', GxHtml::listDataEx(Assay::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'protocol_id'); ?>
		<?php echo $form->dropDownList($model, 'protocol_id', GxHtml::listDataEx(Protocol::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'channel_id'); ?>
		<?php echo $form->dropDownList($model, 'channel_id', GxHtml::listDataEx(Channel::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'acquisitiondate'); ?>
		<?php echo $form->textField($model, 'acquisitiondate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textArea($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'uri'); ?>
		<?php echo $form->textArea($model, 'uri'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
