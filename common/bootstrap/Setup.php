<?php
namespace common\bootstrap;

use Yii;
use yii\base\BootstrapInterface;

class Setup implements BootstrapInterface
{
	public function bootstrap($app)
	{
		$container = Yii::$container;

		$container->setSingleton(\app\services\auth\PasswordResetServiсe::class,[],[
				[$app->params['supportEmail'] => $app->name . ' robot'],
			]);
	}
}