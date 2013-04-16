<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'biomaterial-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'taxon_id'); ?>
		<?php echo $form->dropDownList($model, 'taxon_id', GxHtml::listDataEx(Organism::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'taxon_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'biosourceprovider_id'); ?>
		<?php echo $form->dropDownList($model, 'biosourceprovider_id', GxHtml::listDataEx(Contact::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'biosourceprovider_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model, 'description'); ?>
		<?php echo $form->error($model,'description'); ?>
		</div><!-- row -->

		<label><?php echo GxHtml::encode($model->getRelationLabel('biomaterialprops')); ?></label>
		<?php echo $form->checkBoxList($model, 'biomaterialprops', GxHtml::encodeEx(GxHtml::listDataEx(Biomaterialprop::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('treatments')); ?></label>
		<?php echo $form->checkBoxList($model, 'treatments', GxHtml::encodeEx(GxHtml::listDataEx(Treatment::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('biomaterialTreatments')); ?></label>
		<?php echo $form->checkBoxList($model, 'biomaterialTreatments', GxHtml::encodeEx(GxHtml::listDataEx(BiomaterialTreatment::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('biomaterialRelationships')); ?></label>
		<?php echo $form->checkBoxList($model, 'biomaterialRelationships', GxHtml::encodeEx(GxHtml::listDataEx(BiomaterialRelationship::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('biomaterialRelationships1')); ?></label>
		<?php echo $form->checkBoxList($model, 'biomaterialRelationships1', GxHtml::encodeEx(GxHtml::listDataEx(BiomaterialRelationship::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('biomaterialDbxrefs')); ?></label>
		<?php echo $form->checkBoxList($model, 'biomaterialDbxrefs', GxHtml::encodeEx(GxHtml::listDataEx(BiomaterialDbxref::model()->findAllAttributes(null, true)), false, true)); ?>
		<label><?php echo GxHtml::encode($model->getRelationLabel('assayBiomaterials')); ?></label>
		<?php echo $form->checkBoxList($model, 'assayBiomaterials', GxHtml::encodeEx(GxHtml::listDataEx(AssayBiomaterial::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->