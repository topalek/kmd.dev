<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\forms\SignupForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Создать пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <div class="row">
        <div class="col-lg-5">
            <div class="box">
                <div class="box-header with-border">
                    <h1><?= Html::encode($this->title) ?></h1>

                    <p>Заполните соответствующие поля, для того чтобы создать пользователя:</p>
                </div>
                <div class="box-body">
					<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

					<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

					<?= $form->field($model, 'email') ?>

					<?= $form->field($model, 'password')->passwordInput() ?>

                    <div class="form-group">
						<?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>

					<?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>

