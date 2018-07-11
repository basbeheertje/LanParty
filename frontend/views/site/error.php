<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name . ' | ' . Yii::$app->name;

/** @var int $statusCode */
$statusCode = 0;
if (Yii::$app->errorHandler && Yii::$app->errorHandler->exception && Yii::$app->errorHandler->exception->statusCode) {
    $statusCode = (int)Yii::$app->errorHandler->exception->statusCode;
}

if (!$statusCode || $statusCode === 404) {
    echo $this->render(
        '404'
    );
} else {

    ?>
    <div class="site-error">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p>
            <?php echo Yii::t('frontend', 'The above error occurred while the Web server was processing your request.'); ?>
        </p>
        <p>
            <?php echo Yii::t('frontend', 'Please contact us if you think this is a server error. Thank you.'); ?>
        </p>

    </div>
    <?php

}

?>