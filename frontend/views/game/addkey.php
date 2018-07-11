<?php

use yii\helpers\Html;
use macgyer\yii2materializecss\widgets\form\ActiveForm;
use frontend\models\GameKey;

/* @var $this yii\web\View */
/* @var $model frontend\models\GameKey */
/* @var $form macgyer\yii2materializecss\widgets\form\ActiveForm */

$this->title = Yii::t('app', 'Add key');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Games'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="game-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="gamekey-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'key')->textInput() ?>

        <?= $form->field($model, 'note')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
