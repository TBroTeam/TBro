<?php

Yii::import('application.models._base.BaseChannel');

class Channel extends BaseChannel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}