<?php

class ProtocolController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Protocol'),
		));
	}

	public function actionCreate() {
		$model = new Protocol;


		if (isset($_POST['Protocol'])) {
			$model->setAttributes($_POST['Protocol']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->protocol_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Protocol');


		if (isset($_POST['Protocol'])) {
			$model->setAttributes($_POST['Protocol']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->protocol_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Protocol')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Protocol');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Protocol('search');
		$model->unsetAttributes();

		if (isset($_GET['Protocol']))
			$model->setAttributes($_GET['Protocol']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}