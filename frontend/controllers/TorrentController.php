<?php

namespace frontend\controllers;

use yii\web\UploadedFile;
use frontend\models\TorrentForm;
use Yii;
use frontend\models\Torrent;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use frontend\models\TorrentDownload;

/**
 * ProfileController implements the CRUD actions for Game model.
 */
class TorrentController extends Controller {

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex () {
        $dataProvider = new ActiveDataProvider([
            'query' => Torrent::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a info for the model
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Exception
     */
    public function actionView ($id) {
        /** @var Torrent $model */
        $model = Torrent::find()->where(['id' => $id])->one();
        if (!$model) {
            return false;
        }
        /** @var TorrentDownload $download */
        $download = TorrentDownload::find()->where(['user_id' => Yii::$app->user->id, 'torrent_id' => $model->id])->one();
        if (!$download) {
            if(!Yii::$app->user->isGuest) {
                /** @var TorrentDownload $download */
                $download = new TorrentDownload();
                $download->torrent_id = $model->id;
                $download->user_id = Yii::$app->user->id;
                $download->created_by = Yii::$app->user->id;
                $download->created_at = time();
                $download->updated_at = time();
                if (!$download->save()) {
                    throw new Exception(Yii::t('frontend', 'Unable to save TorrentDownload!') . VarDumper::dumpAsString($download->getErrors()));
                }
            }
        }
        $path = $model->path;
        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path, $model->filename);
        }

        return false;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Torrent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel ($id) {
        if (($model = Torrent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
