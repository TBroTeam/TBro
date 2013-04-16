<?php

Yii::import('application.models._base.BaseStudy');

class Study extends BaseStudy
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}