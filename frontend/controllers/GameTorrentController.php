<?php

namespace frontend\controllers;

use Yii;
use frontend\models\GameTorrent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GameController implements the CRUD actions for Game model.
 */
class GameTorrentController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors () {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET','POST']
                ],
            ],
        ];
    }

    /**
     * Deletes an existing Game model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete ($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GameKey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GameTorrent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel ($id) {
        if (($model = GameTorrent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}