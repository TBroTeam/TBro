<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Update') . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->biomaterial_id)),
	array('label'=>Yii::t('app', 'Delete') . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->biomaterial_id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'biomaterial_id',
array(
			'name' => 'taxon',
			'type' => 'raw',
			'value' => $model->taxon !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->taxon)), array('organism/view', 'id' => GxActiveRecord::extractPkValue($model->taxon, true))) : null,
			),
array(
			'name' => 'biosourceprovider',
			'type' => 'raw',
			'value' => $model->biosourceprovider !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->biosourceprovider)), array('contact/view', 'id' => GxActiveRecord::extractPkValue($model->biosourceprovider, true))) : null,
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

<h2><?php echo GxHtml::encode($model->getRelationLabel('biomaterialprops')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->biomaterialprops as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('biomaterialprop/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
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
?><h2><?php echo GxHtml::encode($model->getRelationLabel('biomaterialTreatments')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->biomaterialTreatments as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('biomaterialTreatment/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('biomaterialRelationships')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->biomaterialRelationships as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('biomaterialRelationship/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('biomaterialRelationships1')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->biomaterialRelationships1 as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('biomaterialRelationship/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
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