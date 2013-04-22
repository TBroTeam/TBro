<?php

Yii::import('application.models._base.BaseAssay');

class Assay extends BaseAssay {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function representingColumn() {
        return 'name';
    }

}