<?php

namespace app\entities;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * This is the model class for table "post".
 *
 * @var integer $id
 * @var string $slug
 * @var string $title
 * @var string $content
 * @var string $short_content
 * @var string $type
 * @var string $main_photo_id
 * @var integer $category_id
 * @var integer $status
 * @var integer $created_at
 * @var integer $updated_at
 *
 * @var Image $image
 *
 * @property Image[] $images
 * @property Category $category
 * @property Category[] $categories
 * @property Image $mainPhoto
 *
 */
class Post extends \yii\db\ActiveRecord
{
	const STATUS_DRAFT = 0;
	const STATUS_ACTIVE = 1;

	public function create($title, $short_content, $content, $category_id,$type): self
	{
		$post = new static();
		$post->title = $title;
		$post->slug = Inflector::slug($title);
		$post->short_content = $short_content;
		$post->content = $content;
		$post->type = $type;
		$post->category_id = $category_id;
		$post->created_at = time();
		$post->status = self::STATUS_DRAFT;
		return $post;
	}
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }


	public function addImage(UploadedFile $file): void
	{
		$images = $this->images;
		$images[] = Image::create($file);
		$this->updateImages($images);
	}
	public function removeImage($id): void
	{
		$images = $this->images;
		foreach ($images as $i => $image) {
			if ($image->isIdEqualTo($id)) {
				unset($images[$i]);
				$this->updateImages($images);
				return;
			}
		}
		throw new \DomainException('Image is not found.');
	}
	public function removeImages(): void
	{
		$this->updateImages([]);
	}
	public function moveImageUp($id): void
	{
		$images = $this->images;
		foreach ($images as $i => $image) {
			if ($image->isIdEqualTo($id)) {
				if ($prev = $images[$i - 1] ?? null) {
					$images[$i - 1] = $image;
					$images[$i] = $prev;
					$this->updateImages($images);
				}
				return;
			}
		}
		throw new \DomainException('Image is not found.');
	}
	public function moveImageDown($id): void
	{
		$images = $this->images;
		foreach ($images as $i => $image) {
			if ($image->isIdEqualTo($id)) {
				if ($next = $images[$i + 1] ?? null) {
					$images[$i] = $next;
					$images[$i + 1] = $image;
					$this->updateImages($images);
				}
				return;
			}
		}
		throw new \DomainException('Image is not found.');
	}
	private function updateImages(array $images): void
	{
		foreach ($images as $i => $image) {
			$image->setSort($i);
		}
		$this->images = $images;
		$this->populateRelation('mainImage', reset($images));
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'short_content' => Yii::t('app', 'Short Content'),
            'type' => Yii::t('app', 'Type'),
            'image' => Yii::t('app', 'Image'),
            'category_id' => Yii::t('app', 'Category ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
			//[
			//	'class' => SaveRelationsBehavior::className();
			//],
		];
	}

    /**
     * @inheritdoc
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }

	public function getImages(): ActiveQuery
	{
		return $this->hasMany(Image::class, ['post_id' => 'id'])->orderBy('sort');
	}
	public function getMainPhoto(): ActiveQuery
	{
		return $this->hasOne(Image::class, ['id' => 'main_photo_id']);
	}
}
