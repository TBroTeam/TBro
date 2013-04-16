<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->assay_biomaterial_id)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->assay_biomaterial_id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'assay_biomaterial_id',
array(
			'name' => 'assay',
			'type' => 'raw',
			'value' => $model->assay !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->assay)), array('assay/view', 'id' => GxActiveRecord::extractPkValue($model->assay, true))) : null,
			),
array(
			'name' => 'biomaterial',
			'type' => 'raw',
			'value' => $model->biomaterial !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->biomaterial)), array('biomaterial/view', 'id' => GxActiveRecord::extractPkValue($model->biomaterial, true))) : null,
			),
array(
			'name' => 'channel',
			'type' => 'raw',
			'value' => $model->channel !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->channel)), array('channel/view', 'id' => GxActiveRecord::extractPkValue($model->channel, true))) : null,
			),
'rank',
	),
)); ?>

