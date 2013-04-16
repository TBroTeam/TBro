<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'biomaterial-relationship-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
		<?php echo $form->labelEx($model,'subject_id'); ?>
		<?php echo $form->dropDownList($model, 'subject_id', GxHtml::listDataEx(Biomaterial::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'subject_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->dropDownList($model, 'type_id', GxHtml::listDataEx(Cvterm::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'type_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'object_id'); ?>
		<?php echo $form->dropDownList($model, 'object_id', GxHtml::listDataEx(Biomaterial::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'object_id'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->