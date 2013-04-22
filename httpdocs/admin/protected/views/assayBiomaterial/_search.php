<div class="wide form">

<?php $form = $this->beginWidget('GxActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'assay_biomaterial_id'); ?>
		<?php echo $form->textField($model, 'assay_biomaterial_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'assay_id'); ?>
		<?php echo $form->dropDownList($model, 'assay_id', GxHtml::listDataEx(Assay::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'biomaterial_id'); ?>
		<?php echo $form->dropDownList($model, 'biomaterial_id', GxHtml::listDataEx(Biomaterial::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div>

	<?php /** <div class="row">
		<?php echo $form->label($model, 'channel_id'); ?>
		<?php echo $form->dropDownList($model, 'channel_id', GxHtml::listDataEx(Channel::model()->findAllAttributes(null, true)), array('prompt' => Yii::t('app', 'All'))); ?>
	</div> */ ?>

	<div class="row">
		<?php echo $form->label($model, 'rank'); ?>
		<?php echo $form->textField($model, 'rank'); ?>
	</div>

	<div class="row buttons">
		<?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
