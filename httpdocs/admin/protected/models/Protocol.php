<?php

Yii::import('application.models._base.BaseProtocol');

class Protocol extends BaseProtocol
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}