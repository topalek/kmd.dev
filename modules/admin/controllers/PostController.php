<?php

namespace app\modules\admin\controllers;

use app\entities\Post;
use app\entities\PostSearch;
use app\services\manage\PostManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
	private $service;
	public function __construct($id, $module, PostManageService $service, $config = [])
	{
		parent::__construct($id, $module, $config);
		$this->service = $service;
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete'          => ['POST'],
					'delete-image'    => ['POST'],
					'move-image-up'   => ['POST'],
					'move-image-down' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all Post models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new PostSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Post model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Post model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Post();

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			try {
				return $this->redirect(['view', 'id' => $model->id]);
			} catch (\DomainException $e) {
				Yii::$app->errorHandler->logException($e);
Yii::$app->session->setFlash('error',$e->getMessage());
}
}
return $this->render('create', [
	'model' => $model,
]);

}

/**
 * Updates an existing Post model.
 * If update is successful, the browser will be redirected to the 'view' page.
 * @param integer $id
 * @return mixed
 */
public function actionUpdate($id)
{
	$model = $this->findModel($id);

	if ($model->load(Yii::$app->request->post()) && $model->save()) {
		return $this->redirect(['view', 'id' => $model->id]);
	} else {
		return $this->render('update', [
			'model' => $model,
		]);
	}
}

/**
 * Deletes an existing Post model.
 * If deletion is successful, the browser will be redirected to the 'index' page.
 * @param integer $id
 * @return mixed
 */
public function actionDelete($id)
{
	$this->findModel($id)->delete();

	return $this->redirect(['index']);
}

/**
 * Finds the Post model based on its primary key value.
 * If the model is not found, a 404 HTTP exception will be thrown.
 * @param integer $id
 * @return Post the loaded model
 * @throws NotFoundHttpException if the model cannot be found
 */
protected function findModel($id)
{
	if (($model = Post::findOne($id)) !== null) {
		return $model;
	} else {
		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
}
