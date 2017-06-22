<?php
/**
 * Created by Topalek
 * Date: 17.06.2017
 * Time: 13:05
 */

namespace app\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class ImageForm extends Model
{
	/**
	 * @var UploadedFile[]
	 */
	public $files;
	public function rules(): array
	{
		return [
			['files', 'each', 'rule' => ['image']],
		];
	}
	public function beforeValidate(): bool
	{
		if (parent::beforeValidate()) {
			$this->files = UploadedFile::getInstances($this, 'files');
			return true;
		}
		return false;
	}
}
