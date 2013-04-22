<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'quantification_id'); ?>
		<?php echo $form->textField($model, 'quantification_id'); ?>
	</div>
    
    
	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'quantificationdate'); ?>
		<?php echo $form->textField($model, 'quantificationdate'); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model, 'uri'); ?>
		<?php echo $form->textField($model, 'uri'); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model, 'acquisition_id'); ?>
		<?php echo $form->dropDownList($model, 'acquisition_id', GxHtml::listDataEx(Acquisition::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'operator_id'); ?>
		<?php echo $form->dropDownList($model, 'operator_id', GxHtml::listDataEx(Contact::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'protocol_id'); ?>
		<?php echo $form->dropDownList($model, 'protocol_id', GxHtml::listDataEx(Protocol::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'analysis_id'); ?>
		<?php echo $form->dropDownList($model, 'analysis_id', GxHtml::listDataEx(Analysis::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>
	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
