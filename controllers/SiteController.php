<?php

namespace app\controllers;

use app\forms\ContactForm;
use app\forms\LoginForm;
use app\forms\PasswordResetForm;
use app\forms\SignupForm;
use app\services\auth\AuthService;
use app\services\auth\PasswordResetServiсe;
use app\services\auth\SignupServiсe;
use app\services\contact\ContactService;
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
				//'class'           => 'yii\captcha\CaptchaAction',
				'class'           => 'app\common\NumericCaptcha',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionIndex()
	{
		$users = [];
		for ($i = 0; $i > 10; $i++) {

		}
		return $this->render('index');
	}

	public function actionAbout()
	{
		return $this->render('about');
	}
}
