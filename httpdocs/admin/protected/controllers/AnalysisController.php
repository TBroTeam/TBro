<?php

class AnalysisController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Analysis'),
		));
	}

	public function actionCreate() {
		$model = new Analysis;


		if (isset($_POST['Analysis'])) {
			$model->setAttributes($_POST['Analysis']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->analysis_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Analysis');


		if (isset($_POST['Analysis'])) {
			$model->setAttributes($_POST['Analysis']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->analysis_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Analysis')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Analysis');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Analysis('search');
		$model->unsetAttributes();

		if (isset($_GET['Analysis']))
			$model->setAttributes($_GET['Analysis']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}