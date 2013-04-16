<?php

Yii::import('application.models._base.BaseTreatment');

class Treatment extends BaseTreatment
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}