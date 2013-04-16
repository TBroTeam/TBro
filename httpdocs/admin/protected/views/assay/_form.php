<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'assay-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'arraydesign_id'); ?>
		<?php echo $form->dropDownList($model, 'arraydesign_id', GxHtml::listDataEx(Arraydesign::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'arraydesign_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'protocol_id'); ?>
		<?php echo $form->dropDownList($model, 'protocol_id', GxHtml::listDataEx(Protocol::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'protocol_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'assaydate'); ?>
		<?php echo $form->textField($model, 'assaydate'); ?>
		<?php echo $form->error($model,'assaydate'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'arrayidentifier'); ?>
		<?php echo $form->textArea($model, 'arrayidentifier'); ?>
		<?php echo $form->error($model,'arrayidentifier'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'arraybatchidentifier'); ?>
		<?php echo $form->textArea($model, 'arraybatchidentifier'); ?>
		<?php echo $form->error($model,'arraybatchidentifier'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'operator_id'); ?>
		<?php echo $form->dropDownList($model, 'operator_id', GxHtml::listDataEx(Contact::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'operator_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textArea($model, 'name'); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model, 'description'); ?>
		<?php echo $form->error($model,'description'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('studyAssays')); ?></label>
		<?php echo $form->checkBoxList($model, 'studyAssays', GxHtml::encodeEx(GxHtml::listDataEx(StudyAssay::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('acquisitions')); ?></label>
		<?php echo $form->checkBoxList($model, 'acquisitions', GxHtml::encodeEx(GxHtml::listDataEx(Acquisition::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('studyfactorvalues')); ?></label>
		<?php echo $form->checkBoxList($model, 'studyfactorvalues', GxHtml::encodeEx(GxHtml::listDataEx(Studyfactorvalue::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('controls')); ?></label>
		<?php echo $form->checkBoxList($model, 'controls', GxHtml::encodeEx(GxHtml::listDataEx(Control::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('assayProjects')); ?></label>
		<?php echo $form->checkBoxList($model, 'assayProjects', GxHtml::encodeEx(GxHtml::listDataEx(AssayProject::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('assayprops')); ?></label>
		<?php echo $form->checkBoxList($model, 'assayprops', GxHtml::encodeEx(GxHtml::listDataEx(Assayprop::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('assayBiomaterials')); ?></label>
		<?php echo $form->checkBoxList($model, 'assayBiomaterials', GxHtml::encodeEx(GxHtml::listDataEx(AssayBiomaterial::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->