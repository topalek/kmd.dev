<?php

namespace app\modules\admin\controllers;

use app\forms\PasswordResetForm;
use app\forms\PasswordResetRequestForm;
use app\forms\SignupForm;
use app\services\auth\PasswordResetServiсe;
use app\services\auth\SignupServiсe;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class AdminController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
	public function actionCreateUser()
	{
		$form = new SignupForm();
		if ($form->load(Yii::$app->request->post()) && $form->validate()) {

			try {
				$user = (new SignupServiсe())->signup($form);
				if (Yii::$app->getUser()->login($user)) {
					return $this->goHome();
				}

			} catch (\DomainException $e) {
				Yii::$app->session->setFlash('error', $e->getMessage());
			}
		}

		return $this->render('signup', [
			'model' => $form,
		]);

	}
}
