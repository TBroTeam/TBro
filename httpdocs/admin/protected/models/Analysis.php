<?php

Yii::import('application.models._base.BaseAnalysis');

class Analysis extends BaseAnalysis
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}