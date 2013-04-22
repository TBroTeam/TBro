<?php

Yii::import('application.models._base.BaseAssayBiomaterial');

class AssayBiomaterial extends BaseAssayBiomaterial {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
                    'biomaterialRelationships' => 'Children',
                    'biomaterialRelationships1' => 'Parents',
                        )
        );
    }

}