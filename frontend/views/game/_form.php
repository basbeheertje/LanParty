<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Game */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-form">

    <?php

    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<!--
    <?= $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profile_image')->textInput(['maxlength' => true]) ?>
-->
    <?= $form->field($model, 'profileFile')->fileInput() ?>
    <?= $form->field($model, 'avatarFile')->fileInput() ?>
    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'installation')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
