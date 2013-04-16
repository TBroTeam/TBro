<?php

class BiomaterialController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Biomaterial'),
		));
	}

	public function actionCreate() {
		$model = new Biomaterial;


		if (isset($_POST['Biomaterial'])) {
			$model->setAttributes($_POST['Biomaterial']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->biomaterial_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Biomaterial');


		if (isset($_POST['Biomaterial'])) {
			$model->setAttributes($_POST['Biomaterial']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->biomaterial_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Biomaterial')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Biomaterial');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Biomaterial('search');
		$model->unsetAttributes();

		if (isset($_GET['Biomaterial']))
			$model->setAttributes($_GET['Biomaterial']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}