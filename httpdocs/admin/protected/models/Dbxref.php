<?php

Yii::import('application.models._base.BaseDbxref');

class Dbxref extends BaseDbxref
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}