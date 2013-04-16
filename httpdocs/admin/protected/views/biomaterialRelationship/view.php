<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->biomaterial_relationship_id)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->biomaterial_relationship_id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'biomaterial_relationship_id',
array(
			'name' => 'subject',
			'type' => 'raw',
			'value' => $model->subject !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->subject)), array('biomaterial/view', 'id' => GxActiveRecord::extractPkValue($model->subject, true))) : null,
			),
array(
			'name' => 'type',
			'type' => 'raw',
			'value' => $model->type !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->type)), array('cvterm/view', 'id' => GxActiveRecord::extractPkValue($model->type, true))) : null,
			),
array(
			'name' => 'object',
			'type' => 'raw',
			'value' => $model->object !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->object)), array('biomaterial/view', 'id' => GxActiveRecord::extractPkValue($model->object, true))) : null,
			),
	),
)); ?>

