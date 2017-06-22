<?php
/**
 * Created by Topalek
 * Date: 19.06.2017
 * Time: 15:05
 */

namespace app\services\manage;


use app\entities\Post;
use app\entities\User;
use app\forms\PostForm;

class PostManageService {

public function create(PostForm $form): Post
{
	$slug = $this->slug->get($form->slug);
	$title = $this->title->get($form->title);
	$post = Post::create(
		$brand->id,
		$category->id,
		$form->code,
		$form->name,
		$form->description,
		$form->weight,
		$form->quantity->quantity,
		new Meta(
			$form->meta->title,
			$form->meta->description,
			$form->meta->keywords
		)
	);
	$product->setPrice($form->price->new, $form->price->old);
	foreach ($form->categories->others as $otherId) {
		$category = $this->categories->get($otherId);
		$product->assignCategory($category->id);
	}
	foreach ($form->values as $value) {
		$product->setValue($value->id, $value->value);
	}
	foreach ($form->photos->files as $file) {
		$product->addPhoto($file);
	}
	foreach ($form->tags->existing as $tagId) {
		$tag = $this->tags->get($tagId);
		$product->assignTag($tag->id);
	}
	$this->transaction->wrap(function () use ($product, $form) {
		foreach ($form->tags->newNames as $tagName) {
			if (!$tag = $this->tags->findByName($tagName)) {
				$tag = Tag::create($tagName, $tagName);
				$this->tags->save($tag);
			}
			$product->assignTag($tag->id);
		}
		$this->products->save($product);
	});
	return $product;
}
public function edit($id, PostEditForm $form): void
{
	$product = $this->products->get($id);
	$brand = $this->brands->get($form->brandId);
	$category = $this->categories->get($form->categories->main);
	$product->edit(
		$brand->id,
		$form->code,
		$form->name,
		$form->description,
		$form->weight,
		new Meta(
			$form->meta->title,
			$form->meta->description,
			$form->meta->keywords
		)
	);
	$product->changeMainCategory($category->id);
	$this->transaction->wrap(function () use ($product, $form) {
		$product->revokeCategories();
		$product->revokeTags();
		$this->products->save($product);
		foreach ($form->categories->others as $otherId) {
			$category = $this->categories->get($otherId);
			$product->assignCategory($category->id);
		}
		foreach ($form->values as $value) {
			$product->setValue($value->id, $value->value);
		}
		foreach ($form->tags->existing as $tagId) {
			$tag = $this->tags->get($tagId);
			$product->assignTag($tag->id);
		}
		foreach ($form->tags->newNames as $tagName) {
			if (!$tag = $this->tags->findByName($tagName)) {
				$tag = Tag::create($tagName, $tagName);
				$this->tags->save($tag);
			}
			$product->assignTag($tag->id);
		}
		$this->products->save($product);
	});
}
public function changePrice($id, PriceForm $form): void
{
	$product = $this->products->get($id);
	$product->setPrice($form->new, $form->old);
	$this->products->save($product);
}
public function changeQuantity($id, QuantityForm $form): void
{
	$product = $this->products->get($id);
	$product->changeQuantity($form->quantity);
	$this->products->save($product);
}
public function activate($id): void
{
	$product = $this->products->get($id);
	$product->activate();
	$this->products->save($product);
}
public function draft($id): void
{
	$product = $this->products->get($id);
	$product->draft();
	$this->products->save($product);
}
public function addPhotos($id, PhotosForm $form): void
{
	$product = $this->products->get($id);
	foreach ($form->files as $file) {
		$product->addPhoto($file);
	}
	$this->products->save($product);
}
public function movePhotoUp($id, $photoId): void
{
	$product = $this->products->get($id);
	$product->movePhotoUp($photoId);
	$this->products->save($product);
}
public function movePhotoDown($id, $photoId): void
{
	$product = $this->products->get($id);
	$product->movePhotoDown($photoId);
	$this->products->save($product);
}
public function removePhoto($id, $photoId): void
{
	$product = $this->products->get($id);
	$product->removePhoto($photoId);
	$this->products->save($product);
}
public function addRelatedPost($id, $otherId): void
{
	$product = $this->products->get($id);
	$other = $this->products->get($otherId);
	$product->assignRelatedPost($other->id);
	$this->products->save($product);
}
public function removeRelatedPost($id, $otherId): void
{
	$product = $this->products->get($id);
	$other = $this->products->get($otherId);
	$product->revokeRelatedPost($other->id);
	$this->products->save($product);
}
public function addModification($id, ModificationForm $form): void
{
	$product = $this->products->get($id);
	$product->addModification(
		$form->code,
		$form->name,
		$form->price,
		$form->quantity
	);
	$this->products->save($product);
}
public function editModification($id, $modificationId, ModificationForm $form): void
{
	$product = $this->products->get($id);
	$product->editModification(
		$modificationId,
		$form->code,
		$form->name,
		$form->price,
		$form->quantity
	);
	$this->products->save($product);
}
public function removeModification($id, $modificationId): void
{
	$product = $this->products->get($id);
	$product->removeModification($modificationId);
	$this->products->save($product);
}
public function remove($id): void
{
	$product = $this->products->get($id);
	$this->products->remove($product);
}
}