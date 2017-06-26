<?php

namespace app\controllers\auth;

use app\forms\SignupForm;
use app\services\auth\SignupService;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;

class SignupController extends Controller
{
	private $service;

	public function __construct($id, Module $module, array $config = [])
	{
		parent::__construct($id, $module, $config);
		$this->service = new SignupService();
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only'  => ['request'],
				'rules' => [
					[
						'actions' => ['request'],
						'allow'   => true,
						'roles'   => ['?'],
					],
				],
			],
		];
	}

	public function actionRequest()
	{
		$form = new SignupForm();
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			try {
				$this->service->signup($form);
				Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
				return $this->goHome();
			} catch (\DomainException $e) {
				Yii::$app->errorHandler->logException($e);
				Yii::$app->session->setFlash('error', $e->getMessage());
			}
		}
		return $this->render('signup', ['model' => $form]);
	}

	public function actionConfirm($token)
	{
		try {
			$this->service->confirm($token);
			Yii::$app->session->setFlash('success', 'Your email is confirmed.');
			return $this->redirect(['auth/auth/login']);
		} catch (\DomainException $e) {
			Yii::$app->errorHandler->logException($e);
			Yii::$app->session->setFlash('error', $e->getMessage());
		}
		return $this->goHome();
	}
}
