<?php

class BiomaterialRelationshipController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'BiomaterialRelationship'),
		));
	}

	public function actionCreate() {
		$model = new BiomaterialRelationship;


		if (isset($_POST['BiomaterialRelationship'])) {
			$model->setAttributes($_POST['BiomaterialRelationship']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->biomaterial_relationship_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'BiomaterialRelationship');


		if (isset($_POST['BiomaterialRelationship'])) {
			$model->setAttributes($_POST['BiomaterialRelationship']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->biomaterial_relationship_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'BiomaterialRelationship')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('BiomaterialRelationship');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new BiomaterialRelationship('search');
		$model->unsetAttributes();

		if (isset($_GET['BiomaterialRelationship']))
			$model->setAttributes($_GET['BiomaterialRelationship']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}