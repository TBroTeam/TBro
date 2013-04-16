<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'quantification-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'acquisition_id'); ?>
		<?php echo $form->dropDownList($model, 'acquisition_id', GxHtml::listDataEx(Acquisition::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'acquisition_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'operator_id'); ?>
		<?php echo $form->dropDownList($model, 'operator_id', GxHtml::listDataEx(Contact::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'operator_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'protocol_id'); ?>
		<?php echo $form->dropDownList($model, 'protocol_id', GxHtml::listDataEx(Protocol::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'protocol_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'analysis_id'); ?>
		<?php echo $form->dropDownList($model, 'analysis_id', GxHtml::listDataEx(Analysis::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'analysis_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'quantificationdate'); ?>
		<?php echo $form->textField($model, 'quantificationdate'); ?>
		<?php echo $form->error($model,'quantificationdate'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textArea($model, 'name'); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'uri'); ?>
		<?php echo $form->textArea($model, 'uri'); ?>
		<?php echo $form->error($model,'uri'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('quantificationRelationships')); ?></label>
		<?php echo $form->checkBoxList($model, 'quantificationRelationships', GxHtml::encodeEx(GxHtml::listDataEx(QuantificationRelationship::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('quantificationRelationships1')); ?></label>
		<?php echo $form->checkBoxList($model, 'quantificationRelationships1', GxHtml::encodeEx(GxHtml::listDataEx(QuantificationRelationship::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('quantificationprops')); ?></label>
		<?php echo $form->checkBoxList($model, 'quantificationprops', GxHtml::encodeEx(GxHtml::listDataEx(Quantificationprop::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->