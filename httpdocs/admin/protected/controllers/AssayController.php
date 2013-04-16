<?php

class AssayController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Assay'),
		));
	}

	public function actionCreate() {
		$model = new Assay;


		if (isset($_POST['Assay'])) {
			$model->setAttributes($_POST['Assay']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->assay_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Assay');


		if (isset($_POST['Assay'])) {
			$model->setAttributes($_POST['Assay']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->assay_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Assay')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Assay');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Assay('search');
		$model->unsetAttributes();

		if (isset($_GET['Assay']))
			$model->setAttributes($_GET['Assay']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}