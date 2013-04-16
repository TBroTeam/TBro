<?php

Yii::import('application.models._base.BaseOrganism');

class Organism extends BaseOrganism
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}