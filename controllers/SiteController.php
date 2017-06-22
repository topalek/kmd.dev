<?php

namespace app\controllers;

use app\forms\ContactForm;
use app\forms\LoginForm;
use app\forms\PasswordResetForm;
use app\forms\SignupForm;
use app\services\auth\PasswordResetServiсe;
use app\services\auth\SignupServiсe;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
	/**
	 * @inheritdoc
	 */
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
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error'   => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class'           => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$users = [];
		for ($i =0; $i>10; $i++){

		}
		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin()
	{
		$this->layout = 'main-login';
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}
		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * Displays contact page.
	 *
	 * @return Response|string
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}
		return $this->render('contact', [
			'model' => $model,
		]);
	}

	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}

	public function actionResetPassword($token)
	{
		$service = new PasswordResetServiсe();
		try {
			$service->validateToken($token);
		} catch (\DomainException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}
		$form = new PasswordResetForm();
		if ($form->load(Yii::$app->request->post()) && $form->validate()){
			try{
				(new PasswordResetServiсe())->reset($token, $form);
				Yii::$app->session->setFlash('success','Новый пароль сохранен');
			}catch (\DomainException $e){
				Yii::$app->errorHandler->logException($e);
				Yii::$app->session->setFlash('error',$e->getMessage());
			}
			return $this->goHome();
		}
		return $this->render('forms/resetPassword', [
			'model' => $form,
		]);
	}

}
