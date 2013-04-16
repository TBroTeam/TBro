<?php

Yii::import('application.models._base.BaseContactRelationship');

class ContactRelationship extends BaseContactRelationship
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}