<?php

namespace app\controllers\auth;

use app\forms\LoginForm;
use app\services\auth\AuthService;
use Yii;
use yii\base\Module;
use yii\web\Controller;

class AuthController extends Controller
{
	private $service;
	public function __construct($id, Module $module, array $config = [])
	{
		parent::__construct($id, $module, $config);
		$this->service = new AuthService();
	}
	/**
	 * @inheritdoc

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only'  => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow'   => true,
						'roles'   => ['@'],
					],
				],
			],
			'verbs'  => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}*/


	public function index()
	{
		print_r($this->viewPath);
	}

	public function actionLogin()
	{
		$this->layout = 'main-login';
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$form = new LoginForm();

		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			try {
				$user = $this->service->auth($form);
				Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0 );
				return $this->goBack();
			} catch (\DomainException $e) {
				Yii::$app->session->setFlash('error', $e->getMessage());
			}
		}
		return $this->render('login', [
			'model' => $form,
		]);
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}
}
