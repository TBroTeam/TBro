<?php

Yii::import('application.models._base.BaseControl');

class Control extends BaseControl
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}