<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->protocol_id)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->protocol_id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'protocol_id',
array(
			'name' => 'type',
			'type' => 'raw',
			'value' => $model->type !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->type)), array('cvterm/view', 'id' => GxActiveRecord::extractPkValue($model->type, true))) : null,
			),
array(
			'name' => 'pub',
			'type' => 'raw',
			'value' => $model->pub !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->pub)), array('pub/view', 'id' => GxActiveRecord::extractPkValue($model->pub, true))) : null,
			),
array(
			'name' => 'dbxref',
			'type' => 'raw',
			'value' => $model->dbxref !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->dbxref)), array('dbxref/view', 'id' => GxActiveRecord::extractPkValue($model->dbxref, true))) : null,
			),
'name',
'uri',
'protocoldescription',
'hardwaredescription',
'softwaredescription',
	),
)); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('assays')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->assays as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('assay/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('acquisitions')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->acquisitions as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('acquisition/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('treatments')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->treatments as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('treatment/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('protocolparams')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->protocolparams as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('protocolparam/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('quantifications')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->quantifications as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('quantification/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('arraydesigns')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->arraydesigns as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('arraydesign/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?>