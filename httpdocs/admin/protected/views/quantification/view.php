<?php
$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->quantification_id)),
    array('label' => Yii::t('app', 'Delete') . ' ' . $model->label(), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->quantification_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'quantification_id',
        'name',
        'quantificationdate',
        array(
            'name' => 'acquisition',
            'type' => 'raw',
            'value' => $model->acquisition !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->acquisition)), array('acquisition/view', 'id' => GxActiveRecord::extractPkValue($model->acquisition, true))) : null,
        ),
        array(
            'name' => 'operator',
            'type' => 'raw',
            'value' => $model->operator !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->operator)), array('contact/view', 'id' => GxActiveRecord::extractPkValue($model->operator, true))) : null,
        ),
        array(
            'name' => 'protocol',
            'type' => 'raw',
            'value' => $model->protocol !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->protocol)), array('protocol/view', 'id' => GxActiveRecord::extractPkValue($model->protocol, true))) : null,
        ),
        array(
            'name' => 'analysis',
            'type' => 'raw',
            'value' => $model->analysis !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->analysis)), array('analysis/view', 'id' => GxActiveRecord::extractPkValue($model->analysis, true))) : null,
        ),
        'uri',
    ),
));
?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('quantificationRelationships')); ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->quantificationRelationships as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('quantificationRelationship/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('quantificationRelationships1')); ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->quantificationRelationships1 as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('quantificationRelationship/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?><h2><?php echo GxHtml::encode($model->getRelationLabel('quantificationprops')); ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->quantificationprops as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('quantificationprop/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?>