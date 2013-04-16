<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'biomaterial_id'); ?>
		<?php echo $form->textField($model, 'biomaterial_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'taxon_id'); ?>
		<?php echo $form->dropDownList($model, 'taxon_id', GxHtml::listDataEx(Organism::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'biosourceprovider_id'); ?>
		<?php echo $form->dropDownList($model, 'biosourceprovider_id', GxHtml::listDataEx(Contact::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textArea($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
