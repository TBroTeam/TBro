<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'acquisition-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'assay_id'); ?>
		<?php echo $form->dropDownList($model, 'assay_id', GxHtml::listDataEx(Assay::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'assay_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'protocol_id'); ?>
		<?php echo $form->dropDownList($model, 'protocol_id', GxHtml::listDataEx(Protocol::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'protocol_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'channel_id'); ?>
		<?php echo $form->dropDownList($model, 'channel_id', GxHtml::listDataEx(Channel::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'channel_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'acquisitiondate'); ?>
		<?php echo $form->textField($model, 'acquisitiondate'); ?>
		<?php echo $form->error($model,'acquisitiondate'); ?>
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

		<label><?php echo GxHtml::encode($model->getRelationLabel('acquisitionprops')); ?></label>
		<?php echo $form->checkBoxList($model, 'acquisitionprops', GxHtml::encodeEx(GxHtml::listDataEx(Acquisitionprop::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('acquisitionRelationships')); ?></label>
		<?php echo $form->checkBoxList($model, 'acquisitionRelationships', GxHtml::encodeEx(GxHtml::listDataEx(AcquisitionRelationship::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('acquisitionRelationships1')); ?></label>
		<?php echo $form->checkBoxList($model, 'acquisitionRelationships1', GxHtml::encodeEx(GxHtml::listDataEx(AcquisitionRelationship::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('quantifications')); ?></label>
		<?php echo $form->checkBoxList($model, 'quantifications', GxHtml::encodeEx(GxHtml::listDataEx(Quantification::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->