<?php

namespace app\controllers;

use app\forms\ContactForm;
use app\services\contact\ContactService;
use Yii;
use yii\base\Module;
use yii\web\Controller;

class ContactController extends Controller
{
	private $service;
	public function __construct($id, Module $module, array $config = [])
	{
		parent::__construct($id, $module, $config);
		$this->service = new ContactService();
	}

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

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$form = new ContactForm();
		$service = new ContactService();
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {
			try {
				$service->send($form);
				Yii::$app->session->setFlash('success', 'Ваше сообщение отправленно. в ближаайшее время мы с Вами свяжемся');
				return $this->goHome();

			} catch (\Exception $e) {
				Yii::$app->errorHandler->logException($e);
				Yii::$app->session->setFlash('error', $e->getMessage());
			}
		}
		print_r($this->viewPath);
		return $this->render('index', [
			'model' => $form,
		]);

	}

}
