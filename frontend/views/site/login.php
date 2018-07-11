<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('frontend', 'Login') . " | " . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="avatar"<?php

    if(\common\models\User::hasAvatarCookie()){
        echo ' style="background:url(\''.\common\models\User::getAvatarCookie()->value.'\');background-position:center center;background-repeat:no-repeat;background-size:contain;"';
    }

    ?>></div>
    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?php

            echo $form->field($model, 'email')
                ->textInput(['autofocus' => true])
                ->input('text', ['placeholder' => Yii::t('frontend', "Email")])
                ->label(false);
            ?>

            <?php

            echo $form->field($model, 'password')
                ->passwordInput()
                ->input('password', ['placeholder' => Yii::t('frontend', 'Password')])
                ->label(false);
            ?>
            <div style="color:white;margin:1em 0">
                <?php echo Yii::t('frontend', 'If you forgot your password you can') . ' ' . Html::a(Yii::t('frontend', 'reset it'), ['site/request-password-reset']) ?>
                .
            </div>
            <div style="color:white;margin:1em 0">
                <?php echo Yii::t('frontend', 'If you do not have an account, you can') . " " . Html::a(Yii::t('frontend', 'create it'), ['site/signup']) ?>
                .
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
