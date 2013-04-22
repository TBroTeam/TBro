<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->acquisition_id)),
    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->acquisition_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'acquisition_id',
        'name',
        'acquisitiondate',
        'uri',
        array(
            'name' => 'assay',
            'type' => 'raw',
            'value' => $model->assay !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->assay)), array('assay/view', 'id' => GxActiveRecord::extractPkValue($model->assay, true))) : null,
        ),
        array(
            'name' => 'protocol',
            'type' => 'raw',
            'value' => $model->protocol !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->protocol)), array('protocol/view', 'id' => GxActiveRecord::extractPkValue($model->protocol, true))) : null,
        ),
    /* array(
      'name' => 'channel',
      'type' => 'raw',
      'value' => $model->channel !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->channel)), array('channel/view', 'id' => GxActiveRecord::extractPkValue($model->channel, true))) : null,
      ), */
    ),
));
?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('acquisitionprops')); ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->acquisitionprops as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('acquisitionprop/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('acquisitionRelationships')); ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->acquisitionRelationships as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('acquisitionRelationship/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('acquisitionRelationships1')); ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->acquisitionRelationships1 as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('acquisitionRelationship/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('quantifications')); ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->quantifications as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('quantification/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?>