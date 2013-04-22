<?php

Yii::import('application.models._base.BaseQuantification');

class Quantification extends BaseQuantification {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function representingColumn() {
        return 'name';
    }

}