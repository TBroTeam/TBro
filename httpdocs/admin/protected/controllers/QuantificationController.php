<?php

class QuantificationController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Quantification'),
		));
	}

	public function actionCreate() {
		$model = new Quantification;


		if (isset($_POST['Quantification'])) {
			$model->setAttributes($_POST['Quantification']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->quantification_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Quantification');


		if (isset($_POST['Quantification'])) {
			$model->setAttributes($_POST['Quantification']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->quantification_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Quantification')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Quantification');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Quantification('search');
		$model->unsetAttributes();

		if (isset($_GET['Quantification']))
			$model->setAttributes($_GET['Quantification']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}