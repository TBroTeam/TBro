<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'contact-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->dropDownList($model, 'type_id', GxHtml::listDataEx(Cvterm::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'type_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model, 'description', array('maxlength' => 255)); ?>
		<?php echo $form->error($model,'description'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('assays')); ?></label>
		<?php echo $form->checkBoxList($model, 'assays', GxHtml::encodeEx(GxHtml::listDataEx(Assay::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('studies')); ?></label>
		<?php echo $form->checkBoxList($model, 'studies', GxHtml::encodeEx(GxHtml::listDataEx(Study::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('projectContacts')); ?></label>
		<?php echo $form->checkBoxList($model, 'projectContacts', GxHtml::encodeEx(GxHtml::listDataEx(ProjectContact::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('quantifications')); ?></label>
		<?php echo $form->checkBoxList($model, 'quantifications', GxHtml::encodeEx(GxHtml::listDataEx(Quantification::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('contactRelationships')); ?></label>
		<?php echo $form->checkBoxList($model, 'contactRelationships', GxHtml::encodeEx(GxHtml::listDataEx(ContactRelationship::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('contactRelationships1')); ?></label>
		<?php echo $form->checkBoxList($model, 'contactRelationships1', GxHtml::encodeEx(GxHtml::listDataEx(ContactRelationship::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('biomaterials')); ?></label>
		<?php echo $form->checkBoxList($model, 'biomaterials', GxHtml::encodeEx(GxHtml::listDataEx(Biomaterial::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('arraydesigns')); ?></label>
		<?php echo $form->checkBoxList($model, 'arraydesigns', GxHtml::encodeEx(GxHtml::listDataEx(Arraydesign::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->