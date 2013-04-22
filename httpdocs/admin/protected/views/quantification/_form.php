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
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name'); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'uri'); ?>
		<?php echo $form->textField($model, 'uri'); ?>
		<?php echo $form->error($model,'uri'); ?>
		</div><!-- row -->
                <div class="row">
		<?php echo $form->labelEx($model,'quantificationdate'); ?>
		<?php echo $form->textField($model, 'quantificationdate'); ?>
		<?php echo $form->error($model,'quantificationdate'); ?>
		</div><!-- row -->
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
		

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->