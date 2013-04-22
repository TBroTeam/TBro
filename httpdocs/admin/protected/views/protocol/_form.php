<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'protocol-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>

		<div class="row">
                <?php if ($model->type_id==null) $model->type_id=1;?>
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->textField($model, 'type_id');?>
		<?php echo $form->error($model,'type_id'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'pub_id'); ?>
		<?php echo $form->dropDownList($model, 'pub_id', GxHtml::listDataEx(Pub::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'pub_id'); ?>
		</div><!-- row -->
		<?php /*<div class="row">
		<?php echo $form->labelEx($model,'dbxref_id'); ?>
		<?php echo $form->dropDownList($model, 'dbxref_id', GxHtml::listDataEx(Dbxref::model()->findAllAttributes(null, true))); ?>
		<?php echo $form->error($model,'dbxref_id'); ?>
		</div><!-- row -->
                 */ ?>
		<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name'); ?>
		<?php echo $form->error($model,'name'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'uri'); ?>
		<?php echo $form->textArea($model, 'uri'); ?>
		<?php echo $form->error($model,'uri'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'protocoldescription'); ?>
		<?php echo $form->textArea($model, 'protocoldescription'); ?>
		<?php echo $form->error($model,'protocoldescription'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'hardwaredescription'); ?>
		<?php echo $form->textArea($model, 'hardwaredescription'); ?>
		<?php echo $form->error($model,'hardwaredescription'); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,'softwaredescription'); ?>
		<?php echo $form->textArea($model, 'softwaredescription'); ?>
		<?php echo $form->error($model,'softwaredescription'); ?>
		</div><!-- row -->

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->