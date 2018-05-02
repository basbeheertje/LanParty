<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="avatar"></div>
    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?php

            echo $form->field($model, 'username')
                ->textInput(['autofocus' => true])
                ->input('text', ['placeholder' => "Username"])
                ->label(false);
            ?>

            <?php

            echo $form->field($model, 'password')
                ->passwordInput()
                ->input('password', ['placeholder' => 'Password'])
                ->label(false);
            ?>

            <?php

            //echo $form->field($model, 'rememberMe')->checkbox();

            ?>

            <div style="color:white;margin:1em 0">
                If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
            </div>
            <div style="color:white;margin:1em 0">
                If you do not have an account, you can <?= Html::a('create it', ['site/signup']) ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
