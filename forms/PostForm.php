<?php
/**
 * Created by Topalek
 * Date: 17.06.2017
 * Time: 13:05
 */

namespace app\forms;

use app\entities\Image;


/**
 * @var string $slug
 * @var string $title
 * @var string $short_content
 * @var string $content
 * @var string $images
 *
 *

 * @property Image[] $images
 * @property Image $mainPhoto
 */
class PostForm extends CompositeForm
{

	public function __construct($config = [])
	{
		//$this->slug = $slug;
		//$this->title = $title;
		//$this->short_content = $short_content;
		//$this->content = $content;
		//$this->images = $images;

		parent::__construct($config);
	}

	public function rules(): array
	{
		return [
			[['slug', 'title'], 'required'],
			[['content', 'short_content'], 'string'],
			[['category_id', 'status'], 'integer'],
			[['slug', 'title', 'type', 'images'], 'string', 'max' => 255],
			[['slug'], 'unique'],
		];
	}

	protected function internalForms(): array
	{
		return ['photos'];
	}
}
