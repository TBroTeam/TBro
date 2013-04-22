<?php

Yii::import('application.models._base.BaseAcquisition');

class Acquisition extends BaseAcquisition {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function representingColumn() {
        return 'name';
    }

}