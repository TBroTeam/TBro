<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'assay-biomaterial-form',
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
		<?php echo $form->labelEx($model,'biomaterial_id'); ?>
		<?php echo $form->dropDownList($model, 'biomaterial_id', GxHtml::listDataEx(Biomaterial::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'biomaterial_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'channel_id'); ?>
		<?php echo $form->dropDownList($model, 'channel_id', GxHtml::listDataEx(Channel::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'channel_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'rank'); ?>
		<?php echo $form->textField($model, 'rank'); ?>
		<?php echo $form->error($model,'rank'); ?>
		</div><!-- row -->


<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->