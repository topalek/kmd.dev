<?php
/**
 * Created by Topalek
 * Date: 20.06.2017
 * Time: 13:09
 */

namespace app\entities;
/*
 * @var integer $id
 * @var integer $file
 * @var integer $sort
 */

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

class Image extends ActiveRecord
{

	public static function create(UploadedFile $file): self
	{
		$image = new static();
		$image->file = $file;
		return $image;
	}

	public function setSort($sort): void
	{
		$this->sort = $sort;
	}

	public function isIdEqualTo($id): bool
	{
		return $this->id == $id;
	}

	public static function tableName()
	{
		return '{{%image}}';
	}
	public function behaviors(): array
	{
		return [
			[
				'class' => ImageUploadBehavior::className(),
				'attribute' => 'file',
				'createThumbsOnRequest' => true,
				'filePath' => '@web/uploads/products/[[attribute_product_id]]/[[id]].[[extension]]',
				'fileUrl' => '@web/uploads/products/[[attribute_product_id]]/[[id]].[[extension]]',
				'thumbPath' => '@web/uploads/thumbs/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
				'thumbUrl' => '@seb/uploads/thumbs/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
				'thumbs' => [
					'admin' => ['width' => 100, 'height' => 70],
					'thumb' => ['width' => 640, 'height' => 480],
				],
			],
		];
	}
}