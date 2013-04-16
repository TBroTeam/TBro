<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'biomaterial_relationship_id'); ?>
		<?php echo $form->textField($model, 'biomaterial_relationship_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'subject_id'); ?>
		<?php echo $form->dropDownList($model, 'subject_id', GxHtml::listDataEx(Biomaterial::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'type_id'); ?>
		<?php echo $form->dropDownList($model, 'type_id', GxHtml::listDataEx(Cvterm::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'object_id'); ?>
		<?php echo $form->dropDownList($model, 'object_id', GxHtml::listDataEx(Biomaterial::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
