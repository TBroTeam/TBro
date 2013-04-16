<?php

class ContactController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Contact'),
		));
	}

	public function actionCreate() {
		$model = new Contact;


		if (isset($_POST['Contact'])) {
			$model->setAttributes($_POST['Contact']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->contact_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Contact');


		if (isset($_POST['Contact'])) {
			$model->setAttributes($_POST['Contact']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->contact_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Contact')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Contact');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Contact('search');
		$model->unsetAttributes();

		if (isset($_GET['Contact']))
			$model->setAttributes($_GET['Contact']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}