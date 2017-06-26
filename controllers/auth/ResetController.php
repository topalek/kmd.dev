<?php

namespace app\controllers\auth;

use app\forms\PasswordResetRequestForm;
use app\services\auth\PasswordResetService;
use Yii;
use yii\base\Module;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class ResetController extends Controller
{
	private $service;
	public function __construct($id, Module $module, array $config = [])
	{
		parent::__construct($id, $module, $config);
		$this->service = new PasswordResetService();
	}



	public function actionRequest()
	{
		$form = new PasswordResetRequestForm();
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			try {
				$this->service->request($form);
				Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
				return $this->goHome();
			} catch (\DomainException $e) {
				Yii::$app->errorHandler->logException($e);
				Yii::$app->session->setFlash('error', $e->getMessage());
			}
		}

		return $this->render('request', [
			'model' => $form,
		]);
	}

	public function actionConfirm($token)
	{
		try {
			$this->service->validateToken($token);
		} catch (\DomainException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		$form = new PasswordResetRequestForm();
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			try {
				$this->service->reset($token, $form);
				Yii::$app->session->setFlash('success', 'New password saved.');
			} catch (\DomainException $e) {
				Yii::$app->errorHandler->logException($e);
				Yii::$app->session->setFlash('error', $e->getMessage());
			}
			return $this->goHome();
		}

		return $this->render('confirm', [
			'model' => $form,
		]);
	}

}
