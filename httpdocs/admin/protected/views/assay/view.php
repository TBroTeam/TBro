<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->assay_id)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->assay_id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'assay_id',
array(
			'name' => 'arraydesign',
			'type' => 'raw',
			'value' => $model->arraydesign !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->arraydesign)), array('arraydesign/view', 'id' => GxActiveRecord::extractPkValue($model->arraydesign, true))) : null,
			),
array(
			'name' => 'protocol',
			'type' => 'raw',
			'value' => $model->protocol !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->protocol)), array('protocol/view', 'id' => GxActiveRecord::extractPkValue($model->protocol, true))) : null,
			),
'assaydate',
'arrayidentifier',
'arraybatchidentifier',
array(
			'name' => 'operator',
			'type' => 'raw',
			'value' => $model->operator !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->operator)), array('contact/view', 'id' => GxActiveRecord::extractPkValue($model->operator, true))) : null,
			),
array(
			'name' => 'dbxref',
			'type' => 'raw',
			'value' => $model->dbxref !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->dbxref)), array('dbxref/view', 'id' => GxActiveRecord::extractPkValue($model->dbxref, true))) : null,
			),
'name',
'description',
	),
)); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('studyAssays')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->studyAssays as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('studyAssay/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
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
?><h2><?php echo GxHtml::encode($model->getRelationLabel('studyfactorvalues')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->studyfactorvalues as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('studyfactorvalue/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('controls')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->controls as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('control/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('assayProjects')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->assayProjects as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('assayProject/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('assayprops')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->assayprops as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('assayprop/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('assayBiomaterials')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->assayBiomaterials as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('assayBiomaterial/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?>