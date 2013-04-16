<?php

class AssayBiomaterialController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'AssayBiomaterial'),
		));
	}

	public function actionCreate() {
		$model = new AssayBiomaterial;


		if (isset($_POST['AssayBiomaterial'])) {
			$model->setAttributes($_POST['AssayBiomaterial']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->assay_biomaterial_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'AssayBiomaterial');


		if (isset($_POST['AssayBiomaterial'])) {
			$model->setAttributes($_POST['AssayBiomaterial']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->assay_biomaterial_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'AssayBiomaterial')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('AssayBiomaterial');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new AssayBiomaterial('search');
		$model->unsetAttributes();

		if (isset($_GET['AssayBiomaterial']))
			$model->setAttributes($_GET['AssayBiomaterial']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}