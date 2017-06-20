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
}