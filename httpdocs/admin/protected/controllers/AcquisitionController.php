<?php

class AcquisitionController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Acquisition'),
		));
	}

	public function actionCreate() {
		$model = new Acquisition;


		if (isset($_POST['Acquisition'])) {
			$model->setAttributes($_POST['Acquisition']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->acquisition_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Acquisition');


		if (isset($_POST['Acquisition'])) {
			$model->setAttributes($_POST['Acquisition']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->acquisition_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Acquisition')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Acquisition');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Acquisition('search');
		$model->unsetAttributes();

		if (isset($_GET['Acquisition']))
			$model->setAttributes($_GET['Acquisition']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}