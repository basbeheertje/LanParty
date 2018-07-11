<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use frontend\widgets\FloatingButtonWidget;
use frontend\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Games'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-view">
    <div class="row">
        <div class="col s12 m2 user-avatar">
            <img src="<?php echo $model->getAvatarLink(); ?>" width="100%"/>
        </div>
        <div class="col s12 m1">&nbsp;</div>
        <div class="col s12 m9 user-name">
            <h1><?php echo $model->username; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m2 user-info fieldset">
            <p>
                <a href="/profile/avatar" title="<?php echo Yii::t('frontend','Change avatar'); ?>">
                    <?php echo Yii::t('frontend', 'Change avatar'); ?>
                </a>
            </p>
            <p>
                <?php echo Yii::t('frontend', 'Member since:'); ?><?php echo date('Y-m-d', $model->created_at); ?>
            </p>
        </div>
        <div class="col s12 m1">&nbsp;</div>
        <div class="col s12 m9 user-games fieldset">
            <?php

            echo $this->render('_view/games', ['model' => $model]);

            ?>
        </div>
    </div>
</div>