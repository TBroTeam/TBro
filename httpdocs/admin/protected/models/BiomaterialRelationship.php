<?php

Yii::import('application.models._base.BaseBiomaterialRelationship');

class BiomaterialRelationship extends BaseBiomaterialRelationship {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
                    'subject_id' => 'Child',
                    'object_id' => 'Parent',
                    'object' => 'Parent',
                    'subject' => 'Child',
                        )
        );
    }

}