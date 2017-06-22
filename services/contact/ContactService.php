<?php
namespace app\services\contact;

use app\forms\ContactForm;
use RuntimeException;

class ContactService
{
	private $supportEmail;
	private $adminEmail;

	public function __construct($supportEmail,$adminEmail)
	{
		$this->supportEmail = $supportEmail;
		$this->adminEmail= $adminEmail;

	}

	public function send(ContactForm $form)
	{
		$sent = \Yii::$app->mailer->compose()
			->setFrom($this->supportEmail)
			->setTo($this->adminEmail)
			->setSubject($form->subject)
			->setTextBody($form->body)
			->send();
		if (!$sent){
			throw new RuntimeException('Sending error');
		}
	}
}