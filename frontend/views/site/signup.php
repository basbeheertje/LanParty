<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('frontend','Signup') . ' | ' .  Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?php echo Yii::t('frontend','Registrate'); ?></h1>

    <p><?php Yii::t('frontend','Please fill out the following fields to signup:'); ?></p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->input('text', ['placeholder' => Yii::t('frontend', "Username")])->label(false); ?>

            <?= $form->field($model, 'email')->input('email', ['placeholder' => Yii::t('frontend', "Email")])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput()->input('password', ['placeholder' => Yii::t('frontend', "Password")])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('frontend', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
